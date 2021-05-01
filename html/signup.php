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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/tooltip.js"></script>
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
                <div class="col-md-6 registration-box">
                    <form action="" method="post">
                        <div class="form-group">
                            <label> E-Mail </label>
                            <input type="text" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label> Password </label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label> First name </label>
                            <input type="text" name="firstName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label> Last name </label>
                            <a href="#" data-toggle="popover" title="Popover Header" data-content="Some content inside the popover">Toggle popover</a>
                            <input type="text" name="lastName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label> Profession </label>
                            <input type="text" name="profession" class="form-control">
                        </div>
                        <div class="form-group">
                            <label> Date of birth </label>
                            <a href="#" role="button" class="popBtn btn-secondary popover-test" title="Date of birth" data-content="We need your date of birth for calculating your star sign.">&#9432;</a>
                            <input type="date" name="dateOfBirth" class="form-control">
                        </div>
                        <div class="form-group">
                            <label> Time of birth </label>
                            <span>
                                &#9432;
                            </span>
                            <input type="time" name="timeOfBirth" class="form-control">
                        </div>
                        <div class="form-group">
                            <label> Place of birth </label>
                            <span>
                                &#9432;
                            </span>
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
    <script>
    $(document).ready(function(){
    $('[data-toggle="popover"]').popover(); 
    });
    </script>
</body>

</html>
