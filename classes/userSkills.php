<?php

class userSkills
{
    //inner join
    public function getUserSkills($userid)
    {
        $query = "SELECT * FROM user_skills INNER JOIN skills ON skills.skill_id=user_skills.skill_id WHERE user_id=$userid";
        $db = new Database();
        return $db->readById($query, "skill_id");
    }
}
