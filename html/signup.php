<?php
session_start();
include("../classes/connect.php");
include("../classes/signup.php");

//if user logged in redirect to timeline
if (isset($_SESSION['userid'])) {
    header("location: timeline.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $SignUp = new SignUp();
    $result = $SignUp->createUser($_POST);

    if ($result != "") {
        //show error
        echo $result;
    } else {
        header("Location: timeline.php");
    }
}

?>

<html>

<head>
    <title> PsychNova register </title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/login_and_registration.css">
</head>

<body>
    <div class="container">
        <div class="login-registration-box">
            <div class="row">
                <div class="col-md-6 logo-box">
                    <h1> PsychNova </h1>
                    <h2 class="slogan"> Begin or expand your career with PsychNova today. </h2>
                </div>
                <div class="col-md-6 registration-box">
                    <form action="" method="post">
                        <div class="form-group">
                            <label> email </label>
                            <input type="text" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label> password </label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label> First name </label>
                            <input type="text" name="firstName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label> Last name </label>
                            <input type="text" name="lastName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label> Profession </label>
                            <input type="text" name="profession" class="form-control">
                        </div>
                        <div class="form-group">
                            <label> Date of birth </label>
                            <input type="date" name="dateOfBirth" class="form-control">
                        </div>
                        <div class="form-group">
                            <label> Time of birth </label>
                            <input type="time" name="timeOfBirth" class="form-control">
                        </div>
                        <div class="form-group">
                            <label> Place of birth </label>
                            <input type="text" name="placeOfBirth" class="form-control">
                        </div>
                        <p align="center">
                            <button type="submit" class="btn"> Register </button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>