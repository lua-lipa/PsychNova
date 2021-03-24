<?php
class userQualification
{

    public function getUserQualificationData($userId)
    {
        $query = "SELECT * FROM user_qualification WHERE user_id = '$userId'";
        $db = new Database();
        return $db->read($query);
    }
}
