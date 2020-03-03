<?php
session_start();
if(isset($_SESSION['loggedin']) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
} else{
    $profilepic='default.jpg';
}
?>
<html>
    <head>
        <title>Registered succesfully!</title>
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

        <style>
            body{
                font-family: Arial, Helvetica, sans-serif;
            }
            .nav{
                font-family: Arial, Helvetica, sans-serif;
            }
        </style>
    </head>
        <body>
            <center>
                <!--navigation bar-->
                <nav class='nav'>
                    <div class='navbar navbar-expand-sm navbar-dark fixed-top' style='background:#222222'>
                        <ul class='nav navbar-nav'>
                            <li class='navbar-brand'>Rani Bazzi school</li>
                            <li class="nav-item dropdown">
                                <div class="dropdown">
                                    <a class="nav-link" data-toggle="dropdown" toggle-dropdown='dropdown' style='cursor:pointer;'>Guest<img src='uploads/<?php echo $profilepic;?>' width='40px'height='40px' class='rounded-circle'></a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="signup.php">Create new account</a>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item" ><a class="nav-link" href="home.php">HOME</a></li>
                            <li class="nav-item"><a class="nav-link btn-success active" href="login.php">Login</a></li>
                            <li class="nav-item"><a class="nav-link btn-primary" href="signup.php">Register now</a></li>
                        </ul>
                    </div>
                </nav>
                <br><br><br><br><br><br>
                <div class='alert alert-success'>
                <h3 class='alert-heading'>Registered successfully!</h3>
                <p>
                    Hello! thanks for registering!Your  info and credentials has been saved, proceed to the login page to login to your new account.
                </p>
                <br>    
                <a href='login.php'><button class="btn-success">OK</button></a>
                <div>
            </center>
        </body>
</html>