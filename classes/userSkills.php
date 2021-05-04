<?php

class userSkills
{
    //inner join
    public function getUserSkills($userId)
    {
        $query = "SELECT * FROM user_skills INNER JOIN skills ON skills.skill_id=user_skills.skill_id WHERE user_id=$userId";
        $db = new Database();
        return $db->readById($query, "skill_id");
    }

    public function skills($userId)
    {
        $query = "SELECT * FROM user_skills INNER JOIN skills ON skills.skill_id=user_skills.skill_id WHERE user_id=$userId";
        $db = new Database();
        return $db->read($query);
    }

    public function removeAllSkills($userId)
    {
        $query = "DELETE FROM user_skills WHERE user_id=$userId;";
        $db = new Database();
        return $db->save($query);
    }

    public function addUserSkill($userId, $skillId)
    {
        $query = "INSERT INTO user_skills(user_id, skill_id)
                    VALUES ($userId, $skillId);";
        $db = new Database();
        return $db->save($query);
    }
}
