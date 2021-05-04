<?php

class Search
{

    public function searchDatabase($data)
    {
        $searchInput = $data['searchinput'];
        $dropdownInput = $data['dropdowninput'];

        echo $searchInput;

        if ($dropdownInput == "Users") {
            echo "users";
            return $this->searchUsers($searchInput);
        } elseif ($dropdownInput == "Organisations") {
            echo "organisations";
            return $this->searchOrganisations($searchInput);
        }
    }

    public function searchUsers($searchInput)
    {
        $query = "SELECT * FROM user WHERE
                    first_name LIKE '%$searchInput' ||
                    last_name LIKE '%$searchInput'";
        $db = new Database();
        return $db->read($query);
    }

    public function searchUsersWithOptions($searchInput, $skillInput, $organisationInput)
    {
        //todo
        //search with skill only
        //search with companies worked for only
        //search with both

        $query = "SELECT * FROM user WHERE
                    first_name LIKE '%$searchInput' ||
                    last_name LIKE '%$searchInput'";
        $db = new Database();
        return $db->read($query);
    }

    public function searchOrganisations($searchInput)
    {
        $query = "SELECT * FROM organisation WHERE
                    name LIKE '%$searchInput'";
        $db = new Database();
        return $db->read($query);
    }
}