<?php

include("connect.php");

class Login {

    private $error = "";

    public function loginUser($data) {
        $email = $data['email'];
        $password = $data['password'];

        $query = "select * from user where email = '$email' limit 1";
        
        $DB = new Database();
        $result = $DB->read($query);

        if ($result) {
            $row = $result[0];
            if ($password == $row['password']) {
                $_SESSION['userid'] = $row['user_id'];
            } else {
                $this->error .= "Incorrect password";
            }
        } else {
            $this->error .= "Email not found <br>";
        }

        return $this->error;
    }
}