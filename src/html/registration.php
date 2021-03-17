<?php
session_start();
include_once('includes/db.php');

$mail = $_POST['email'];
$pass = $_POST['password'];
$first_name = $_POST['firstName'];
$last_name = $_POST['lastName'];
$prof = $_POST['profession'];
$date_of_birth = $_POST['dateOfBirth'];
$time_of_birth = $_POST['timeOfBirth'];
$place_of_birth = $_POST['placeOfBirth'];

$s = " select email from user where email = '$mail'";

$result = mysqli_query($conn, $s);

$num = mysqli_num_rows($result);

if($num == 1){
    echo "email already linked to a PsychNova account!";
}else{
    $reg= "insert into user(user_id , email , password , first_name , last_name , profession , date_of_birth) values ('u1166' , '$mail' , '$pass' , '$first_name' , '$last_name' , '$prof' , '$date_of_birth')";
    mysqli_query($conn, $reg);
    echo "Registration Successful!";
}


?>