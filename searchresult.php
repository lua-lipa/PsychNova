<?php
session_start();
include("./classes/connect.php");

if (!isset($_SESSION["searchresults"])) {
    echo "no search results";
} else {
    echo "<pre>";
    print_r($_SESSION["searchresults"]);
    echo "</pre>";
}

/*
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
*/

?>

<html>

<head>
    <title> PsychNova </title>
    <?php include("./components/head.php"); ?>
</head>

<body>
    <?php include("./components/navbar.php"); ?>
    <div class="container">



    </div>
</body>

</html>