<?php
    //processes 2,3,4
    //cascading function calls, authenticateUser is called, it then calls isUserBanned, which then calls isUserAdmin
    
    include_once('includes/db.php'); //include the database connection

    $mail = $_POST['email']; //retrieve the email the user entered
    $pass = $_POST['password']; //retrieve the password the user entered

    $q1 = "select user_id from user where email = '$mail'"; //query to get the users id using their email
    $userId = mysqli_query($conn, $q1); //store the result of the query to be used to check if user is banned or an admin

    authenticateUser($conn); //call to check if user exists

    function authenticateUser($conn){ //authenticate the user by checking their email and password
        global $mail, $pass;
        $q2 = " select * from user where email = '$mail' && password = '$pass'"; //query to check if the password and email combination exist in the database
        $q2_result = mysqli_query($conn, $q2); //store the result of the query
        $q2_num = mysqli_num_rows($q2_result); //get the number of results
        if($q2_num = 1){ //should be exactly 1 as an email can belong to only one user at a time
            isUserBanned($conn); //check whether the user is banned
        }else{ //if the result was 0 i.e., wrong information entered or user isn't registered
            header('location:login.php'); //take user to login page
        }
    }

    function isUserBanned($conn){ //checks whether the user is banned
        global $userId;
        $q3 = "select date_of_unban from banned_users where user_id = '$userId'"; //get the date of unban for the user
        $q3_result = mysqli_query($conn, $q3);
        $q3_num = mysqli_num_rows($q3_result);
        if($q3_num = 1){ //if the query returns a row, then the user is banned
            if( strtotime("$q3_result") < time() ){ //check if its time for the user to be unabnned
                $q4 = "delete from banned_user where user_id = '$userId'"; //remove the entry since user is no longer banned
                isUserAdmin($conn); //check if the user is an admin user
            } else {
                header('location:login.php'); //take user back to login page since they're still banned
            }
        }else{
            isUserAdmin($conn); //user not in banned table so check if they are admin
        }
    }

    function isUserAdmin($conn){//checks whether the user is an admin user
        global $userId;
        $q5 = "select type from user where user_id = '$userId'"; //get the users type
        $q5_result = mysqli_query($conn, $q5);
        if('$q5_result' == 'administrator'){ //check if the type is administrator
            header('location:admin_timeline.html');//display admin timeline since they are an administrator
        }else{
            header('location:timeline.html'); //display regular timeline since they aren't an administrator
        }
    }

?>
