<?php

class SignUp {

    private $error = "";
    //add user to database (create astro sign too?)
    public function createUser($data) {
        $email = $data['email'];
        $password = $data['password'];
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $profession = $data['profession'];
        $dateOfBirth = $data['dateOfBirth'];
        $timeOfBirth = $data['timeOfBirth'];
        $placeOfBirth = $data['placeOfBirth'];

        $query = "insert into user 
                            (email , password , first_name , last_name , profession , date_of_birth, type, profile_picture) 
                    values ('$email' , '$password' , '$firstName' , '$lastName' , '$profession' , '$dateOfBirth', 'personal user', '../images/pp/user_annon.png')";
        $DB = new Database();
        $DB->save($query);

        return $this->error;
    }

    
}