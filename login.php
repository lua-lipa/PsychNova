<?php
session_start();
include("./classes/connect.php");
include("./classes/login.php");

//if user logged in redirect to timeline
if (isset($_SESSION['userid'])) {
    header("location: timeline.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Login = new Login();
    $result = $Login->authenticateUser($_POST);

    //print result if error
    if ($result != "") {
        echo $result;
    } else {
        header("Location: timeline.php");
    }
}

?>

<html>

<head>
    <title> PsychNova login </title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./css/login_and_registration.css">
</head>

<body>
    <div class="container">
        <div class="login-registration-box">
            <div class="row">
                <div class="col-md-6 logo-box">
                    <h1> PsychNova </h1>
                    <h2 class="slogan"> Begin or expand your career with PsychNova today. </h2>
                </div>
                <div class="col-md-6 login-box">
                    <form action="" method="post">
                        <div class="form-group">
                            <label> email </label>
                            <input type="text" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label> password </label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <p align="center">
                            <button type="submit" class="btn"> Login </button>
                        </p>
                    </form>
                    <h6> Don't have an account? </h6>
                    <p align="center">
                        <a href="signup.php"><button class="btn">Create an account</button></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>