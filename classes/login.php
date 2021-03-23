<?php

class Login {

    private $error = "";

    public function authenticateUser($data) {
        $email = $data['email'];
        $password = $data['password'];

        $query = "select * from user where email = '$email' limit 1";
        
        $DB = new Database();
        $result = $DB->read($query);

        if ($result) {
            if ($password == $result['password']) {
                $_SESSION['userid'] = $result['user_id'];
            } else {
                $this->error .= "Incorrect password";
            }
        } else {
            $this->error .= "Email not found <br>";
        }

        return $this->error;
    }

}