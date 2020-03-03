<?php
require_once "config.php";
$form_username=$_POST['username'];
$form_password=$_POST['password'];


$sql="SELECT username,password FROM studentsaccounts WHERE username=?";//checking if the username exist
$stmt=$mysqli->prepare($sql);
$stmt->bind_param("s",$form_username);
$stmt->execute();
$result=$stmt->get_result();
$response=$result->fetch_assoc();
$db_username=$response["username"];

$username_isempty=$password_isempty=false;
$username_exist=false;
$true_password=false;
if(isset($_POST["submit"])){
    if(empty(trim($form_username))){
        $username_isempty=true;
    }else{
            if($db_username==$form_username){//check if username exist
                $username_exist=true;
            }
    }
    if(empty(trim($form_password))){
        $password_isempty=true;
    }

    //if there are no problems
    if($username_exist==true && $password_isempty==false){
        $sql="SELECT accountid,password FROM studentsaccounts WHERE username=?";//check if the password is correct
        $stmt=$mysqli->prepare($sql);
        $stmt->bind_param("s",$form_username);
        $stmt->execute();
        $result=$stmt->get_result();
        $response=$result->fetch_assoc();
        $accountid=$response['accountid'];
        $db_password=$response['password'];
        if(password_verify($form_password,$db_password)){
            session_start();
            $_SESSION['loggedin']=true;
            $_SESSION['id']=$accountid;
            $_SESSION['username']=$form_username;
            $true_password=true;
        }
    }
        

    }



?>
<script>
    var username_isempty="<?php echo $username_isempty;?>";
    var password_isempty="<?php echo $password_isempty;?>";
    var username_exist="<?php echo $username_exist?>";
    var true_password="<?php echo $true_password;?>"
    $("#username,#password").removeClass("is-invalid");
    $("#username-feedback,#password-feedback").html("");
    if(username_isempty==true){
        $("#username").addClass("is-invalid");
        $("#username-feedback").html("Please enter your username!");
    }
    if(password_isempty==true){
        $("#password").addClass("is-invalid");
        $("#password-feedback").html("Please enter your password!");
    }
    if(username_exist==false && username_isempty==false){//if no username found
        $("#username").addClass("is-invalid");
        $("#username-feedback").html("No account found with that username!");
    }
    if(true_password==true  && username_exist==true){
        $("#password").addClass("is-valid");
        $("#username").addClass("is-valid");
        window.location.replace("home.php");

    }
    if(true_password==false  && username_exist==true && password_isempty==false){
        $("#password").addClass("is-invalid");
        $("#password-feedback").html("Wrong password!");
    }
    if(username_exist==true){
        $("#username").addClass("is-valid");
    }
</script>