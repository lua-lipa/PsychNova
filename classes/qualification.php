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
}
