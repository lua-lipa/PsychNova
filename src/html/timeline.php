<?php 

session_start(); 
include_once('.../includes/db.php');


$post = "" ;


function makePost() { 
    global $conn; 

    if (isset($S_POST['textbox'])) { 
        $post = $_POST['textbox'];
        //print($post);
    }

    $query = "INSERT INTO posts(post_id, user_id, post, date_of_post, time_of_post) VALUES (123, 456, $post, CURDATE(), CURTIME())"; 
    $result = mysqli_query($conn, $query); 


}

?> 