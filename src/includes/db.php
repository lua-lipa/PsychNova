<?php

$server = "sql312.epizy.com";
$username = "epiz_28027499";
$password = "XP3ST8ZktG4";
$dbname = "epiz_28027499_PsychNova";

$conn = mysqli_connect($server, $username, $password, $dbname);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>