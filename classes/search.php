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

    public function searchVacancy($get) {
        $query = "SELECT vacancy.vacancy_id, vacancy.title, vacancy.description, vacancy.date_created, organisation.org_id, organisation.name
        FROM vacancy, vacancy_skills, organisation";

        $whereAdded = false;
        if(!empty($get['title'])) {
            if ($whereAdded == false) {
                $query .= "WHERE ";
            } else {
                $query .= "AND ";
                $whereAdded = true;
            }
            $query .= "vacancy.title LIKE '%" . $get['title'] . "%'";
        }
        if(!empty($get['companyName'])) {
            if ($whereAdded == false) {
                $query .= "WHERE ";
            } else {
                $query .= "AND ";
                $whereAdded = true;
            }
            $query .= "organisation.name LIKE '%" . $get['companyName'] . "%'";
        }
        if(!empty($get['dateCreated'])) {
            if ($whereAdded == false) {
                $query .= "WHERE ";
            } else {
                $query .= "AND ";
                $whereAdded = true;
            }
            $query .= "vacancy.date_created >= '" . $get['dateCreated'] . "'";
        }
        if(!empty($get['skill'])) {
            if ($whereAdded == false) {
                $query .= "WHERE ";
            } else {
                $query .= "AND ";
                $whereAdded = true;
            }
            $query .= "AND vacancy_skills.vacancy_id = vacancy.vacancy_id 
            AND vacancy_skills.v_skill_id  = '" . $get['skill'] . "%'";
        }
        $query .= " GROUP BY vacancy.vacancy_id";

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
