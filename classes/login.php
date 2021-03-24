<?php

class Login
{

    private $error = "";

    public function authenticateUser($data)
    {
        $email = $data['email'];
        $password = $data['password'];

        $query = "SELECT * FROM user WHERE email = '$email' LIMIT 1";

        $DB = new Database();
        $result = $DB->readOne($query);

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
