<?php

class User
{

    private $error = "";

    //add user to database (create astro sign too?)
    public function getUserData($userId)
    {
        $query = "select * from user where user_id = '$userId' limit 1";
        $db = new Database();
        return $db->readOne($query);
    }

    public function getUserAstroInfo($userid){
        $query = "SELECT * FROM user_astrological WHERE user_id = $userid";
        $db = new Database();
        return $db->read($query);
    }

    public function isUserAdmin($userId)
    {
        $query = "select type from user where user_id = '$userId'";
        $db = new Database();
        return $db->exists($query);
    }

    public function unbanUser($userId)
    {
        $query = "delete from banned_user where user_id = '$userId'";
        $db = new Database();
        return $db->save($query);
    }

    public function isBanned($userId)
    {
        $query = "select date_of_unban from banned_users where user_id = '$userId'";
        $db = new Database();
        $result = $db->readOne($query);

        if ($result) {
            if (strtotime(($result['date_of_unban']) < time())) {
                $this->unbanUser($userId);
                return false;
            } else {
                return true;
            }
        }
    }
}
