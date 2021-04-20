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
        $query = "DELETE FROM banned_user WHERE user_id = '$userId'";
        $db = new Database();
        return $db->save($query);
    }

    public function isBanned($userId)
    {
        $DB = new Database();
        $banQuery = "SELECT * FROM banned_users WHERE user_id = '$userId';";
        $banned = $DB->readOne($banQuery);
        if($banned){
            $date = new DateTime($banned['date_of_unban']);
            $now = new DateTime();
            if($date < $now){
                $this->unbanUser($userId);
            }else{
                $unbanDate = $banned['date_of_unban'];
                return "You have been banned for violating our guidelines. You will be unbanned on $unbanDate";
            }
        }
        // $query = "select date_of_unban from banned_users where user_id = '$userId'";
        // $db = new Database();
        // $result = $db->readOne($query);

        // if ($result) {
        //     if (strtotime(($result['date_of_unban']) < time())) {
        //         $this->unbanUser($userId);
        //         return false;
        //     } else {
        //         return true;
        //     }
        // }
    }
}