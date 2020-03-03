<?php
session_start();
if(!empty($_SESSION["loggedin"])){
    header("location:home.php");
}
$profilepic="default.jpg";

 ?>
<html>
    <head>
        <title>Log in</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/login.css" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous"><!--link to font awesome library-->
         <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

       



        <!--jquery and ajax-->
        <script>
            $(document).ready(function(){
                $("form").submit(function(event){
                    event.preventDefault();
                    var form_username,form_password,submit_button;
                    form_username=$("#username").val();
                    form_password=$("#password").val();
                    submit_button=$("#submit").val();
                    $.post("login_serverside.php",{
                        username:form_username,
                        password:form_password,
                        submit:submit_button
                    },function(data,status){
                        $("#load").html(data);
                    })
                })
            })
            function showpass(){
                var password;
                password=document.getElementById("password");
                if(password.type==="password"){
                    password.type="text";
                }else{
                    password.type="password";
                }
            }
        </script>
    </head>
        <body>
            <div class="bg"></div>
            <div class="bg bg2"></div>
            <div class="bg bg3"></div>
            
            <!--navbar-->
            <nav class="nav">
                <div class="navbar navbar-expand-sm  navbar-dark fixed-top" style="background: #222222;">
                    <ul class="nav navbar-nav">
                        <li class="navbar-brand">Rani Bazzi school</li>
                            <li class='nav-item dropdown'> <!--profile-->
                            <div class='dropdown'>
                                <a data-toggle='dropdown'dropdown-toggle='dropdown' class='nav-link'>Guest<img src='uploads/<?php echo $profilepic;?>' width='40px' height='40px'class='rounded-circle' style='cursor: pointer;'></a>
                                <div class='dropdown-menu'>
                                    <a class='dropdown-item'><a href='signup.php' class='dropdown-item'>Create a new account</a></a>
                                </div>
                            </div>
                        </li>
                      
                        <li class="nav-item" ><a class="nav-link" href="home.php">HOME</a></li>
                        <li class="nav-item"><a class="nav-link btn-success active" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link btn-primary" href="signup.php">Register now</a></li>

                    </ul>
                </div>
            </nav>
            <!--form-->
                
                    <div class="container" style="width: 50%">
                        <form action="login_serverside.php" method="post">
                                <h2 style="color: #138496;">Student login</h2>
                                <br>
                                <b>Don't have an account?<a href='signup.php'>Register now</a> or <a href='home.php'>continue as a guest</a>.</b>
                                <br>
                                <br>
                                <i class="fas fa-user">Username</i>                               
                                    <input type="text" id="username"name='username'  placeholder='Username' class="form-control" autocomplete="on">
                                    <span id="username-feedback" style="color: red;"></span>
                                <br>

                                <i class="fas fa-key">Password</i>
                                    <input type='password' id='password'name='password' placeholder='Password' class="form-control" autocomplete="on">
                                    <span id="password-feedback" style="color: red;"></span>
                                <br>
                                <input type="checkbox" onclick="showpass()" id="showpassword">  <label for="showpassword">Show password</label>   
                                <div id="load">
                                
                                </div>
                                
                                <br>
                                <br>
                                <button type="submit" id="submit" name="submit" class="btn-success">Login</button>
                                <br>
                                <br>
                               
                                  
                        </form>
                    </div>  
                        <br>
                    
                    
            
        </body>
</html>