<?php

class Skill
{
    public function getSkillFromId($skillId)
    {
        $query = "SELECT * FROM skills WHERE skill_id = '$skillId'";
        $db = new Database();
        return $db->readOne($query);
    }
}
