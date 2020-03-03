<?php
session_start();
if(empty($_SESSION['loggedin'])){
    
}else{
    require_once 'config.php';
    $accountid=$_SESSION['id'];
    $stmt=$mysqli->prepare("SELECT profilepic,username FROM studentsaccounts WHERE accountid='$accountid'");
    $stmt->execute();
    $result=$stmt->get_result();
    $response=$result->fetch_assoc();
    $profilepic=$response['profilepic'];
    $username=$response['username'];
    
    $stmt=$mysqli->prepare("SELECT firstname,middlename,lastname,email,gender,class FROM students where studentid='$accountid'");
    $stmt->execute();
    $res=$stmt->get_result();
    $resp=$res->fetch_assoc();
    $email=$resp['email'];
    $firstname=$resp['firstname'];
    $middlename=$resp['middlename'];
    $lastname=$resp['lastname'];
}
?>
<html>
    <head>
        <title>Welcome</title>
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
        



        <!--css-->
        <style>
            body{
                margin: 80;
                font-family: Arial, Helvetica, sans-serif;
            }
            nav{
                font-family: Arial, Helvetica, sans-serif;
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
            
                <nav class='nav'>

                    <div class='navbar navbar-expand-sm  navbar-dark fixed-top' style="background: #222222;">
                        <ul class='nav navbar-nav'>
                            <?php //check if the user is logged in,if not show loging register buttons
                                if(empty($_SESSION['loggedin'])){
                                    $profilepic='default.jpg';
                                    echo "
                                    <li class='navbar-brand'>Rani Bazzi school</li>
                                    <li class='nav-item dropdown'> <!--profile-->
                                        <div class='dropdown'>
                                            <a data-toggle='dropdown'dropdown-toggle='dropdown' class='nav-link'>Guest<img src='uploads/$profilepic' width='40px' height='40px'class='rounded-circle' style='cursor: pointer;'></a>
                                            <div class='dropdown-menu'>
                                                <a class='dropdown-item'><a href='signup.php' class='dropdown-item'>Create a new account</a></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class='nav-item '><a class='nav-link active' href='home.php'>HOME</a></li>
                                    <li class='nav-item'><a class='nav-link btn-success' href='login.php'>Login</a></li>
                                    <li class='nav-item'><a class='nav-link btn-primary' href='signup.php'>Register now</a></li>";
                                } else{
                                    echo "
                                    <li class='navbar-brand'>Rani Bazzi school</li><!--logo-->
                                    <li class='nav-item dropdown'> <!--profile-->
                                        <div class='dropdown'>
                                            <a data-toggle='dropdown'dropdown-toggle='dropdown' class='nav-link'>$username<img src='uploads/$profilepic' width='40px' height='40px'class='rounded-circle' style='cursor: pointer;'></a>
                                            <div class='dropdown-menu'>
                                                <a class='dropdown-header'><a href='myinfo.php' class='dropdown-item'><img src='uploads/$profilepic' width='80px' height='80px'class='rounded-circle' style='cursor: pointer;'>$firstname $middlename $lastname</a></a>
                                                <a class='dropdown-item'><a href='changeemail.php' class='dropdown-item'><i class='fas fa-user'></i>$email</a></a>
                                            </div>
                                        </div>
                                    </li>
                                    
                                    <li class='nav-item '><a class='nav-link active' href='home.php'>HOME</a></li>
                                    
                                    <li class='nav-item dropdown'>
                                        <div class='dropdown'>
                                            <button dropdown-toggle='dropdown'data-toggle='dropdown' class='nav-link dropdown-toggle btn '>Account settings</button>
                                            <div class='dropdown-menu'>
                                                <a class='dropdown-item' href='changeemail.php'>Change email</a>
                                                <a class='dropdown-item' href='changepassword.php'>Change password</a>
                                                <a class='dropdown-item' href='myinfo.php'>My info</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class='nav-item dropdown'>
                                        <div class='dropdown'>
                                            <button  class='nav-link dr btn-danger' data-toggle='dropdown'dropdown-toggle='dropdown' id='dropdown'>Logout</button>
                                            <div class='dropdown-menu'>
                                                <a class='dropdown-header'>Are you sure you wanna Logout?</a>
                                                <a class='dropdown-header'><a href='logout.php' class='btn-danger nav-link'>Logout</a> <a href='#dropdown' class='btn-info nav-link'>Cancel</a> </a>
                                            </div>
                                        </div>
                                        
                                    </li>";
                                }
                            ?>

                                
                            </ul>
                    </div>
                </nav>
            
            
        </body>
</html>