<?php

class vacancy
{
    
    public function getVacancies()
    {
        $query = "SELECT * FROM vacancy";
        $db = new Database();
        return $db->read($query);
    }

    public function getVacanciesOrg($orgId)
    {
        $query = "SELECT * FROM vacancy WHERE org_id='$orgId'";
        $db = new Database();
        return $db->read($query);
    }

    public function addVacancy($orgId, $data)
    {
        $title = $data['title'];
        $description = $data['description'];
        $dateCreated = $data['dateCreated'];

        $query = "INSERT INTO vacancy (title, description, date_created, org_id) 
                VALUES ('$title', '$description', '$dateCreated', '$orgId');";

        $db = new Database();
        return $db->save($query);
    }

    public function deleteVacancy($data)
    {
        $vacancyId = $data['vacancyId'];
        $query = "DELETE FROM vacancy WHERE vacancy_id=$vacancyId";

        $db = new Database();
        return $db->save($query);
    }

    public function updateVacancy($orgId, $data)
    {
        $title = $data['title'];
        $description = $data['description'];
        $dateCreated = $data['dateCreated'];
        $vacancyId = $data['vacancyId'];

        $query = "UPDATE vacancy
        SET title='$title', description='$description', date_created='$dateCreated'
        WHERE vacancy_id='$vacancyId' AND org_id='$orgId';";

        $db = new Database();
        return $db->save($query);
    }

    public function getAllVacancySkills()
    {
        $query = "SELECT * FROM vacancy_skills";

        $db = new Database();
        return $db->read($query);
    }

    public function getVacancySkills($data)
    {
        // get skill based on vacancy id and the vacancy skill id
        $vSkillId = $data['vSkillId'];
        $vacancyId = $data['vacancyId'];

        $query = "SELECT * FROM vacancy_skills WHERE vacancy_id='$vacancyId' AND v_skill_id = '$vSkillId';";

        $db = new Database();
        return $db->read($query);
    }

    public function vacancySkills($orgId)
    {
        $query = "SELECT vacancy_skills.vacancy_id, vacancy_skills.skill_id, skills.skill_id, skills.title
                FROM vacancy_skills, skills
                -- vacancy ID not orgId
                WHERE vacancy_skills.vacancy_id = '$orgId' AND vacancy_skills.skill_id = skills.skill_id
                GROUP BY vacancy_skills.skill_id;";

        $db = new Database();
        return $db->readById($query, "skill_id");
    }

    public function removeAllVacancySkills($data)
    {
        $vacancyId = $data['vacancyId'];
        $query = "DELETE FROM vacancy_skills WHERE vacancy_id=$vacancyId;";
        $db = new Database();
        return $db->save($query);
    }

    public function addVacancySkills($data, $skillId)
    {
        $vacancyId = $data['vacancyId'];
        $query = "INSERT INTO vacancy_skills(vacancy_id, skill_id)
                    VALUES ($vacancyId, $skillId);";
        $db = new Database();
        return $db->save($query);
    }

    public function getVacancyWithSkill($vacancyId, $skillId){
        $query = "SELECT * FROM vacancy_skills WHERE vacancy_id = '$vacancyId' AND skill_id = '$skillId';";
        $db = new Database();
        return $db->read($query);
    }

    public function skills($userId)
    {
        $query = "SELECT skills.skill_id FROM user_skills INNER JOIN skills ON skills.skill_id=user_skills.skill_id WHERE user_id=$userId";
        $db = new Database();
        return $db->read($query);
    }

    public function suggestedVacancies($userId){
        $userSkillsData = $this->skills($userId);
        $vacancies = $this->getVacancies();
        $suggestedVacancies = array();
        foreach($userSkillsData as $key => $value){
            $skill = $value['skill_id'];
            foreach($vacancies as $key => $vac){
                $vacancy = $vac['vacancy_id'];
                $vacSkill = $this->getVacancyWithSkill($vacancy, $skill);
                if(!empty($vacSkill)){
                    if(!in_array($vacancy, $suggestedVacancies)){    
                        array_push($suggestedVacancies, $vac);
                    }
                }
            }
        }
        return $suggestedVacancies;
    }
}
