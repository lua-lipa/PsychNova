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

    public function searchUsers($get) {
        $query = "SELECT user.user_id, user.first_name, user.last_name, user.profession, user_skills.skill_id, employment_history.org_id, organisation.name
        FROM user, user_skills, employment_history, organisation
        WHERE user.first_name LIKE '%" . $get['name'] . "%' ";

        if(!empty($get['skill'])) {
            $query .= "AND user_skills.user_id = user.user_id 
                        AND user_skills.skill_id = '" . $get['skill'] . "'";
        }
        if(!empty($get['company'])) {
            $query .= "AND employment_history.user_id = user.user_id
                        AND organisation.org_id = employment_history.org_id 
                        AND organisation.name LIKE '" . $get['company'] . "'";
        }
        $query .= "GROUP BY user.user_id ";

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
