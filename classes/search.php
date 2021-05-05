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
        $query = "SELECT user.user_id, user.first_name, user.last_name, user.profile_picture, user.profession, user_skills.skill_id, employment_history.org_id, organisation.name
        FROM user, user_skills, employment_history, organisation
        WHERE user.first_name LIKE '%" . $get['name'] . "%' ";

        if(!empty($get['skill'])) {
            $query .= " AND user_skills.user_id = user.user_id 
                        AND user_skills.skill_id = '" . $get['skill'] . "'";
        }
        if(!empty($get['company'])) {
            $query .= " AND employment_history.user_id = user.user_id
                        AND organisation.org_id = employment_history.org_id 
                        AND organisation.name LIKE '%" . $get['company'] . "%'";
        }
        $query .= "GROUP BY user.user_id ";

        $db = new Database();
        return $db->read($query);
    }

    public function searchVacancy($get) {
        $query = "SELECT vacancy.vacancy_id, vacancy.title, vacancy.description, vacancy.date_created, organisation.org_id, organisation.name, organisation.profile_picture
        FROM vacancy, vacancy_skills, organisation
        WHERE vacancy.org_id = organisation.org_id";

        $whereAdded = false;
        if(!empty($get['title'])) {
            $query .= " AND vacancy.title LIKE '%" . $get['title'] . "%'";
        }
        if(!empty($get['companyName'])) {
            $query .= " AND organisation.name LIKE '%" . $get['companyName'] . "%'";
        }
        if(!empty($get['dateCreated'])) {
            $query .= " AND vacancy.date_created >= '" . $get['dateCreated'] . "'";
        }
        if(!empty($get['skill'])) {
            $query .= " AND vacancy_skills.vacancy_id = vacancy.vacancy_id 
                        AND vacancy_skills.skill_id  = '" . $get['skill'] . "'";
        }
        $query .= " GROUP BY vacancy.vacancy_id";

        //echo $query;

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

    public function searchOrganisations($data)
    {
        
        $query = "SELECT * FROM organisation WHERE
                    name LIKE '%" . $data['name'] . "%'";

        $db = new Database();
        return $db->read($query);
    }

}

function autoCompleteOrganisations()
    {
        if (isset($_POST['query'])) {
            $query = "SELECT * FROM organisation WHERE name LIKE '%" . $_POST['query'] . "%'";

            $db = new Database();
            $result = $db->read($query);
            if ($result) {
                foreach ($result as $row) {
                  echo '<a href="#" class="list-group-item list-group-item-action border-1">' . $row['country_name'] . '</a>';
                }
              } else {
                echo '<p class="list-group-item border-1">No Record</p>';
              }
            }
    }
