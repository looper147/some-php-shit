<?php

$form_fn=trim($_POST["firstname"]);
$form_mn=trim($_POST["middlename"]);
$form_ln=trim($_POST["lastname"]);
$form_dob=trim($_POST["dateofbirth"]);
$form_class=trim($_POST["formclass"]);
$form_address=trim($_POST["address"]);
$form_gender=trim($_POST["gender"]);
$form_email=trim($_POST["email"]);
$form_username=trim($_POST["username"]);
$form_newpassword=trim($_POST["newpassword"]);
$form_confirmpassword=trim($_POST["confirmpassword"]);
$email_exist=false;
$username_exist=false;
$passwords_dontmatch=false;
$account_created=false;
require_once "config.php";
$sql="SELECT email FROM students WHERE email=?";
$stmt=$mysqli->prepare($sql);
$stmt->bind_param("s",$form_email);
$stmt->execute();
$result=$stmt->get_result();
$response=$result->fetch_assoc();
$db_email=$response["email"];
if(!empty(trim($db_email))){
    $email_exist=true;
}
$sql="SELECT username FROM studentsaccounts WHERE username=?";
$stmt=$mysqli->prepare($sql);
$stmt->bind_param("s",$form_username);
$stmt->execute();
$result=$stmt->get_result();
$response=$result->fetch_assoc();
$db_username=$response["username"];
if(!empty(trim($db_username))){
    $username_exist=true;
}


$fn_isempty=$mn_isempty=$ln_isempty=$dob_isempty=$class_isempty=$address_isempty=$gender_isempty=$email_isempty=$username_isempty=$newpassword_isempty=$confirmpassword_isempty=false;
if(isset($_POST["registerbutton"])){
    if(empty(trim($form_fn))){
        $fn_isempty=true;
    }
    if(empty(trim($form_mn))){
        $mn_isempty=true;
    }
    if(empty(trim($form_ln))){
        $ln_isempty=true;
    }
    if(empty(trim($form_dob))){
        $dob_isempty=true;
    }
    if(empty(trim($form_class))){
        $class_isempty=true;
    }
    if(empty(trim($form_address))){
        $address_isempty=true;
    }
    if(empty(trim($form_gender))){
        $gender_isempty=true;
    }
    if(empty(trim($form_email))){
        $email_isempty=true;
    }
    if(empty(trim($form_username))){
        $username_isempty=true;
    }
    if(empty(trim($form_newpassword))){
        $newpassword_isempty=true;
    }
    if(empty(trim($form_confirmpassword))){
        $confirmpassword_isempty=true;
    }
    if(trim($form_newpassword)!=trim($form_confirmpassword)){
        $passwords_dontmatch=true;
    }

    //if everything is okay
    if($fn_isempty==false && $mn_isempty==false && $ln_isempty==false && $dob_isempty==false && $class_isempty==false && $address_isempty==false && $gender_isempty==false && $email_isempty==false && $username_isempty==false && $newpassword_isempty==false && $confirmpassword_isempty==false && $username_exist==false && $email_exist==false && $passwords_dontmatch==false){//if nothing is empty and email doesn't exist and username is not taken
        $sql="INSERT INTO students(firstname,middlename,lastname,gender,dateofbirth,address,class,email)VALUES(?,?,?,?,?,?,?,?)";//insert all the info into the students table
        $stmt=$mysqli->prepare($sql);
        $stmt->bind_param("ssssssss",$form_fn,$form_mn,$form_ln,$form_gender,$form_dob,$form_address,$form_class,$form_email);
        $stmt->execute();
        
        $sql2="INSERT INTO studentsaccounts(username,password)VALUES(?,?)";
        $stmt2=$mysqli->prepare($sql2);
        $new_password=password_hash($form_newpassword,PASSWORD_DEFAULT);//hash the password before inserting it to the db
        $stmt2->bind_param("ss",$form_username,$new_password);
        $stmt2->execute();
        $account_created=true;
    }
}

?>
<script>
    var fn_isempty,mn_isempty,ln_isempty,dob_isempty,class_isempty,address_isempty,gender_isempty,email_isempty,email_exist,username_isempty,username_exist,newpassword_isempty,confirmpassword_isempty,passwordsdontmatch,account_created;
    fn_isempty="<?php echo $fn_isempty;?>";
    mn_isempty="<?php echo $mn_isempty;?>";
    ln_isempty="<?php echo $ln_isempty;?>";
    dob_isempty="<?php echo $dob_isempty;?>";
    class_isempty="<?php echo $class_isempty;?>";
    address_isempty="<?php echo $address_isempty ?>";
    gender_isempty="<?php echo $gender_isempty;?>"
    email_isempty="<?php echo $email_isempty ;?>";
    email_exist="<?php echo $email_exist;?>";
    username_isempty="<?php echo $username_isempty;?>";
    username_exist="<?php echo $username_exist;?>";
    newpassword_isempty="<?php echo $newpassword_isempty;?>";
    confirmpassword_isempty="<?php echo $confirmpassword_isempty;?>";
    passwordsdontmatch="<?php echo $passwords_dontmatch; ?>";
    account_created="<?php echo $account_created;?>"
    $("#firstname,#middlename,#lastname,#date,#class,#address,#gender,#email,#username,#newpassword,#confirmpassword").removeClass("is-invalid");
    $("#fn_feedback,#mn_feedback,#ln_feedback,#dob_feedback,#class_feedback,#address_feedback,#gender_feedback,#email_feedback,#username_feedback,#newpassword_feedback,#confirmpassword_feedback").html("");
    if(fn_isempty==true){
        $("#firstname").addClass("is-invalid");
        $("#fn_feedback").html("Please enter your first name!");
    }else{
        $("#firstname").addClass("is-valid");
    }
    if(mn_isempty==true){
        $("#middlename").addClass("is-invalid");
        $("#mn_feedback").html("Please enter your middle name!");
    }else{
        $("#middlename").addClass("is-valid");
    }
    if(ln_isempty==true){
        $("#lastname").addClass("is-invalid");
        $("#ln_feedback").html("Please enter your last name!");
    }else{
        $("#lastname").addClass("is-valid");
    }
    if(dob_isempty==true){
        $("#date").addClass("is-invalid");
        $("#dob_feedback").html("Please choose your dob!");
    }else{
        $("#date").addClass("is-valid");
    }
    if(class_isempty==true){
        $("#class").addClass("is-invalid");
        $("#class_feedback").html("Please select your class!");
    }else{
        $("#class").addClass("is-valid");
    }
    if(address_isempty==true){
        $("#address").addClass("is-invalid");
        $("#address_feedback").html("Please enter your current address!");
    }else{
        $("#address").addClass("is-valid");
    }
    if(gender_isempty==true){
        $("#gender").addClass("is-invalid");
        $("#gender_feedback").html("Please pick your gender!");
    }else{
        $("#gender").addClass("is-valid");
    }
    if(email_isempty==true){
        $("#email").addClass("is-invalid");
        $("#email_feedback").html("Please enter your e-mail!");
    }
    if(email_exist==false && email_isempty==false){
        $("#email").addClass("is-valid");
    }
    if(email_exist==true){
        $("#email").addClass("is-invalid");
        $("#email_feedback").html("This e-mail is already registered with another account!");
    }
    if(username_isempty==true){
        $("#username").addClass("is-invalid");
        $("#username_feedback").html("Please enter a username!");
    }
    if(username_exist==false && username_isempty==false){
        $("#username").addClass("is-valid");
    }
    if(username_exist==true){
        $("#username").addClass("is-invalid");
        $("#username_feedback").html("This username is taken!");
    }
    if(newpassword_isempty==true && confirmpassword_isempty==true){
        $("#newpassword").addClass("is-invalid");
        $("#newpassword_feedback").html("Please enter a password!");
        
    }
    if(newpassword_isempty==false && confirmpassword_isempty==true){
        $("#confirmpassword").addClass("is-invalid");
        $("#confirmpassword_feedback").html("Please confirm your password!");
    }
    if(newpassword_isempty==false && confirmpassword_isempty==false && passwordsdontmatch==true){
        $("#confirmpassword").addClass("is-invalid");
        $("#confirmpassword_feedback").html("Confirmed password don't match!");
    }

    if(account_created==true){
        window.location.replace("infosavedpopup.php")
    }
</script>