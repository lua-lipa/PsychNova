<?php

class organisation
{

    public function getUserOrganisationData($userId)
    {
        $query = "SELECT * FROM organisation WHERE user_id = '$userId' limit 1";
        $db = new Database();
        return $db->readOne($query);
    }

    public function getOrganisationData($orgId)
    {
        $query = "SELECT * FROM organisation WHERE org_id = '$orgId' limit 1";
        $db = new Database();
        return $db->readOne($query);
    }

    public function getOrgAstroInfo($orgid)
    {
        $query = "SELECT * FROM org_astrological WHERE org_id = $orgid";
        $db = new Database();
        return $db->read($query);
    }

    public function getLinkedOrganisations($userId)
    {
        $query = "SELECT org_id FROM employment_history WHERE user_id = '$userId' AND org_id IN (SELECT org_id FROM organisation);";
        $db = new Database();
        return $db->read($query);
    }

    public function createOrg($data, $userId)
    {
        $error = "";
        $name = $data['name'];
        $DE = $data['dateEstablished'];
        $desc = $data['description'];
        $email = $data['email'];
        $number = $data['contactNo'];

        $query = "insert into organisation 
                            (name, date_established, description, user_id, email, contact_number, profile_picture) 
                    values ('$name' , '$DE' , '$desc' , '$userId' , '$email' , '$number', '../images/pp/org_annon.png')";
        $DB = new Database();
        $DB->save($query);

        return $this->error;
    }
}
