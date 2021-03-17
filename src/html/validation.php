<?php
    include_once('includes/db.php');

    $mail = $_POST['email'];
    $pass = $_POST['password'];

    $s = " select * from user where email = '$mail' && password = '$pass'";

    $result = mysqli_query($conn, $s);

    $num = mysqli_num_rows($result);

    if($num >= 1){
        header('location:home.php');
    }else{
        header('location:login.php');
    }

?>
