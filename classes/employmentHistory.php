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
        $query = "SELECT employment_history.emp_his_id, employment_history.user_id, employment_history.org_id, employment_history.start_date, employment_history.end_date, employment_history.position, employment_history.organisation_name, organisation.name
                    FROM employment_history, organisation
                    WHERE employment_history.user_id = '" . $userId . "' AND organisation.org_id = employment_history.org_id
                    GROUP BY employment_history.emp_his_id";

        $db = new Database();
        return $db->read($query);
    }

    public function deleteEmploymentHistory($data, $userId)
    {
        $empHisId = $data['empHisId'];

        $query = "DELETE FROM employment_history WHERE user_id='$userId' AND emp_his_id='$empHisId';";

        $db = new Database();
        return $db->save($query);
    }

    public function addEmploymentHistory($userId, $data)
    {
        $orgId = $data['orgId'];
        $startDate = $data['startDate'];
        $endDate = $data['endDate'];
        $position = $data['position'];
        $name = $data['organisation'];

        if ($orgId == 0) {
            $query = "INSERT INTO employment_history 
                            (user_id , org_id , start_date , end_date, position, organisation_name) 
                    values ('$userId' , '$orgId' , '$startDate' , '$endDate' , '$position', '$name')";
        } else {
            $query = "INSERT INTO employment_history 
                            (user_id , org_id , start_date , end_date, position) 
                    values ('$userId' , '$orgId' , '$startDate' , '$endDate' , '$position')";
        }

        $DB = new Database();
        return $DB->save($query);
    }
}
