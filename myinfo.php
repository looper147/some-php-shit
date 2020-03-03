<?php 
session_start();
require_once 'config.php';
$studentid=$_SESSION['id'];
if(empty($_SESSION['loggedin'])){
    header("location:home.php");
}else{
    $stmt=$mysqli->prepare("SELECT profilepic,username FROM studentsaccounts WHERE accountid=?");//selecting from studentsaccounts table
    $accountid=$_SESSION['id'];
    $stmt->bind_param('i',$accountid);
    $stmt->execute();
    $result=$stmt->get_result();
    $response=$result->fetch_assoc();
    $profilepic=$response['profilepic'];
    $username=$response['username'];
    $stmt=$mysqli->prepare("SELECT firstname,middlename,lastname,email,gender,class,address FROM students WHERE studentid=?");
    $stmt->bind_param('i',$accountid);
    $stmt->execute();
    $result2=$stmt->get_result();
    $response2=$result2->fetch_assoc();
    $email=$response2['email'];
    $firstname=$response2['firstname'];
    $middlename=$response2['middlename'];
    $lastname=$response2['lastname'];

}
$idforprof=$_SESSION['id'];
if (isset($_POST['upload'])){
    $file=$_FILES['file'];
    $fileName=$_FILES['file']['name'];
    $fileTmpName=$_FILES['file']['tmp_name'];
    $fileSize=$_FILES['file']['size'];
    $fileError=$_FILES['file']['error'];
    $fileType=$_FILES['file']['type'];

    $fileExtension = explode('.',$fileName);
    $fileActualExtension = strtolower(end($fileExtension));

    $allowed=array('jpg','jpeg','png','pdf');

    if (in_array($fileActualExtension,$allowed)){
        $_SESSION['file_err']='';
        if($fileError ===0){
            if($fileSize <1000000){
                $fileNameNew="profile".$idforprof.".".$fileActualExtension;
                $fileDestination='uploads/'.$fileNameNew;
                move_uploaded_file($fileTmpName,$fileDestination);
                $stmt=$mysqli->prepare("UPDATE studentsaccounts SET profilepic=? WHERE accountid=?");
                $profilepicname=$fileNameNew;
                $accountid=$_SESSION['id'];
                $stmt->bind_param('si',$profilepicname,$accountid);
                $stmt->execute();
                $_SESSION['file_err']="<div class='alert alert-success alert-dismissible'>
                                            <a class='close' data-dismiss='alert' style='cursor:pointer;'>&times</a>
                                            Uploaded successfully!
                                        </div>
                                                ";
                header("location:myinfo.php");
                exit();
                
                
                

            } else{
                $_SESSION['file_err']="<div class='alert alert-danger alert-dismissible'>
                                            <a class='close' data-dismiss='alert' style='cursor:pointer;'>&times</a>
                                            Your file is too big!
                                        </div>";
                header("location:myinfo.php");
                exit();
            }

        } else{
            $_SESSION['file_err']="<div class='alert alert-danger alert-dismissible'>
                                        <a data-dismiss='alert' class='close' style='cursor:pointer;'>&times</a>
                                   </div>
                                    Something went wrong!    ";
            
            header("location:myinfo.php");
            exit();
        }

    } else{
        $_SESSION['file_err']="<div class='alert alert-info alert-dismissible '>
                                    <a class='close' data-dismiss='alert' style='cursor:pointer;'>&times;</a>
                                    Select an image!
                                </div>";
        header("location:myinfo.php");
         exit();
    }

}

$fn_err="";
if(isset($_POST['submitfn'])){
    if(empty(trim($_POST['fn']))){
        $fn_err="<div class='alert alert-danger alert-dismissible' style='padding:4px'>
                    <button class='close'data-dismiss='alert' style='padding:4px'>&times</button>
                    Empty first name!
                </div>";
    }else{
        $fn=trim($_POST["fn"]);
        if($firstname == $fn){
            $fn_err="<div class='alert alert-danger alert-dismissible' style='padding:3px'>
                    <button class='close'data-dismiss='alert' style='padding:4px'>&times</button>
                    This is your current first name!
                </div>";
        }else{
            $studentid=$_SESSION['id'];
            $fn=trim($_POST["fn"]);
            $stmt=$mysqli->prepare('UPDATE students SET firstname=? WHERE studentid=?');
            $stmt->bind_param('si',$fn,$studentid);
            $stmt->execute();
            $stmt->close();
            $mysqli->close();
            $_SESSION['fn_success']="
                <div class='alert alert-success alert-dismissible' style='padding:3px'>
                <button class='close'data-dismiss='alert' style='padding:4px'>&times</button>
                Your first name was changed successfully!<br><b>Old first name: $firstname</b><br><b>New first name: $fn</b>
                </div>";
            header('location:myinfo.php');
            exit();
            
            
            
        }
    }
}
$mn_err="";
if(isset($_POST['submitmn'])){
    if(empty(trim($_POST['mn']))){
        $mn_err="<div class='alert alert-danger alert-dismissible' style='padding:4px'>
                    <button class='close'data-dismiss='alert' style='padding:4px'>&times</button>
                    Empty middle name!
                </div>";
    }else{
        $mn=trim($_POST["mn"]);
        if($middlename == $mn){
            $mn_err="<div class='alert alert-danger alert-dismissible' style='padding:3px'>
                    <button class='close'data-dismiss='alert' style='padding:4px'>&times</button>
                    This is your current middle name!
                </div>";
        }else{
            $studentid=$_SESSION['id'];
            $stmt=$mysqli->prepare('UPDATE students SET middlename=? WHERE studentid=?');
            
            $stmt->bind_param('si',$mn,$studentid);
            $stmt->execute();
            $stmt->close();
            $mysqli->close();
            $_SESSION['mn_success']="
                <div class='alert alert-success alert-dismissible' style='padding:3px'>
                <button class='close'data-dismiss='alert' style='padding:4px'>&times</button>
                Your middle name was changed successfully!<br><b>Old middle name: $middlename</b><br><b>New middle name: $mn</b>
                </div>";
            header('location:myinfo.php');
            exit();
            
            
            
        }
    }
}
$ln_err="";
if(isset($_POST['submitln'])){
    if(empty(trim($_POST['ln']))){
        $ln_err="<div class='alert alert-danger alert-dismissible' style='padding:4px'>
                    <button class='close'data-dismiss='alert' style='padding:4px'>&times</button>
                    Empty last name!
                </div>";
    }else{
        $ln=trim($_POST["ln"]);
        if($lastname == $ln){
            $ln_err="<div class='alert alert-danger alert-dismissible' style='padding:3px'>
                    <button class='close'data-dismiss='alert' style='padding:4px'>&times</button>
                    This is your current last name!
                </div>";
        }else{
            $studentid=$_SESSION['id'];
            $stmt=$mysqli->prepare('UPDATE students SET lastname=? WHERE studentid=?');
            
            $stmt->bind_param('si',$ln,$studentid);
            $stmt->execute();
            $stmt->close();
            $mysqli->close();
            $_SESSION['ln_success']="
                <div class='alert alert-success alert-dismissible' style='padding:3px'>
                <button class='close'data-dismiss='alert' style='padding:4px'>&times</button>
                Your last name was changed successfully!<br><b>Old last name: $lastname</b><br><b>New last name: $ln</b>
                </div>";
            header('location:myinfo.php');
            exit();
        
            
            
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>My info</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous"><!--link to font awesome library-->
         <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> 
        

        <script>
            function edit(input,save,cancel,edit){
                var input,save,cancel,edit;
                input=document.getElementById(input);//get the input element
                save=document.getElementById(save);//get the save changes button
                cancel=document.getElementById(cancel);//get the cancel  button
                edit=document.getElementById(edit);//get the edit button
                input.readOnly=false;//make the input not read only
                input.style.margin="-1px 0px 0px 21px";//move the input so it matches the readonly margin
                input.style.border="1px solid salmon";//giving the input its border back and with salmon color
                save.style.display='block';//show the save button
                cancel.style.display='block';//show the cancel button
                edit.style.display='none';//show the edit button
            }
            function cancel(input,save,cancel,edit){
                var input,save,cancel,edit;
                input=document.getElementById(input);//get the input element
                save=document.getElementById(save);//get the save changes button
                cancel=document.getElementById(cancel);//get the cancel  button
                edit=document.getElementById(edit);//get the edit button
                input.readOnly=true;//make the input not read only
                input.style.margin="auto";//set it back to default
                input.style.border="none";//giving the input its border back
                save.style.display='none';//show the save button
                cancel.style.display='none';//show the cancel button
                edit.style.display='block';//show the edit button
            }
            

        </script>

        <!--css-->
        <style>
            body{
                margin: 80;
                font-family: Arial, Helvetica, sans-serif;
            }
            nav{
                font-family: Arial, Helvetica, sans-serif;
            }
            #profilepic{
                opacity: 1;
                transition: 0.25s;
                cursor: pointer;
            }
            #profilepic:hover{
                opacity: 0.9;
            }
            .alert-success{
                width: 60%;
            }
            .alert-danger{
                width:60%;
                background:salmon;
                padding:7px;
            }
            
            
            .bg {
                animation:slide 3s ease-in-out infinite alternate;
                background-image: linear-gradient(-60deg, #6c3 50%, #09f 50%);
                bottom:0;
                left:-50%;
                opacity:.5;
                position:fixed;
                right:-50%;
                top:0;
                z-index:-1;
            }

            .bg2 {
                animation-direction:alternate-reverse;
                animation-duration:4s;
            }

            .bg3 {
                animation-duration:5s;
            }

            .content {
                background-color:rgba(255,255,255,.8);
                border-radius:.25em;
                box-shadow:0 0 .25em rgba(0,0,0,.25);
                box-sizing:border-box;
                left:50%;
                padding:10vmin;
                position:fixed;
                text-align:center;
                top:50%;
                transform:translate(-50%, -50%);
            }

            h1 {
                font-family:monospace;
            }

            @keyframes slide {
                0% {
                transform:translateX(-25%);
                }
            100% {
                transform:translateX(25%);
                }
            }
        </style>

    </head>
        <body>
            <div class="bg"></div>
            <div class="bg bg2"></div>
            <div class="bg bg3"></div>
            <!--navigation bar-->
            <nav class="nav">
                <div class="navbar navbar-expand-sm  navbar-dark fixed-top"style="background: #222222;">
                    <ul class="nav navbar-nav " >
                        <li class="navbar-brand">Rani Bazzi school</li>
                        <li class="nav-item dropdown">
                            <div class="dropdown">
                                <a data-toggle="dropdown" dropdown-toggle='dropdown' class="nav-link"><?php echo $username ?><img src="uploads/<?php echo $profilepic;?>" width="40px" height='40px'class="rounded-circle" style="cursor: pointer;"></a>
                                <div class="dropdown-menu">
                                    <a class='dropdown-header'><a class='dropdown-item' href='myinfo.php'><img src='uploads/<?php echo $profilepic;?>' width='80px'height='80px'class='rounded-circle'><span><?php echo $firstname," ",$middlename," ",$lastname;?></span></a></a>
                                    <a class="dropdown-item"><a href="changeemail.php" class="dropdown-item"><i class='fas fa-user'></i><?php echo $email;?></a></a>
                                </div>
                            </div>
                                
                        </li>
                        <li class="nav-item"><a href="home.php" class="nav-link">HOME</a></li>
                        <li class="nav-item dropdown">
                            <div class="dropdown">
                                <button class="nav-link dropdown-toggle btn active" data-toggle='dropdown' dropdown-toggle='dropdown'>Account settings</button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="changeemail.php">Change email</a>
                                    <a class="dropdown-item" href="changepassword.php">Change password</a>
                                    <a class="dropdown-item" href="myinfo.php">My info</a>
                                </div>
                            </div>
                        </li>
                        <li class='nav-item dropdown'>
                                        <div class='dropdown'>
                                            <button  class='nav-link dr btn-danger' data-toggle='dropdown'dropdown-toggle='dropdown' id='dropdown'>Logout</button>
                                            <div class='dropdown-menu'>
                                                <a class='dropdown-header'>Are you sure you wanna Logout?</a>
                                                <a class='dropdown-header'>   <a href='logout.php' class='btn-danger nav-link'>Logout</a>   <a href='#dropdown' class='btn-info nav-link'>Cancel</a>   </a>
                                            </div>
                                        </div>
                                        
                                    </li>";
                    </ul>
                </div>
            </nav>
            <br><br><br>
            
            <!--form-->
            <center>
                
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method='POST'enctype='multipart/form-data' class="form">
                <!--server validation-->
                <span class='help-block'>
                    <?php
                    if(empty($_SESSION['file_err'])){
                            
                    }else{
                        echo $_SESSION['file_err'];
                        $_SESSION['file_err']='';
                    }
                     
                     ?>
                </span>
                
                <img src="uploads/<?php echo $profilepic;?>" width="186px"height='186px' class="rounded-circle">
                <input type="file" name="file" id="file">
                <button type="submit" name="upload" class="btn-success">Upload</button>
                <br>
                <br>        
            </form>
            </center>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                <center>
                <?php echo $fn_err;echo $mn_err;echo $ln_err;if(empty($_SESSION['fn_success'])){}else{echo $_SESSION['fn_success'];$_SESSION['fn_success']='';};if(empty($_SESSION['mn_success'])){}else{echo $_SESSION['mn_success'];$_SESSION['mn_success']='';};if(empty($_SESSION['ln_success'])){}else{echo $_SESSION['ln_success'];$_SESSION['ln_success']='';}?>
                <table class="table table-stripped" style="width: 60%;" >
                    <caption style="caption-side: top;font-size: 18px;">Basic info</caption>
                    <tr>
                        <td class="col-2">First name</td>
                        <td class="col-4"><input type="text" style="border: none;background: none;"id="fn"value="<?php echo $firstname;?>" name="fn"readonly></td>
                        <td class="col-1">
                            <button type="button" onclick="edit('fn','savefn','cancelfn','editfn')" style="border: none;background: none;" id='editfn'><i class="fas fa-edit" style="color:springgreen">Edit</i></button>
                        </td>
                        <td class="col-1">
                            <button type="button" onclick="cancel('fn','savefn','cancelfn','editfn')"style="display: none;" class="btn-danger" id='cancelfn'>Cancel</button>
                        </td>
                        <td class="col-1"><input type="submit" style="display: none;" class="btn-success" id="savefn"  name="submitfn" value="Save changes"></td>
                    </tr>

                    <tr>
                        <td class="col-2">Middle name</td>
                        <td class="col-4"><input type="text" style="border: none;background: none;"id="mn"value="<?php echo $middlename;?>" name="mn"readonly></td>
                        <td class="col-1">
                            <button type="button" onclick="edit('mn','savemn','cancelmn','editmn')" style="border: none;background: none;" id='editmn'><i class="fas fa-edit" style="color:springgreen">Edit</i></button>
                        </td>
                        <td class="col-1">
                            <button type="button" onclick="cancel('mn','savemn','cancelmn','editmn')"style="display: none;" class="btn-danger" id='cancelmn'>Cancel</button>
                        </td>
                        <td class="col-1"><input type="submit" style="display: none;" class="btn-success" id="savemn"  name="submitmn" value="Save changes"></td>
                    </tr>
                    
                    <tr>
                        <td class="col-2">Last name</td>
                        <td class="col-4"><input type="text" style="border: none;background: none;"id="ln"value="<?php echo $lastname;?>" name="ln"readonly></td>
                        <td class="col-1">
                            <button type="button" onclick="edit('ln','saveln','cancelln','editln')" style="border: none;background: none;" id='editln'><i class="fas fa-edit" style="color:springgreen">Edit</i></button>
                        </td>
                        <td class="col-1">
                            <button type="button" onclick="cancel('ln','saveln','cancelln','editln')"style="display: none;" class="btn-danger" id='cancelln'>Cancel</button>
                        </td>
                        <td class="col-1"><input type="submit" style="display: none;" class="btn-success" id="saveln"  name="submitln" value="Save changes"></td>
                    </tr>
                    
                    <tr>
                        <td class="col-2">Student ID</td>
                        <td class="col-4"><span><?php echo $studentid;?></span></td>
                    </tr>
                </table>
                </center>
            </form>
        </body>
</html>