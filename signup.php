<?php
session_start();
if(!empty($_SESSION['loggedin'])){
    header("location:home.php");
}


?>
<html>
    <head>
        <title>Register now!</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet"href="css/signup.css"> 
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
            $(document).ready(function(){
                $("form").submit(function(event){
                    var firstname,middlename,lastname,registerbutton,date,the_class,address,gender,email,username,newpassword,confirmpassword;
                    event.preventDefault();

                    firstname=$("#firstname").val();
                    middlename=$("#middlename").val();
                    lastname=$("#lastname").val();
                    registerbutton=$("#register").val();
                    date=$("#date").val();
                    the_class=$("#class").val();
                    address=$("#address").val();
                    gender=$("#gender").val();
                    email=$("#email").val();
                    username=$("#username").val();
                    newpassword=$("#newpassword").val();
                    confirmpassword=$("#confirmpassword").val();
                    $.post("signup_serverside.php",{
                    firstname:firstname,
                    middlename:middlename,
                    lastname:lastname,
                    registerbutton:registerbutton,
                    dateofbirth:date,
                    formclass:the_class,
                    address:address,
                    gender:gender,
                    email:email,
                    username:username,
                    confirmpassword:confirmpassword,
                    newpassword:newpassword
                    },function(data){
                        $("#load").html(data);
                    })
                })
                
            })

            function showpass(){
                var newpassword,confirmpassword;
                newpassword=document.getElementById("newpassword");
                confirmpassword=document.getElementById("confirmpassword");
                if(newpassword.type === "password" && confirmpassword.type === "password"){
                    newpassword.type="text";
                    confirmpassword.type = "text";
                }else{
                    newpassword.type="password";
                    confirmpassword.type ="password"
                }
            }
        </script>




    </head>
        <body>
            <div class="bg"></div>
            <div class="bg bg2"></div>
            <div class="bg bg3"></div>
            
            <!--navbar-->
            <nav class='nav'>
                <div class="navbar navbar-expand navbar-dark fixed-top" style='background:#222222' >
                    <ul class="nav navbar-nav">
                        <li class="navbar-brand">Rani Bazzi school</li>
                        <?php
                        if(empty($_SESSION['loggedin'])){
                            $profilepic='default.jpg';
                            echo"<li class='nav-item dropdown'> <!--profile-->
                            <div class='dropdown'>
                                <a data-toggle='dropdown'dropdown-toggle='dropdown' class='nav-link'>Guest<img src='uploads/$profilepic' width='40px' height='40px'class='rounded-circle' style='cursor: pointer;'></a>
                                <div class='dropdown-menu'>
                                    <a class='dropdown-item'><a href='signup.php' class='dropdown-item'>Create a new account</a></a>
                                </div>
                            </div>
                        </li>";
                        }
                        ?>
                        <li class="nav-item"><a class="nav-link" href="home.php">HOME</a></li>
                        <li class="nav-item"><a class="nav-link btn-success" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link btn-primary active" href="signup.php">Register now</a>
                    </ul>
                </div>
            </nav>
                    <br>
                    <br>
                        <div class="container" style="width: 50%">
                            <form method="POST" action="signup_serverside.php">
                                
                                    <br>
                                    <br>
                                    <h2 style="color: #138496;">Student Registeration Form</h2>
                                    <br>
                                    <b>Already registered?<a href='login.php'>Login</a> or you can <a href='home.php'>Continue As a Guest</a>.</b>
                                    <br>
                                    <br>
                                    <br>
                                        <i class="fas fa-address-card fa-1x">Full Name</i>
                                        <!--firstname-->
                                        <input type='text' name='firstname'  placeholder='First name'class='form-control' id="firstname">
                                        <span id="fn_feedback"></span>
                                        <!--middlename-->
                                        <input type='text' name='middlename'  placeholder='Middle name'class='form-control' id="middlename">
                                        <span id="mn_feedback"></span>
                                        <!--lastname-->
                                        <input type='text' name='lastname'  placeholder='Last name'class='form-control' id="lastname">
                                        <span id="ln_feedback"></span>
                                        <br>
                                        <br>
                                        <br>
                                        <!--birthday-->
                                        <i class="fas fa-birthday-cake">Date of birth</i>
                                        <input type='date' name='date' id="date" class='form-control'max="2006-12-30" min="1995-12-30">
                                        <span id="dob_feedback"></span>
                                        <br>
                                        <br>
                                        <!--class-->
                                        <i class="fa fa-book-reader">Class</i>
                                        <span id="class_feedback"></span>
                                        <select name='class' id="class" class='form-control' >
                                            <option selected disabled>Select your class</option>
                                            <option>Accounting and informatics</option>
                                            <option>Assistant Accountant</option>
                                            <option>Building electrician</option>
                                            <option>Car mechanics</option>
                                            <option>Child care</option>
                                            <option>Cook</option>
                                            <option>Computer programming and development</option>
                                            <option>Decor</option>
                                            <option>Electronics</option>
                                            <option>General electricity</option>
                                            <option>Graphic design</option>
                                            <option>Heating,ventilating and air conditioning</option>
                                            <option>Health observer</option>
                                            <option>Hotel</option>
                                            <option>Nurse</option>
                                            <option>Nurse aide</option>
                                            <option>Sale and commercial relations</option>
                                        </select>
                                        <br>
                                        <br>
                                        <!--Address-->
                                        <i class="fas fa-map-marked-alt">Current Address</i>
                                        <input type='text' name='address' id="address"  placeholder='Your current address'class='form-control'>
                                        <span id="address_feedback"></span>
                                        <br>
                                        <br>
                                        <!--Gender-->
                                        <i class="fas fa-venus-mars">Gender</i>
                                        <select class="form-control" name="gender" id="gender">
                                            <option selected disabled>Pick your gender</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                            <option>Other</option>
                                        </select>
                                        <span id="gender_feedback"></span>
                                        <br>
                                        <br>
                                        <!--email-->
                                        <i class="fas fa-envelope-open-text">E-mail</i>
                                        <input type='email' name="email" id="email"  placeholder='Enter your e-mail'class='form-control'><!--email-->
                                        <span id="email_feedback"></span>
                                        <br>
                                        <br>
                                        <!--Username-->
                                        <i class="fas fa-user">Username</i>
                                        <input type='text' name='username' id="username"  placeholder='New Username'class='form-control'><!--username-->
                                        <span id="username_feedback"></span>
                                        <br>
                                        <br>
                                        <!--New password-->
                                        <i class="fa fa-key">New Password</i>
                                        <input type='password' name='password' id='newpassword' placeholder='Enter your new password'class='form-control'> <!--password-->
                                        <span id="newpassword_feedback"></span>
                                        <br>
                                        <!--confirm password-->
                                        <i class="fas fa-lock">Confirm Password</i>
                                        <input type='password' name='confirm_password' id='confirmpassword' placeholder='Confirm your password'class='form-control'> <!--confirmpassword-->
                                        <span id="confirmpassword_feedback"></span>
                                        
                                        <input type="checkbox" onclick="showpass()" id="showpassword">  <label for="showpassword">Show passwords</label>   
                                        <br>     
                                        <button type='submit' id="register" name="register"class="btn-primary" >Register</button>
                                        <br>
                                        
                                    
                                </form>
                            </div>
                                <br>
                                <br>    
                        
                        <p id="load"></p>
        </body>
</html>