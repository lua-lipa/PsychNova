<?php

class employmentHistory
{
    public function getEmploymentHistoryData($userId)
    {
        $query = "SELECT * FROM employment_history WHERE user_id = '$userId'";
        $db = new Database();
        return $db->read($query);
    }

    public function getAllEmploymentOptions()
    {
        $query = "SELECT * FROM organisation;";
        $db = new Database();
        return $db->readById($query, "org_id");
    }

    public function employmentHistoryJoinOrganisation($userId)
    {
        $query = "SELECT * FROM organisation 
                  INNER JOIN employment_history ON organisation.org_id = employment_history.org_id 
                  AND employment_history.user_id='$userId'";

        $db = new Database();
        return $db->read($query);
    }
}
