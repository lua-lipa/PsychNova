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

    public function getUserAstroInfo($userid)
    {
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

    public function updateEmploymentHistory($data)
    {
        $position = $data['position'];
        $startDate = $data['startDate'];
        $endDate = $data['endDate'];
        $empHisId = $data['empHisId'];

        $query = "UPDATE employment_history 
        SET position='$position', start_date='$startDate', end_date='$endDate'
        WHERE emp_his_id='$empHisId';";

        $DB = new Database();
        $DB->save($query);
    }

    public function updateEmploymentHistoryOrg($data)
    {
        // $orgId = $data['org_id'];
        // $name = $data['name'];
        // $query = "UPDATE employment_history 
        //         SET org_id=$orgId, name='$name';";
        // $DB = new Database();
        // $DB->save($query);
    }

    public function updateAbout($userId, $data)
    {
        $db = new Database();

        $firstName = $db->validateInput($data['firstName']);
        $lastName = $db->validateInput($data['lastName']);
        $dateOfBirth = $db->validateInput($data['dateOfBirth']);
        $description = $db->validateInput($data['description']);

        $query = "UPDATE user 
                  SET first_name='$firstName', last_name='$lastName', 
                      date_of_birth='$dateOfBirth', description='$description'
                  WHERE user_id='$userId';";


        return $db->save($query);
    }


    public function updateQualification($data)
    {
        $dateObtained = $data['dateObtained'];
        $userQualificationId = $data['userQualificationId'];

        $query = "UPDATE user_qualification 
        SET date_obtained='$dateObtained'
        WHERE u_qualification_id='$userQualificationId';";

        $DB = new Database();
        $DB->save($query);
    }

    public function updateSkills($userId, $data)
    {
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $dateOfBirth = $data['dateOfBirth'];
        $description = $data['description'];

        $query = "UPDATE user 
                  SET first_name='$firstName', last_name='$lastName', 
                      date_of_birth='$dateOfBirth', description='$description'
                  WHERE user_id='$userId';";

        $DB = new Database();
        $DB->save($query);
    }

    public function unbanUser($userId)
    {
        $query = "DELETE FROM banned_users WHERE user_id = '$userId'";
        $db = new Database();
        return $db->save($query);
    }

    public function banUser($data)
    {
        $userId = $data['userId'];
        $dataOfUnban = $data['dateOfUnban'];
        $reason = $data['reason']; 
        $d = new DateTime();
        $now = $d->format('Y-m-d');
        $query = "INSERT INTO banned_users(user_id, reason, date_of_ban, date_of_unban) 
                    VALUES ('$userId', '$reason', '$now', '$dataOfUnban')";
        $db = new Database();
        return $db->save($query);
    }

    public function isBannedPeriod($userId)
    {
        $DB = new Database();
        $banQuery = "SELECT * FROM banned_users WHERE user_id = '$userId';";
        $banned = $DB->readOne($banQuery);
        if ($banned) {
            $date = new DateTime($banned['date_of_unban']);
            $now = new DateTime();
            if ($date < $now) {
                $this->unbanUser($userId);
            } else {
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

    public function isBanned($userId)
    {
        $DB = new Database();
        $banQuery = "SELECT * FROM banned_users WHERE user_id = '$userId';";
        $banned = $DB->readOne($banQuery);

        if ($banned) {
            return true;
        }
        return false;
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
