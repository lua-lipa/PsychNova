<?php

class vacancy
{

    public function getVacancies()
    {
        $query = "SELECT * FROM vacancy";
        $db = new Database();
        return $db->read($query);
    }
}
