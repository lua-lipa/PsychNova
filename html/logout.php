<?php
    //this unsets your session userid across everyone so you can start fresh ;)
    session_start();

    if(isset($_SESSION['userid'])) {
        unset($_SESSION['userid']);
        echo "logged out";
        header("location: login.php");
    } else {
        echo "you are not logged in";
    }
?>