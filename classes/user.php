<?php

include("connect.php");

class User {

    public function getData($userId) {
        $query = "select * from user where user_id = '$userId' limit 1";
        $DB = new Database();
        $result = $DB->read($query);

        if ($result) {
            $row = $result[0];
            return $row;
        } else {
            return false;
        }
    }

    
}