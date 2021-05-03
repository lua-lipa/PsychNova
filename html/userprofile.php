<?php
session_start();
include("../classes/connect.php");
include("../classes/user.php");
include("../classes/userQualification.php");
include("../classes/qualification.php");
include("../classes/userSkills.php");
include("../classes/skills.php");
include("../classes/star_sign.php");
include("../classes/employmentHistory.php");

//if user not logged in redirect to login
if (!isset($_SESSION['userid'])) {
    header("location: login.php");
}

if (isset($_POST['updateAbout'])) {
    $user = new User();
    $user->updateAbout($_SESSION['userid'], $_POST);
}

if (isset($_POST['updateEmploymentHistory'])) {
    $user = new User();
    $user->updateEmploymentHistory($_POST);
    // $user->updateEmploymentHistoryOrg($_POST);
}

if (isset($_POST['updateQualification'])) {
    $user = new User();
    $user->updateQualification($_POST);
}

if (isset($_POST['deleteEmploymentHistory'])) {
    $userEmploymentHistory = new employmentHistory();
    $userEmploymentHistory->deleteEmploymentHistory($_POST);
}

$newSkills = array();
if (isset($_POST['updateSkills'])) {
    $userSkills = new userSkills();
    $userSkills->removeAllSkills($_SESSION['userid']);
    foreach ($_POST['selectedSkills'] as $selected) {
        echo ($selected);
        array_push($newSkills, $selected);
        $userSkills->addUserSkill($_SESSION['userid'], $selected);
    }
}

$user = new User();
$userData = $user->getUserData($_SESSION['userid']);

$userQualification = new userQualification();
$userQualificationData = $userQualification->getUserQualificationData($_SESSION['userid']);
$qualification = new Qualification();
$userJoinQualifications = $qualification->userJoinQualification($_SESSION['userid']);
$allQualifications = $qualification->getAllQualifications();

$userSkills = new userSkills();
$userSkillsData = $userSkills->getUserSkills($_SESSION['userid']);
$skill = new Skill();
$allSkillsData = $skill->getAllSkills();

$userEmploymentHistory = new employmentHistory();
$userEmploymentHistoryData = $userEmploymentHistory->getEmploymentHistoryData($_SESSION['userid']);
$allEmploymentHistoryData = $userEmploymentHistory->getAllEmploymentOptions();
$employmentHistoryJoinOrganisation = $userEmploymentHistory->employmentHistoryJoinOrganisation($_SESSION['userid']);

// echo "<pre>";
// print_r($allQualifications);
// echo "</pre>";

$selectedSkills = array();

if (!$userData) header("location: login.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("../components/head.php"); ?>
    <link rel="stylesheet" type="text/css" href="../css/profile-style.css">
    <title>Profile</title>
</head>

<body>

    <!-- navbar -->
    <?php include("../components/navbar.php"); ?>
    <div class="container mt-3">
        <div class="main-page">
            <div class="row">
                <div class="col-sm-9 pr-5">
                    <!--  style=" border: 2px solid green" -->
                    <div class="row card-profile">
                        <div class="col-sm-3">
                            <img src="../images/background-stars.jpg" class="img-circle" />
                            <div class="card-profile-info">
                                <p><?php echo $userData['first_name'] . " " . $userData['last_name'] ?></p>
                                <p><?php echo $userData['profession'] ?></p>
                                <p>Connections:</p>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="row float-right">

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
                                                    <label for="firstName" style="color:black">First name *</label> <input type="text" name="firstName" style="border-radius:5px;" value=<?php echo $userData['first_name'] ?> />
                                                    <br>
                                                    <label for="lastName" style="color:black">Last name *</label> <input type="text" name="lastName" style="border-radius:5px;" value=<?php echo $userData['last_name'] ?> />
                                                    <br>
                                                    <label for="dateOfBirth" style="color:black">Date of Birth *</label> <input type="date" name="dateOfBirth" style="border-radius:5px;" value="<?php echo $userData['date_of_birth'] ?>" />
                                                    <br>
                                                    <label for="description" style="color:black">Description *</label> <input type="text" name="description" style="margin-bottom:10px; height: 50px; width:95%; border-radius:5px;" maxlength="200" value="<?php echo $userData['description'] ?>" />
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
                            <div class="row h-50 d-flex justify-content-center">
                                <p class="mr-3 mt-5">Sun: <?php echo calcStarSign($userData['date_of_birth']) ?> </p>
                                <p class="mr-3 mt-5">Rising: Cancer</p>
                                <p class="mr-3 mt-5">Moon: Taurus</p>
                            </div>
                            <div class="row h-50">
                                <div class="card-about text-center px-4" ]>
                                    <h8><strong>About</strong></h8>
                                    <p><?php echo $userData['description'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ADD Employment History -->
                    <div class="row mt-3">
                        <div class="addEmpoymentHistory">
                            Employment History


                            <div class="modal fade" id="addEmploymentHistoryModal" tabindex=" -1" role="dialog" aria-labelledby="employmentHistoryModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="employmentHistoryModalLabel">Add Employment History</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="POST">
                                                <!-- DROP DOWNNN -->
                                                <label for="organisation" style="color:black">Organisation *</label>
                                                <select name="organisation" style="border-radius:5px;" value="<?php echo $value['position'] ?>">
                                                    <?php foreach ($allEmploymentHistoryData as $key_1 => $value_1) {
                                                    ?>
                                                        <option value=""><?php echo $value_1['org_id'] . ". " . $value_1['name'] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <br>
                                                <label for="position" style="color:black">Position *</label> <input type="text" name="position" style="border-radius:5px;" value="" />
                                                <br>
                                                <label for="startDate" style="color:black">Start Date *</label> <input type="date" name="startDate" style="border-radius:5px;" value="" />
                                                <br>
                                                <label for="endDate" style="color:black">End Date *</label> <input type="date" name="endDate" style="border-radius:5px;" value="" />
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius:15px; background-color: #876e8f; border-color:#876e8f">Close</button>
                                            <button type="submit" name="updateEmploymentHistory" class="btn btn-primary" style="border-radius:15px; background-color: #a58aae; border-color:#876e8f">Save changes</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Employment History DISPLAY -->
                    <?php
                    foreach ($employmentHistoryJoinOrganisation as $key => $value) {
                        // echo "<pre>";
                        // print_r($userQualificationData);
                        // echo "</pre>";
                        $id = "employmentModal" . $value['emp_his_id'];
                    ?>
                        <div class="row mt-3">
                            <div class="card-employmentHistory">
                                <div class="employmentHistory">
                                    <h8 class="size-change" id="margin-add"><strong><?php echo $value['name'] ?></strong></h8><br>
                                    <h9><?php echo $value['position'] ?></h9><br>
                                    <h9><?php echo $value['start_date'] . " - " .  $value['end_date']  ?></h9><br>
                                    <div class="row float-right">
                                        <button type="button" class="btn employmentHistory-button btn-primary" data-toggle="modal" data-target="#<?php echo $id ?>" style="margin-right:20px; margin-bottom:10px;">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <div class="modal fade" id="<?php echo $id ?>" tabindex=" -1" role="dialog" aria-labelledby="employmentHistoryModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="employmentHistoryModalLabel">Edit Employment History</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" method="POST">

                                                            <label for="organisation" style="color:black">Organisation *</label>
                                                            <select name="organisation" style="border-radius:5px;" value="<?php echo $value['name'] ?>">
                                                                <?php foreach ($allEmploymentHistoryData as $key_1 => $value_1) {
                                                                ?>
                                                                    <option value="<?php echo $value_1['name'] ?>"><?php echo $value_1['name'] ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <br>
                                                            <label for="position" style="color:black">Position *</label> <input type="text" name="position" style="border-radius:5px;" value='<?php echo $value['position'] ?>' />
                                                            <br>
                                                            <label for="endDate" style="color:black">End Date *</label> <input type="date" name="endDate" style="border-radius:5px;" value=<?php echo $value['end_date'] ?> />
                                                            <br>
                                                            <label for="startDate" style="color:black">Start Date *</label> <input type="date" name="startDate" style="border-radius:5px;" value=<?php echo $value['start_date'] ?> />
                                                            <br>
                                                            <input type="hidden" name="empHisId" style="border-radius:5px;" value="<?php echo $value['emp_his_id'] ?>" />
                                                            <input type="hidden" name="userId" style="border-radius:5px;" value="<?php echo $value['user_id'] ?>" />
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius:15px; background-color: #876e8f; border-color:#876e8f">Close</button>
                                                        <button type="delete" name="deleteEmploymentHistory" class="btn btn-primary" style="border-radius:15px; background-color: #a58aae; border-color:#876e8f">Delete</button>
                                                        <button type="submit" name="updateEmploymentHistory" class="btn btn-primary" style="border-radius:15px; background-color: #a58aae; border-color:#876e8f">Save changes</button>
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

                    <!-- ADD qualification -->
                    <div class="row mt-3">
                        <div class="addQualificaiton">
                            Qualifications
                            <div class="modal fade" id="addQualificationModal" tabindex=" -1" role="dialog" aria-labelledby="qualificationModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="qualificationModalLabel">Add a Qualifaction</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="" method="POST">
                                                <label for="qualification" style="color:black">Institute *</label>
                                                <select name="qualification" style="border-radius:5px;" value="<?php echo $value['name'] ?>">
                                                    <?php foreach ($allQualifications as $key_1 => $value_1) {
                                                    ?>
                                                        <option value=""><?php echo $value_1['title'] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <br>
                                                <label for="dateObtained" style="color:black">Date obtained *</label> <input type="date" name="dateObtained" style="border-radius:5px;" value="" />
                                                <br>
                                                <label for="title" style="color:black">Title *</label><input type="text" name="title" style="border-radius:5px;" value="" />
                                                <br>
                                                <label for="description" style="color:black">Description *</label><input type="text" name="description" style="border-radius:5px;" value="" />
                                                <br>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius:15px; background-color: #876e8f; border-color:#876e8f">Close</button>
                                            <button type="submit" name="addQualification" class="btn btn-primary" style="border-radius:15px; background-color: #a58aae; border-color:#876e8f">Save changes</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Qualifications DISPLAY -->
                    <?php
                    foreach ($userQualificationData as $key => $value) {
                        // echo "<pre>";
                        // print_r($userQualificationData);
                        // echo "</pre>";
                        $qualificationData = $qualification->getQualificationFromId($value['qualification_id']);
                        $id = "qualificationModal" . $qualificationData['qualification_id'];
                    ?>
                        <div class="row mt-3">
                            <div class="card-qualification">
                                <div class="qualification">
                                    <h8 class="size-change" id="margin-add"><strong><?php echo $qualificationData['institute'] ?></strong></h8><br>
                                    <h9><?php echo $qualificationData['title'] ?></h9><br>
                                    <h9><?php echo $value['date_obtained'] ?></h9><br>
                                    <p><?php echo $qualificationData['description'] ?></p>
                                    <div class="row float-right">
                                        <button type="button" class="btn qualification-button btn-primary" data-toggle="modal" data-target="#<?php echo $id ?>" style="margin-right:20px; margin-bottom:10px;">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <div class="modal fade" id="<?php echo $id ?>" tabindex=" -1" role="dialog" aria-labelledby="qualificationModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="qualificationModalLabel">Edit Qualifications</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="" method="POST">
                                                            <label for="dateObtained" style="color:black">Date obtained *</label> <input type="date" name="dateObtained" style="border-radius:5px;" value=<?php echo $value['date_obtained'] ?> />
                                                            <input type="hidden" name="userQualificationId" value=<?php echo $value['u_qualification_id'] ?> />
                                                            <br>
                                                            <label for="institute" style="color:black">Institute *</label><input type="text" name="institute" style="border-radius:5px;" value='<?php echo $qualificationData['institute'] ?>' />
                                                            <br>
                                                            <label for="title" style="color:black">Title *</label><input type="text" name="title" style="border-radius:5px;" value='<?php echo $qualificationData['title'] ?>' />
                                                            <br>
                                                            <label for="description" style="color:black">Description *</label><input type="text" name="description" style="border-radius:5px;" value='<?php echo $qualificationData['description'] ?>' />
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius:15px; background-color: #876e8f; border-color:#876e8f">Close</button>
                                                        <button type="submit" name="updateQualification" class="btn btn-primary" style="border-radius:15px; background-color: #a58aae; border-color:#876e8f">Save changes</button>
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

                    <!-- Skills -->
                    <div class="row mt-3">
                        <?php
                        foreach ($userSkillsData as $key => $value) {
                            $skillsData = $skill->getSkillFromId($value['skill_id']);
                        ?>
                            <div class="skills" style="flex-wrap: wrap;">
                                <span type="badge badge-primary" class="badge-skill" style="background-color: #876e8f;  margin-bottom:20px;"><?php echo $skillsData['title'] ?> </span>
                            </div>

                        <?php
                        }
                        ?>


                        <div class="modal fade" id="editSkillsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editSkillsModal">Edit Skills</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <form action="" method="post" class="form-inline">
                                            <div class="form-group">
                                                <?php foreach ($allSkillsData as $key => $value) {
                                                    //if ($hasSkill == true) {
                                                    if (array_key_exists($key, $userSkillsData)) {
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
                                    </script>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius:15px; background-color: #876e8f; border-color:#876e8f">Close</button>
                                        <button type="submit" name="updateSkills" class="btn btn-primary" style="border-radius:15px; background-color: #a58aae; border-color:#876e8f">Save changes</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vacancies -->
                <div class="col-sm-3">
                    <div class="card-vacancies text-center">
                        <h9>Recent Vacancies</h8>
                            <div class="card-1">
                                <p style="margin-top: 10px;"><strong>Witch Academy</strong></p>
                                <p>Looking for a witch</p>
                                <button class="more-info-btn btn-default" type="submit">More info</button>
                            </div>
                            <hr>
                            <div class="card-2">
                                <p style="margin-top: 10px;"><strong>Witch Academy</strong></p>
                                <p>Looking for a witch</p>
                                <button class="more-info-btn btn-default" type="submit">More info</button>
                            </div>
                            <hr>
                            <div class="card-3">
                                <p style="margin-top: 10px;"><strong>Witch Academy</strong></p>
                                <p>Looking for a witch</p>
                                <button class="more-info-btn btn-default" type="submit">More info</button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>