<?php
class userOrganisations
{

    public function getUserOrganisations($userId)
    {
        $query = "SELECT * FROM organisation WHERE user_id = '$userId'";
        $db = new Database();
        return $db->read($query);
    }
}
?>