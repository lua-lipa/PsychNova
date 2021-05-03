<?php
class Qualification
{

    public function getUserQualificationData($userId)
    {
        $query = "SELECT * FROM qualification WHERE user_id = '$userId'";
        $db = new Database();
        return $db->read($query);
    }

    public function addUserQualification($userId, $data)
    {
        $description = $data['description'];
        $title = $data['title'];
        $institute = $data['institute'];
        $dateObtained = $data['dateObtained'];

        $query =
            "INSERT INTO qualification(
            description,
            title,
            institute,
            date_obtained,
            user_id
            )
            VALUES ('$description', '$title', '$institute', '$dateObtained', '$userId');";

        $db = new Database();
        return $db->save($query);
    }

    public function getAllQualificationData()
    {
        $query = "SELECT * FROM qualification";
        $db = new Database();
        return $db->read($query);
    }

    public function deleteQualification($userId)
    {
        $query = "DELETE FROM qualification WHERE user_id=$userId;";
        $db = new Database();
        return $db->save($query);
    }

    public function getQualificationFromId($qualification_id)
    {
        $query = "SELECT * FROM qualification WHERE qualification_id = '$qualification_id' limit 1";
        $db = new Database();
        return $db->readOne($query);
    }
}
