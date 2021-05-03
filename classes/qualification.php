<?php
class Qualification
{

    public function getUserQualificationData($userId)
    {
        $query = "SELECT * FROM qualification WHERE user_id = '$userId'";
        $db = new Database();
        return $db->read($query);
    }

    public function addUserQualification($data)
    {
        $userId = $data['userId'];
        $qualificationId = $data['qualificationId'];
        $dateObtained = $data['dateObtained'];

        $query =
            "INSERT INTO user_qualification(
            user_id,
            qualification_id,
            date_obtained
            )
            VALUES ($userId, $qualificationId, $dateObtained);";

        $db = new Database();
        return $db->read($query);
    }

    public function getAllQualificationData()
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
}
