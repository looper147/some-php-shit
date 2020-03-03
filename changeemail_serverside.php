<?php
session_start();
require_once "config.php";
$formemail=trim($_POST["newemail"]);
$formpassword=trim($_POST["password"]);
$newemail_isempty=$password_isempty=$email_exist=$is_currentemail=$true_password=$email_changed=false;
$studentid=$_SESSION["id"];


$sql="SELECT email FROM students WHERE studentid=?";//check if the email entered is the current email
$stmt=$mysqli->prepare($sql);
$stmt->bind_param("i",$studentid);
$stmt->execute();
$result=$stmt->get_result();
$response=$result->fetch_assoc();
$db_email=$response["email"];
$sql2="SELECT email FROM students WHERE email=?";//check if the email entered exist
$stmt2=$mysqli->prepare($sql2);
$stmt2->bind_param("s",$formemail);
$stmt2->execute();
$result2=$stmt2->get_result();
$response2=$result2->fetch_assoc();
$db_emails=$response2["email"];

if(isset($_POST["change"])){
    if(empty($formemail)){
        $newemail_isempty=true;
    }else{
        if($formemail==$db_emails){
        $email_exist=true;//check if the email entered exist
        }
        if($formemail==$db_email){
            $is_currentemail=true;//check if the email entered is the current email
        }
        }
    if(empty($formpassword)){
        $password_isempty=true;
    }
    $sql="SELECT password FROM studentsaccounts WHERE accountid=?";//verifying password

    $stmt=$mysqli->prepare($sql);
    $stmt->bind_param("i",$studentid);
    $stmt->execute();
    $result=$stmt->get_result();
    $response=$result->fetch_assoc();
    $db_password=$response["password"];
    if(password_verify($formpassword,$db_password)){//verifying password
        $true_password=true;
    }
    
    //if the password is correct and everything is good changing the email
    if($true_password==true && $newemail_isempty==false && $password_isempty==false && $email_exist==false && $is_currentemail==false){
        $sql="UPDATE students SET email=? WHERE studentid=?";
        $stmt=$mysqli->prepare($sql);
        $stmt->bind_param("ss",$formemail,$studentid);
        $stmt->execute();
        $email_changed=true;
        
    }

}
?>
<script>
    var newemail_isempty,password_isempty,is_currentemail,email_exist,true_password,email_changed;
    newemail_isempty="<?php echo $newemail_isempty;?>";
    password_isempty="<?php echo $password_isempty;?>";
    is_currentemail="<?php echo $is_currentemail;?>";
    email_exist="<?php echo $email_exist;?>";
    true_password="<?php echo $true_password;?>";
    email_changed="<?php echo $email_changed;?>";

    $("#newemail,#password").removeClass("is-invalid is-valid");
    $("#newemail_feedback,#password_feedback").html("");

    if(newemail_isempty==true){
        $("#newemail").addClass("is-invalid");
        $("#newemail_feedback").html("Please enter an E-mail!");
    }
    if(password_isempty==true){
        $("#password").addClass("is-invalid");
        $("#password_feedback").html("Please enter your password!");
    }
    if(is_currentemail==true){
        $("#newemail").addClass("is-invalid");
        $("#newemail_feedback").html("This is your current E-mail!");
    }
    if(email_exist==true && newemail_isempty==false && is_currentemail==false){
        $("#newemail").addClass("is-invalid");
        $("#newemail_feedback").html("This E-mail is already registered with another account!");
    }
    if(true_password==true && password_isempty==false && newemail_isempty==false){
        $("#password").addClass("is-valid");
    }
    if(password_isempty==false && true_password==true){
        $("#password").addClass("is-valid");
    }
    if(email_exist==false && newemail_isempty==false && password_isempty==false && true_password==false){
        $("#password").addClass("is-invalid");
        $("#password_feedback").html("Wrong password!");
    }
    if(email_exist==false && is_currentemail==false){
        $("#newemail").addClass("is-valid");
    }
    
    if(password_isempty==false && true_password==false){
        $("#password").addClass("is-invalid");
        $("#password_feedback").html("Wrong password!");
    }
    if(email_changed==true){
        $("#newemail").addClass("is-valid");
        $("#password").addClass("is-valid");
        $("#newemail").val("");
        $("#password").val("");
        $("body").prepend("<div class='alert alert-success alert-dismissible'><button class='close' data-dismiss='alert'>&times</button><h5 class='alert-heading'>E-mail changed successfully!</h5><br>Old E-mail:<?php echo $db_email;?><br>New E-mail:<?php echo $formemail;?></div>");
        
    }
</script>