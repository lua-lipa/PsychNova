<?php
session_start();
include("../classes/connect.php");
include("../classes/user.php");
include("../classes/userSkills.php");
include("../classes/skills.php");
include("../classes/organisation.php");
include("../classes/star_sign.php");
include("../classes/vacancy.php");
include("../classes/qualification.php");

if (!isset($_SESSION['userid'])) {
    header("location: myorganisations.php");
}

if (isset($_POST['deleteVacancy'])) {
    $vacancy = new vacancy();
    $vacancy->deleteVacancy($_POST);
}

$org_id = $_GET['id'];
$organisation = new organisation();

$newSkills = array();
if (isset($_POST['updateVacancy'])) {
    $vacancy = new vacancy();
    $vacancy->updateVacancy($org_id, $_POST);

    $vacancy->removeAllVacancySkills($_POST);
    foreach ($_POST['selectedSkills'] as $selected) {
        array_push($newSkills, $selected);
        $vacancy->addVacancySkills($_POST, $selected);
    }
}

if (isset($_POST['addVacancy'])) {
    $vacancy = new vacancy();
    $vacancy->addVacancy($org_id, $_POST);

    foreach ($_POST['selectedSkills'] as $selected) {
        array_push($newSkills, $selected);
        $vacancy->addVacancySkills($_POST, $selected);
    }
}

// $organisationData = $organisation->getOrganisationData($_SESSION['userid']);
$organisationData = $organisation->getOrganisationData($org_id);
$user = new User();
$userData = $user->getUserData($_SESSION['userid']);

$vacancy = new vacancy();
$recommendedVacancies = $vacancy->getVacancies();

$qualification = new Qualification();
$userQualificationData = $qualification->getUserQualificationData($_SESSION['userid']);
$allQualifications = $qualification->getAllQualificationData();

$newSkills = array();
if (isset($_POST['updateSkills'])) {
    $userSkills = new userSkills();
    $userSkills->removeAllSkills($_SESSION['userid']);
    foreach ($_POST['selectedSkills'] as $selected) {
        array_push($newSkills, $selected);
        $userSkills->addUserSkill($_SESSION['userid'], $selected);
    }
}

$userSkills = new userSkills();
$userSkillsData = $userSkills->getUserSkills($_SESSION['userid']);
$skill = new Skill();
$allSkillsData = $skill->getAllSkills();


$selectedSkills = array();

$vacancy = new vacancy();
$organisationVacancies = $vacancy->getVacanciesOrg($org_id);
// echo "<pre>";
// print_r($organisationVacancies);
// echo "</pre>";



?>

<html>

<head>
    <?php include("../components/head.php"); ?>
    <link rel="stylesheet" type="text/css" href="../css/profile-style.css">
    <title>Organisation</title>
</head>

<!-- navbar -->
<?php include("../components/navbar.php"); ?>
<div class="container mt-3">
    <div class="main-page">
        <div class="row">
            <div class="col-sm-9 pr-5">
                <div class="row card-profile">
                    <div class="col-3 d-flex justify-content-center align-items-center">
                        <img src="<?php echo $organisationData['profile_picture'] ?>" class="img-circle" />
                    </div>
                    <div class="col-9">
                        <div class="row float-right">
                            <button type="button" style="margin-right: 10px; margin-top: 10px; background-color: #ffffff; color: #000000; height: 35px; border-color: #876e8f; border-radius:50px;" class="btn btn-primary" data-toggle="modal" data-target="#editAboutModal">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <div class="modal fade" id="editAboutModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" style="color:black">Edit About</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="" method="POST">
                                            <div class="modal-body">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius:15px; background-color: #876e8f; border-color:#876e8f">Close</button>
                                                <button type="submit" name="updateAbout" class="btn btn-primary" style="border-radius:15px; background-color: #a58aae; border-color:#876e8f">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h4 class="user-name"><?php echo $organisationData['name'] ?></h4>
                        </div>
                        <div class="row">
                            <p class="astro-sun"><i class="bi bi-sun"></i> <?php echo calcStarSign($userData['date_of_birth']) ?> </p>
                            <p class="astro-rising"><i class="bi bi-sunrise"></i> <?php echo calcRising() ?></p>
                            <p class="astro-moon"><i class="bi bi-moon"></i> <?php echo calcMoon() ?></p>
                        </div>
                        <div class="row">
                            <p class="user-connections">Contact Number: <?php echo $organisationData['contact_number'] ?> </p>
                        </div>
                        <div class="row">
                            <p class="user-connections">Email: <?php echo $organisationData['contact_number'] ?> </p>
                        </div>
                    </div>
                </div>
                <div class="row h-22 mt-3">
                    <div class="mb-3">
                        <h8 class="mb-3">About</h8>
                    </div>
                    <div class="card-about px-4 pt-4 pb-4">
                        <p style="font-size: 14px"><?php echo $organisationData['description'] ?></p>
                    </div>
                </div>

                <!-- ADD Vacancy -->
                <div class="row mt-3">
                    <div class="addVacancy">
                        <h8>Vacancies</h8>
                        <button type="button" style="margin-right: 30px; margin-top: 10px; background-color: #ffffff; color: #000000; height: 35px; border-color: #876e8f; border-radius:50px;" class="btn btn-primary" data-toggle="modal" data-target="#addVacancyModal">
                            <i class="bi bi-plus"></i>
                        </button>
                        <div class="modal fade" id="addVacancyModal" tabindex=" -1" role="dialog" aria-labelledby="vacancyModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="vacancyModalLabel">Add a Vacancy</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="POST">
                                            <label for="dateCreated" style="color:black">Date Created *</label> <input class="form-control" type="date" name="dateCreated" style="border-radius:5px;" value='' />
                                            <br>
                                            <label for="title" style="color:black">Title *</label><input class="form-control" type="text" name="title" style="border-radius:5px;" value='' />
                                            <br>
                                            <label for="description" style="color:black">Description *</label><input class="form-control" type="text" name="description" style="margin-bottom:10px; height: 50px; width:95%; border-radius:5px;" maxlength="200" value='' />
                                            <?php ?>
                                            <label for="requiredSkills" style="color:black">Required Skills *</label>
                                            <div class="form-group">
                                                <?php
                                                foreach ($allSkillsData as $key => $value) {
                                                    $vacancySkillsData;
                                                    foreach ($organisationVacancies as $key => $value_1) {
                                                        $vacancySkillsData = $vacancy->vacancySkills($value_1['vacancy_id']);
                                                    }
                                                    if (array_key_exists($key, $vacancySkillsData)) {
                                                        print_r($vacancySkillsData);
                                                ?>
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="selectedSkills[]" type="checkbox" value="<?php echo $key ?>" id="defaultCheck1" checked>
                                                            <label class="form-check-label" for="defaultCheck1">
                                                                <?php echo $value['title'] ?>
                                                            </label>
                                                        </div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="selectedSkills[]" type="checkbox" value="<?php echo $key ?>" id="defaultCheck1">
                                                            <label class="form-check-label" for="defaultCheck1">
                                                                <?php echo $value['title'] ?>
                                                            </label>
                                                        </div>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius:15px; background-color: #876e8f; border-color:#876e8f">Close</button>
                                        <button type="submit" name="addVacancy" class="btn btn-primary" style="border-radius:15px; background-color: #a58aae; border-color:#876e8f">Save changes</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vacancies DISPLAY -->
                <?php
                foreach ($organisationVacancies as $key => $value_1) {
                    $organisationid = "vacancyModal" . $value_1['vacancy_id'];
                    $vacancySkillsData = $vacancy->vacancySkills($value_1['vacancy_id']);
                ?>
                    <div class="row mt-3">
                        <div class="card-qualification">
                            <div class="qualification">
                                <h8 class="size-change" style="font-size: 18px" id="margin-add"><strong><?php echo $value_1['title'] ?></strong></h8><br>
                                <h9><?php echo $value_1['date_created'] ?></h9><br>
                                <p><?php echo $value_1['description'] ?></p>
                                <div class="row mt-3">
                                    <h8 class="size-change" style="font-size: 16px;  margin-left:15px;" id="margin-add"><strong>Required Skills</strong></h8><br>
                                </div>
                                <div class="row mt-3">
                                    <?php
                                    foreach ($vacancySkillsData as $key => $value) {
                                    ?>
                                        <div class="skills" style="flex-wrap: wrap; margin-left:10px">
                                            <span type="badge badge-primary" class="badge-skill" style="background-color: #876e8f;  margin-bottom:20px;"><?php echo $value['title'] ?> </span>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <div class="row float-right">
                                    <button type="button" class="btn qualification-button btn-primary" data-toggle="modal" data-target="#<?php echo $organisationid ?>" style="margin-right:20px; margin-bottom:10px;">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <div class="modal fade" id="<?php echo $organisationid ?>" tabindex=" -1" role="dialog" aria-labelledby="qualificationModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="qualificationModalLabel">Edit Vacancies</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="POST">
                                                        <label for="dateCreated" style="color:black">Date Created *</label><input class="form-control" type="date" name="dateCreated" style="border-radius:5px;" value='<?php echo $value_1['date_created'] ?>' />
                                                        <br>
                                                        <label for="title" style="color:black">Title *</label> <input class="form-control" type="text" name="title" style="border-radius:5px;" value='<?php echo $value_1['title'] ?>' />
                                                        <br>
                                                        <label for="description" style="color:black">Description *</label><input class="form-control" type="text" name="description" style="margin-bottom:10px; height: 50px; width:95%; border-radius:5px;" maxlength="200" value='<?php echo $value_1['description'] ?>' />
                                                        <input type="hidden" name="vacancyId" value='<?php echo $value_1['vacancy_id'] ?>' />
                                                        <br>
                                                        <label for="requiredSkills" style="color:black">Required Skills *</label>
                                                        <div class="form-group">
                                                            <?php foreach ($allSkillsData as $key => $value) {
                                                                if (array_key_exists($key, $vacancySkillsData)) {
                                                            ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" name="selectedSkills[]" type="checkbox" value="<?php echo $key ?>" id="defaultCheck1" checked>
                                                                        <label class="form-check-label" for="defaultCheck1">
                                                                            <?php echo $value['title'] ?>
                                                                        </label>
                                                                    </div>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" name="selectedSkills[]" type="checkbox" value="<?php echo $key ?>" id="defaultCheck1">
                                                                        <label class="form-check-label" for="defaultCheck1">
                                                                            <?php echo $value['title'] ?>
                                                                        </label>
                                                                    </div>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius:15px; background-color: #876e8f; border-color:#876e8f">Close</button>
                                                    <button type="delete" name="deleteVacancy" class="btn btn-primary" style="border-radius:15px; background-color: #a58aae; border-color:#876e8f">Delete</button>
                                                    <button type="submit" name="updateVacancy" class="btn btn-primary" style="border-radius:15px; background-color: #a58aae; border-color:#876e8f">Save changes</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

            <!-- Vacancies -->
            <div class="col-lg-3">
                <div class="vacancies-card">
                    <h class="connections-title" style="text-align:center">Recommended Vacancies</h>
                    <?php if (count($recommendedVacancies) == 0) {
                        echo "no vacancies to show.";
                    } else {
                        $numberOfVacanciesDisplayed = 0;
                        foreach ($recommendedVacancies as $key => $value) {
                            if ($numberOfVacanciesDisplayed == 4) break;
                            else {
                                $vacancyOrgData = $organisation->getOrganisationData($value['org_id']);
                                $numberOfVacanciesDisplayed += 1;
                            }
                    ?>
                            <div class="connection-row">
                                <div class="vacancy-header">
                                    <img src=https://dummyimage.com/40x40/cfcfcf/000000 class="rounded-circle" alt="...">
                                    <div class="vacancy-title">
                                        <h9><?php echo $vacancyOrgData['name'] ?></h9><br>
                                        <h9><?php echo $value['title'] ?></h9><br>
                                    </div>
                                </div>
                                <h9><?php echo $value['description'] ?></h9><br>
                                <h9><?php echo "Requirements: " . $value['required_experience'] ?></h9><br>
                                <br>
                                <a class="btn-small float-right" href="jobs.php">Apply</a>

                                <br>
                            </div>
                    <?php
                        }
                    }
                    ?>
                    <a class="btn-small float-center" href="jobs.php"> More</a>
                </div>
            </div>

        </div>
    </div>
    </body>

</html>