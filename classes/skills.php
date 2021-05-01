<?php

class Skill
{
    //readbyid
    public function getAllSkills()
    {
        $query = "SELECT * FROM skills";
        $db = new Database();
        return $db->read($query);
    }

    public function getSkillFromId($skillId)
    {
        $query = "SELECT * FROM skills WHERE skill_id = '$skillId'";
        $db = new Database();
        return $db->readOne($query);
    }
}
