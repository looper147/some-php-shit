<?php
session_start();

require_once "config.php";
$accountid=$_SESSION["id"];
$formoldpassword=trim($_POST["oldpassword"]);
$formnewpassword=trim($_POST["newpassword"]);
$formconfirmpassword=trim($_POST["confirmpassword"]);
$oldpassword_isempty=$newpassword_isempty=$confirmpassword_isempty=$passwords_dontmatch=$true_password=$password_changed=$iscurrent_password=false;
if(isset($_POST["submit"])){
    if(empty($formoldpassword)){
        $oldpassword_isempty=true;
    }
    if(empty($formnewpassword)){
        $newpassword_isempty=true;
    }
    if(empty($formconfirmpassword)){
        $confirmpassword_isempty=true;
    }

    if($formnewpassword!=$formconfirmpassword){
        $passwords_dontmatch=true;
    }
    if($oldpassword_isempty==false){//verify password
        $sql="SELECT password FROM studentsaccounts WHERE accountid=?";
        $stmt=$mysqli->prepare($sql);
        $stmt->bind_param("i",$accountid);
        $stmt->execute();
        $result=$stmt->get_result();
        $response=$result->fetch_assoc();
        $db_password=$response["password"];
        $new_password=password_hash($formnewpassword,PASSWORD_DEFAULT);
        if(password_verify($formoldpassword,$db_password)){
            $true_password=true;
        }

    }
    if($passwords_dontmatch==false && $newpassword_isempty==false && $confirmpassword_isempty==false){
        if(password_verify($formnewpassword,$db_password)){
            $iscurrent_password=true;
        }
    }
    
    //if no problems update the password
    if($true_password==true && $passwords_dontmatch==false && $newpassword_isempty==false && $confirmpassword_isempty==false && $iscurrent_password==false){
        $sql="UPDATE studentsaccounts SET password=? WHERE accountid=?";
        $stmt=$mysqli->prepare($sql);
        $stmt->bind_param("si",$new_password,$accountid);
        $stmt->execute();
        $password_changed=true;
    }
}


?>
<script>
    var oldpassword_isempty="<?php echo $oldpassword_isempty;?>";
    var newpassword_isempty="<?php echo $newpassword_isempty;?>";
    var confirmpassword_isempty="<?php echo $confirmpassword_isempty;?>";
    var passwords_dontmatch="<?php echo $passwords_dontmatch; ?>";
    var true_password="<?php echo $true_password; ?>";
    var password_changed="<?php echo $password_changed; ?>";
    var iscurrent_password="<?php echo $iscurrent_password; ?>"

    $("#oldpassword,#newpassword,#confirmpassword").removeClass("is-invalid is-valid");
    $("#oldpassword_feedback,#newpassword_feedback,#confirmpassword_feedback").html("");

    if(oldpassword_isempty==true){
        $("#oldpassword").addClass("is-invalid");
        $("#oldpassword_feedback").html("Please enter your current password!");
    }
    if(newpassword_isempty==true){
        $("#newpassword").addClass("is-invalid");
        $("#newpassword_feedback").html("Please enter a new password!");
    }
    if(confirmpassword_isempty==true && newpassword_isempty==false){
        $("#confirmpassword").addClass("is-invalid");
        $("#confirmpassword_feedback").html("Please confirm your password!");
    }
    if(passwords_dontmatch==true && newpassword_isempty==false && confirmpassword_isempty==false){
        $("#confirmpassword").addClass("is-invalid");
        $("#confirmpassword_feedback").html("Confirmed passowrd don't match!");
        $("#show").click();
    }
    if(true_password==true && oldpassword_isempty==false){
        $("#oldpassword").addClass("is-valid");
    }
    if(true_password==false && oldpassword_isempty==false){
        $("#oldpassword").addClass("is-invalid");
        $("#oldpassword_feedback").html("Wrong password!");
    }
    if(passwords_dontmatch==false && newpassword_isempty==false && oldpassword_isempty==false){
        $("#newpassword").addClass("is-valid");
        $("#confirmpassword").addClass("is-valid");
    }
    
    if(iscurrent_password==true){
        $("#newpassword").addClass("is-invalid");
        $("#newpassword_feedback").html("This is your current password!");
        
    }
    if(password_changed==true){
        $("body").prepend("<div class='alert alert-success alert-dismissible'><button class='close' data-dismiss='alert'>&times</button>Password changed successfuly!</div>");
        $("#oldpassword,#newpassword,#confirmpassword").val("");
    }
</script>