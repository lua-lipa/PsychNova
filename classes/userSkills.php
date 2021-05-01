<?php

class userSkills
{
    //inner join
    public function getUserSkills($userid)
    {
        $query = "SELECT * FROM user_skills WHERE user_id = '$userid'";
        $db = new Database();
        return $db->read($query);
    }
}
