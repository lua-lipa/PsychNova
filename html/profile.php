<?php
session_start();
include("../classes/connect.php");
include("../classes/user.php");
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
    $user->updateEmploymentHistoryOrg($_POST);
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

$userSkills = new userSkills();
$userSkillsData = $userSkills->getUserSkills($_SESSION['userid']);
$skill = new Skill();
$allSkillsData = $skill->getAllSkills();

$userEmploymentHistory = new employmentHistory();
$userEmploymentHistoryData = $userEmploymentHistory->getEmploymentHistoryData($_SESSION['userid']);
$allEmploymentHistoryData = $userEmploymentHistory->getAllEmploymentOptions();
$employmentHistoryJoinOrganisation = $userEmploymentHistory->employmentHistoryJoinOrganisation($_SESSION['userid']);

echo "<pre>";
print_r($employmentHistoryJoinOrganisation);
echo "</pre>";

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
                                <button type="button" style="margin-right: 30px; margin-top: 10px; background-color: #ffffff; color: #000000; height: 35px; border-color: #876e8f; border-radius:50px;" class="btn btn-primary" data-toggle="modal" data-target="#editAboutModal">
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

                    <!-- Employment History -->
                    <div class="row mt-3">
                        <div class="addEmpoymentHistory">
                            <button type="button" style="margin-right: 30px; margin-top: 10px; background-color: #ffffff; color: #000000; height: 35px; border-color: #876e8f; border-radius:50px;" class="btn btn-primary" data-toggle="modal" data-target="#addEmploymentHistoryModal">
                                <i class="bi bi-plus"></i>
                            </button>

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

                    <!-- Qualifications -->
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
                                                            <input type="hidden" name="empHistoryId" value=<?php echo $value['emp_his_id'] ?> />
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
                                    <hr>
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
                        <button type="button" onclick="<?php $selectedSkills = $userSkillsData ?>" style="margin-bottom:20px; background-color: #ffffff; color: #000000; height: 35px; border-color: #876e8f; border-radius:50px;" class="btn btn-primary" data-toggle="modal" data-target="#editSkillsModal">
                            <i class="bi bi-pencil"></i>
                        </button>

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
                                        <?php foreach ($allSkillsData as $key => $value) {
                                            if (array_key_exists($key, $userSkillsData)) {
                                        ?>
                                                <input id="submitButton" type="submit" onclick="myFunction(this, ' <?php echo $value['skill_id'] ?>', '<?php echo $key ?>' )" class="button_submit btn-sm" style="margin-top:5px; color: #ffffff; background-color: #a58aae; border: 3px solid black; border-radius: 10px" value="<?php echo $value['title'] ?>" />
                                            <?php
                                            } else {
                                            ?>
                                                <input id="submitButton" type="submit" onclick="myFunction(this, ' <?php echo $value['skill_id'] ?>', '<?php echo $key ?>')" class="button_submit btn-sm" style="margin-top:10px; color: #ffffff;background-color: #a58aae; border: 3px solid #a58aae; border-radius: 10px" value="<?php echo $value['title'] ?>" />
                                        <?php
                                            }
                                        }
                                        ?>
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

                                    <script type="text/javascript">
                                        function myFunction(target, value, key) {
                                            console.log($(target).css("border-right-color"));
                                            if ($(target).css("border-right-color") == "rgb(0, 0, 0)") {
                                                target.style.border = "3px solid #a58aae";
                                                //remove here
                                            } else {
                                                //add here
                                                target.style.border = "3px solid black";
                                            }
                                        }
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