<?php
class Qualification
{

    public function getQualificationData()
    {
        $query = "SELECT * FROM qualification";
        $db = new Database();
        return $db->read($query);
    }

    public function getQualificationFromId($qualification_id)
    {
        $query = "SELECT * FROM qualification WHERE qualification_id = '$qualification_id' limit 1";
        $db = new Database();
        return $db->readOne($query);
    }

    public function userJoinQualification($userId)
    {
        $query = "SELECT * FROM user_qualification 
                INNER JOIN qualification 
                WHERE user_qualification.qualification_id = qualification.qualification_id AND user_id=6";

        $db = new Database();
        return $db->readOne($query);
    }

    public function getAllQualifications()
    {
        $query = "SELECT * FROM qualification;";

        $db = new Database();
        return $db->readOne($query);
    }
}
