<?php
class userQualification
{

    public function getUserQualificationData($userId)
    {
        $query = "SELECT * FROM user_qualification WHERE user_id = '$userId'";
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
}
