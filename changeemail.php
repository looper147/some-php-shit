<?php
session_start();
if (empty($_SESSION["loggedin"])) {
    header("location:home.php");
}
$id =  $_SESSION['id'];
require_once 'config.php';
$sql = "SELECT username,profilepic FROM studentsaccounts WHERE accountid = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$response = $result->fetch_assoc();

$query = "SELECT firstname,middlename,lastname,email FROM students WHERE studentid = ?";
$statement = $mysqli->prepare($query);
$statement->bind_param('i', $id);
$statement->execute();
$conclusion = $statement->get_result();
$output = $conclusion->fetch_assoc();

$username = $response['username'];
$profilepic = $response['profilepic'];
$email = $output['email'];
$firstname = $output['firstname'];
$middlename = $output['middlename'];
$lastname = $output['lastname'];
?>
<html>

<head>
    <title>Change email</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <!--link to font awesome library-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


    <script>
        $(document).ready(function() {
            $("form").submit(function(event) {
                event.preventDefault();
                var newemail, password;
                newemail = $("#newemail").val();
                password = $("#password").val();
                change = $("#change").val();
                $.post("changeemail_serverside.php", {
                    newemail: newemail,
                    password: password,
                    change: change
                }, function(data) {
                    $("#load").html(data);
                })
            })
        })




        function showpassword() {
            var password;
            password = document.getElementById('password');
            if (password.type === 'password') {
                password.type = 'text';
            } else {
                password.type = 'password';
            }
        }
    </script>


    <!--css-->
    <style>
        body {
            margin: 80;
        }

        nav {
            font-family: Arial, Helvetica, sans-serif;
        }


        .bg {
            animation: slide 3s ease-in-out infinite alternate;
            background-image: linear-gradient(-60deg, #6c3 50%, #09f 50%);
            bottom: 0;
            left: -50%;
            opacity: .5;
            position: fixed;
            right: -50%;
            top: 0;
            z-index: -1;
        }

        .bg2 {
            animation-direction: alternate-reverse;
            animation-duration: 4s;
        }

        .bg3 {
            animation-duration: 5s;
        }

        .content {
            background-color: rgba(255, 255, 255, .8);
            border-radius: .25em;
            box-shadow: 0 0 .25em rgba(0, 0, 0, .25);
            box-sizing: border-box;
            left: 50%;
            padding: 10vmin;
            position: fixed;
            text-align: center;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .form-control {
            width: 50%;
        }

        h1 {
            font-family: monospace;
        }

        @keyframes slide {
            0% {
                transform: translateX(-25%);
            }

            100% {
                transform: translateX(25%);
            }
        }

        span {
            color: red;
        }

        .container {
            text-align: center;
            width: 75%;
            height: 100%;
            background: white;
            border-radius: 10px;
        }

        .form-control {
            margin: auto;
        }
    </style>
</head>

<body>
    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
    <!--navigation bar-->
    <nav class='nav'>
        <div class='navbar navbar-expand-sm navbar-dark fixed-top' style='background:#222222'>
            <ul class='nav navbar-nav'>
                <li class='navbar-brand'>Rani Bazzi school</li>
                <li class="nav-item dropdown">
                    <div class="dropdown">
                        <a class="nav-link" data-toggle="dropdown" toggle-dropdown='dropdown' style='cursor:pointer;'><?php echo $username ?><img src='uploads/<?php echo $profilepic; ?>' width='40px' height='40px' class='rounded-circle'></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-header"><a class="dropdown-item" href="myinfo.php"><img src="uploads/<?php echo $profilepic ?>" width='80px' height='80px' class='rounded-circle'><?php echo $firstname, " ", $middlename, " ", $lastname ?></a></a>
                            <a class="dropdown-item" href="changeemail.php"><i class="fas fa-user"></i><?php echo $email ?></a>
                        </div>
                    </div>
                </li>
                <li class='nav-item'><a class='nav-link' href='home.php'>HOME</a></li>
                <li class='nav-item dropdown'>
                    <div class='dropdown'>
                        <button data-toggle='dropdown' dropdown-toggle='dropdown' class='nav-link dropdown btn dropdown-toggle active'>Account settings</button>
                        <div class='dropdown-menu'>
                            <a class='dropdown-item' href='changeemail.php'>Change email</a>
                            <a class='dropdown-item' href='changepassword.php'>Change password</a>
                            <a class='dropdown-item' href='myinfo.php'>My info</a>
                        </div>
                    </div>
                </li>
                <li class='nav-item dropdown'>
                    <div class='dropdown'>
                        <button class='nav-link dr btn-danger' data-toggle='dropdown' dropdown-toggle='dropdown' id='dropdown'>Logout</button>
                        <div class='dropdown-menu'>
                            <a class='dropdown-header'>Are you sure you wanna Logout?</a>
                            <a class='dropdown-header'><a href='logout.php' class='btn-danger nav-link'>Logout</a> <a href='#dropdown' class='btn-info nav-link'>Cancel</a> </a>
                        </div>
                    </div>

                </li>";
            </ul>
        </div>
    </nav>
    <br>
    <div class="container">
        <form method="POST" action="changeemail_serverside.php">
            <br>
            <br>
            <h4>Change E-mail</h4>
            <input type='email' name="newemail" id="newemail" placeholder="New E-mail" class='form-control'>
            <span id="newemail_feedback"></span>
            <br>
            <input type="password" name="password" id='password' placeholder="Current password" class='form-control'>
            <!--password-->
            <span id="password_feedback"></span>
            <input type="checkbox" id="showpass" onclick="showpassword()"> <label for="showpass">Show password</label>
            <br>
            <a href='home.php'><button type='button' class='btn-danger'>Cancel</button></a>
            <button type='submit' id="change" class='btn-success'>Change E-mail</button>
        </form>
    </div>

    <p id="load"></p>

</body>

</html>