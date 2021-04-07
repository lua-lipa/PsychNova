<?php

class organisation
{

    public function getOrganisationData($orgId)
    {
        $query = "SELECT * FROM organisation WHERE org_id = '$orgId' limit 1";
        $db = new Database();
        return $db->readOne($query);
    }

    public function getOrgAstroInfo($orgid){
        $query = "SELECT * FROM org_astrological WHERE org_id = $orgid";
        $db = new Database();
        return $db->read($query);
    }

}

?>
