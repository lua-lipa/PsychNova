<?php
class userOrganisations
{
    public function getUserOrganisations($userId)
    {
        $query = "SELECT org_id FROM organisation WHERE user_id = '$userId'";
        $db = new Database();
        return $db->read($query);
    }
}
?>