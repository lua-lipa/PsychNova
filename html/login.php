<?php
session_start();
include("../classes/connect.php");
include("../classes/login.php");

//if user logged in redirect to timeline
if (isset($_SESSION['userid'])) {
    header("location: timeline.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Login = new Login();
    $result = $Login->authenticateUser($_POST);

    //print result if error
    if ($result != "") {
        echo "<script>alert('$result');</script>";
    } else {
        header("Location: timeline.php");
    }
}

?>

<html>
<!DOCTYPE html>
<head>
    <title> PsychNova login </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/login_and_registration.css">
</head>

<body>
    <div class="container">
        <div class="login-registration-box">
            <div class="row">
                <div class="col-md-6 logo-box">
                    <h1> PsychNova </h1>
                    <h2 class="slogan"> Begin or expand your career with PsychNova today.<span id="dots">...</span><span id="more"> PsychNova is an online service on a mission to advance and expand the careers of people in the psychic industry. It caters to dozens of professions such as astrology, fortune-telling, palmistry, mediumship and more. PsychNova strives to abolish the stigma associated with metaphysical services and offers a secure and friendly experience to it's customers.</h2>
                    <button onclick="myFunction()" class="myBtn" id="myBtn">Read more</button>
                </div>
                <div class="col-md-6 login-box">
                    <form action="" method="post">
                        <div class="form-group">
                            <label> E-Mail </label>
                            <input type="text" name="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Must be in the form psychnova@email.com" required>
                        </div>
                        <div class="form-group">
                            <label> Password </label>
                            <input type="password" name="password" class="form-control"required>
                        </div>
                        <p align="center">
                            <button type="submit" class="btn"> Login </button>
                        </p>
                    </form>
                    <HR>
                    <h6> Don't have an account? </h6>
                    <p align="center">
                        <a href="signup.php"><button class="btn">Create an account</button></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script>
    function myFunction() {
        var dots = document.getElementById("dots");
        var moreText = document.getElementById("more");
        var btnText = document.getElementById("myBtn");

        if (dots.style.display === "none") {
            dots.style.display = "inline";
            btnText.innerHTML = "Read more"; 
            moreText.style.display = "none";
        } else {
            dots.style.display = "none";
            btnText.innerHTML = "Read less"; 
            moreText.style.display = "inline";
        }
        }
    </script>
</body>

</html>