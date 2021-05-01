<?php

class Skill
{
    public function getAllSkills()
    {
        $query = "SELECT * FROM skills";
        $db = new Database();
        return $db->readById($query, "skill_id");
    }

    public function getSkillFromId($skillId)
    {
        $query = "SELECT * FROM skills WHERE skill_id = '$skillId'";
        $db = new Database();
        return $db->readOne($query);
    }
}
