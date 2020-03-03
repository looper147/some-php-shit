<?php
session_start();
require_once "config.php";
$fn_err="";
if(empty($_SESSION['loggedin'])){

}else{//if the user is logged in get all the info about him
    $studentid=$_SESSION["id"];
    $stmt=$mysqli->prepare("SELECT firstname,middlename,lastname,gender,class,dateofbirth FROM students WHERE studentid='$studentid'");//now we get the first name of this id and compare it with the one in the form if they match we tell the user its his current first name
    $stmt->execute();
    $res=$stmt->get_result();
    $response=$res->fetch_assoc();
    $db_firstname=$response["firstname"];
    $db_middlename=$response["middlename"];
    $db_lastname=$response["lastname"];
    $db_gender=$response["gender"];
    $db_class=$response["class"];
    $db_dateofbirth=$response["dateofbirth"];

    if(isset($_POST['submitfn'])){
        if(empty(trim($_POST['fn']))){
            $fn_err="<div class='alert alert-danger alert-dismissible' style='padding:4px'>
                        <button class='close'data-dismiss='alert' style='padding:4px'>&times</button>
                        Empty first name!
                    </div>";
        }else{
            $fn=trim($_POST["fn"]);
            if($db_firstname == $fn){
                $fn_err="<div class='alert alert-danger alert-dismissible' style='padding:3px'>
                        <button class='close'data-dismiss='alert' style='padding:4px'>&times</button>
                        This is your current first name!
                    </div>";
            }else{
                $stmt=$mysqli->prepare('UPDATE students SET firstname=? WHERE studentid=?');
                if($stmt ==FALSE){
                    $fn_err="Something went wrong please try again later!";
                }else{
                    $stmt->bind_param('si',$fn,$studentid);
                    $stmt->execute();
                    $stmt->close();
                    $mysqli->close();
                    $_SESSION['fn_success']="
                        <div class='alert alert-success alert-dismissible' style='padding:3px'>
                        <button class='close'data-dismiss='alert' style='padding:4px'>&times</button>
                        Your first name was changed successfully!<p style='color:black;font-weight:600'>Old first name: $db_firstname</p>
                        </div>";
                    header('location:profilecard.php');
                    exit();
                }
                
                
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
            if($db_middlename == $mn){
                $mn_err="<div class='alert alert-danger alert-dismissible' style='padding:3px'>
                        <button class='close'data-dismiss='alert' style='padding:4px'>&times</button>
                        This is your current middle name!
                    </div>";
            }else{
                $stmt=$mysqli->prepare('UPDATE students SET middlename=? WHERE studentid=?');
                if($stmt ==FALSE){
                    $mn_err="Something went wrong please try again later!";
                }else{
                    $stmt->bind_param('si',$mn,$studentid);
                    $stmt->execute();
                    $stmt->close();
                    $mysqli->close();
                    $_SESSION['mn_success']="
                        <div class='alert alert-success alert-dismissible' style='padding:3px'>
                        <button class='close'data-dismiss='alert' style='padding:4px'>&times</button>
                        Your middle name was changed successfully!<p style='color:black;font-weight:600'>Old middle name: $db_middlename</p>
                        </div>";
                    header('location:profilecard.php');
                    exit();
                }
                
                
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
            if($db_lastname == $ln){
                $ln_err="<div class='alert alert-danger alert-dismissible' style='padding:3px'>
                        <button class='close'data-dismiss='alert' style='padding:4px'>&times</button>
                        This is your current last name!
                    </div>";
            }else{
                $stmt=$mysqli->prepare('UPDATE students SET lastname=? WHERE studentid=?');
                if($stmt ==FALSE){
                    $ln_err="Something went wrong please try again later!";
                }else{
                    $stmt->bind_param('si',$ln,$studentid);
                    $stmt->execute();
                    $stmt->close();
                    $mysqli->close();
                    $_SESSION['ln_success']="
                        <div class='alert alert-success alert-dismissible' style='padding:3px'>
                        <button class='close'data-dismiss='alert' style='padding:4px'>&times</button>
                        Your last name was changed successfully!<p style='color:black;font-weight:600'>Old last name: $db_lastname</p>
                        </div>";
                    header('location:profilecard.php');
                    exit();
                }
                
                
            }
        }
    }
}

?>
<html>
    <head>
        <title>profile</title>

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
                input.style.border="none";//giving the input its border back
                save.style.display='none';//show the save button
                cancel.style.display='none';//show the cancel button
                edit.style.display='block';//show the edit button
            }
        </script>

        <!--css-->
        <style>
            table{
                margin:80;
            }
        </style>


    </head>
        <body>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                
                <table class="table table-stripped" style="width: 20%;" >
                    
                    <tr>
                        <th class="col-2">First name</th>
                        <td class="col-4"><input type="text" style="border: none;background: none;"id="fn"value="<?php echo $db_firstname;?>" name="fn"readonly></td>
                        <td class="col-1">
                            <button type="button" onclick="edit('fn','savefn','cancelfn','editfn')" style="border: none;background: none;" id='editfn'><i class="fas fa-edit" style="color:springgreen">Edit</i></button>
                        </td>
                        <td class="col-1">
                            <button type="button" onclick="cancel('fn','savefn','cancelfn','editfn')"style="display: none;" class="btn-danger" id='cancelfn'>Cancel</button>
                        </td>
                        <td class="col-1"><input type="submit" style="display: none;" class="btn-success" id="savefn"  name="submitfn" value="Save changes"></td>
                        <td class="col-3"><?php echo $fn_err;if(empty($_SESSION['fn_success'])){}else{echo $_SESSION['fn_success'];$_SESSION['fn_success']='';}?></td>
                    </tr>

                    <tr>
                        <th class="col-2">Middle name</th>
                        <td class="col-4"><input type="text" style="border: none;background: none;"id="mn"value="<?php echo $db_middlename;?>" name="mn"readonly></td>
                        <td class="col-1">
                            <button type="button" onclick="edit('mn','savemn','cancelmn','editmn')" style="border: none;background: none;" id='editmn'><i class="fas fa-edit" style="color:springgreen">Edit</i></button>
                        </td>
                        <td class="col-1">
                            <button type="button" onclick="cancel('mn','savemn','cancelmn','editmn')"style="display: none;" class="btn-danger" id='cancelmn'>Cancel</button>
                        </td>
                        <td class="col-1"><input type="submit" style="display: none;" class="btn-success" id="savemn"  name="submitmn" value="Save changes"></td>
                        <td class="col-3"><?php echo $mn_err;if(empty($_SESSION['mn_success'])){}else{echo $_SESSION['mn_success'];$_SESSION['mn_success']='';}?></td>
                    </tr>
                    
                    <tr>
                        <th class="col-2">Last name</th>
                        <td class="col-4"><input type="text" style="border: none;background: none;"id="ln"value="<?php echo $db_lastname;?>" name="ln"readonly></td>
                        <td class="col-1">
                            <button type="button" onclick="edit('ln','saveln','cancelln','editln')" style="border: none;background: none;" id='editln'><i class="fas fa-edit" style="color:springgreen">Edit</i></button>
                        </td>
                        <td class="col-1">
                            <button type="button" onclick="cancel('ln','saveln','cancelln','editln')"style="display: none;" class="btn-danger" id='cancelln'>Cancel</button>
                        </td>
                        <td class="col-1"><input type="submit" style="display: none;" class="btn-success" id="saveln"  name="submitln" value="Save changes"></td>
                        <td class="col-3"><?php echo $ln_err;if(empty($_SESSION['ln_success'])){}else{echo $_SESSION['ln_success'];$_SESSION['ln_success']='';}?></td>
                    </tr>
                    
                </table>
            </form>
            
        </body>
         
</html>