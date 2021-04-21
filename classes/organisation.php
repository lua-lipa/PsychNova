<?php

class organisation
{

    public function getOrganisationData($userId)
    {
        $query = "SELECT * FROM organisation WHERE user_id = '$userId' limit 1";
        $db = new Database();
        return $db->readOne($query);
    }

    public function getOrgAstroInfo($orgid)
    {
        $query = "SELECT * FROM org_astrological WHERE org_id = $orgid";
        $db = new Database();
        return $db->read($query);
    }
}
