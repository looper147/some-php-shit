<?php
// Initialize the session
session_start();
if (empty($_SESSION["loggedin"])) {
    header("location:home.php");
}

$id = $_SESSION['id'];
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
$firstname = $output['firstname'];
$middlename = $output['middlename'];
$lastname = $output['lastname'];
$email = $output['email'];




?>


<html>

<head>
    <title>Change password</title>
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

                var oldpassword = $("#oldpassword").val();
                var newpassword = $("#newpassword").val();
                var confirmpassword = $("#confirmpassword").val();
                var submitbutton = $("#submit").val();
                $.post("changepassword_serverside.php", {
                    oldpassword: oldpassword,
                    newpassword: newpassword,
                    confirmpassword: confirmpassword,
                    submit: submitbutton
                }, function(data) {
                    $("#response").html(data);
                })
            })
        })


        function showpasswords() {
            var old_password, new_password, confirm_password;
            old_password = document.getElementById('oldpassword');
            new_password = document.getElementById('newpassword');
            confirm_password = document.getElementById('confirmpassword')
            if (old_password.type === 'password' && new_password.type === 'password' && confirm_password.type === 'password') {
                old_password.type = 'text';
                new_password.type = 'text';
                confirm_password.type = 'text';
            } else {
                old_password.type = 'password';
                new_password.type = 'password';
                confirm_password.type = 'password'
            }



        }
    </script>


    <!--CSS-->
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 80;
        }

        span {
            color: red;
        }

        .container {
            background: white;
            border-radius: 10px;
        }

        form {
            width: 50%;
            text-align: center;
            margin: auto;
            padding: 10px;

        }

        .form-control {
            text-align: center;

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
    </style>
</head>
<div class="bg"></div>
<div class="bg bg2"></div>
<div class="bg bg3"></div>

<body class='body'>
    <nav class='nav'>
        <div class="navbar navbar-expand-sm navbar-dark fixed-top" style='background: #222222;'>
            <ul class='nav navbar-nav'>
                <li class='navbar-brand'>Rani Bazzi school</li>
                <li class="navbar-item dropdown">
                    <div class="dropdown">
                        <a class="nav-link" data-toggle="dropdown" dropdown-toggle='dropdown' style="cursor: pointer;"><?php echo $username; ?><img src="uploads/<?php echo $profilepic ?>" width='40px' height="40px" class="rounded-circle"></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-header"><a class="dropdown-item" href='myinfo.php'><img src="uploads/<?php echo $profilepic ?>" width="80px" height='80px' class="rounded-circle"><span style="color: black"><?php echo $firstname, " ", $middlename, " ", $lastname; ?></span></a></a>
                            <a href="changeemail.php.php" class="dropdown-item"><i class="fas fa-user"></i><?php echo $email; ?></a>
                        </div>
                    </div>
                </li>
                <li class="navbar-item"><a class='nav-link' href="home.php">HOME</a></li>

                <li class="nav-item dropdown">
                    <div class="dropdown">
                        <button type="button" data-toggle='dropdown' class='nav-link dropdown-toggle btn active' dropdown-toggle='dropdown'>Account settings</button>
                        <div class='dropdown-menu'>
                            <a class="dropdown-item" href="changeemail.php">Change your E-mail</a>
                            <a class="dropdown-item" href="changepassword.php">Change password</a>
                            <a class="dropdown-item" href="myinfo.php">My info</a>
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
    <br><br>
    <div class="container" style="width: 60%;">
        <form action="changepasword_serverside.php" method='POST'>
            <br>
            <br>
            <h4>Change Password</h4>
            <!--old password-->
            <input type='password' id='oldpassword' name='oldpassword' placeholder='Current password' class="form-control">
            <span id='oldpassword_feedback'></span><br>
            <!--new password-->
            <input type='password' id='newpassword' name='newpassword' placeholder='New password' class="form-control">
            <span id='newpassword_feedback'></span><br>
            <!--confirm password-->
            <input type='password' id='confirmpassword' name='confirmpassword' placeholder='Confirm password' class="form-control">
            <span id='confirmpassword_feedback'></span><br>

            <input type="checkbox" onclick='showpasswords()' id="show"> <label for="show">Show passwords</label>

            <br>
            <a href="home.php"><button type="button" class="btn-danger">Cancel</button></a>
            <button type="submit" id="submit" class="btn-success">Done</button>
        </form>
        <br>
        <br>
        <br>

    </div>
    <div id="response"></div>
</body>

</html>