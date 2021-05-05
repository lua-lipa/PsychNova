<?php
session_start();
include("../classes/connect.php");
include("../classes/user.php");
include("../classes/qualification.php");
include("../classes/userSkills.php");
include("../classes/skills.php");
include("../classes/star_sign.php");
include("../classes/employmentHistory.php");
include("../classes/vacancy.php");
include("../classes/organisation.php");
include("../classes/connections.php");

//if user not logged in redirect to login
if (!isset($_SESSION['userid'])) {
    header("location: login.php");
}

if (isset($_POST['updateAbout'])) {
    $user = new User();
    $user->updateAbout($_GET['userid'], $_POST);
}

if (isset($_POST['updateEmploymentHistory'])) {
    $user = new User();
    $user->updateEmploymentHistory($_POST);
    // $user->updateEmploymentHistoryOrg($_POST);
}

if (isset($_POST['addEmploymentHistory'])) {
    $employmentHistory = new employmentHistory();
    $employmentHistory->addEmploymentHistory($_GET['userid'], $_POST);
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

if (isset($_POST['addQualification'])) {
    $qualification = new Qualification();
    $qualification->addUserQualification($_GET['userid'], $_POST);
}

if (isset($_POST['deleteQualification'])) {
    $qualification = new Qualification();
    $qualification->deleteQualification($_GET['userid'], $_POST);
}
// echo "<pre>";
// print_r($_POST['updateQualification']);
// echo "</pre>";

$newSkills = array();
if (isset($_POST['updateSkills'])) {
    $userSkills = new userSkills();
    $userSkills->removeAllSkills($_GET['userid']);
    foreach ($_POST['selectedSkills'] as $selected) {
        echo ($selected);
        array_push($newSkills, $selected);
        $userSkills->addUserSkill($_GET['userid'], $selected);
    }
}

$user = new User();
$userData = $user->getUserData($_GET['userid']);
$loggedInUserData = $user->getUserData($_SESSION['userid']);
$userType = $loggedInUserData['type'];

$qualification = new Qualification();
$userQualificationData = $qualification->getUserQualificationData($_GET['userid']);
$allQualifications = $qualification->getAllQualificationData();

$userSkills = new userSkills();
$userSkillsData = $userSkills->getUserSkills($_GET['userid']);
$skill = new Skill();
$allSkillsData = $skill->getAllSkills();

$userEmploymentHistory = new employmentHistory();
$userEmploymentHistoryData = $userEmploymentHistory->getEmploymentHistoryData($_GET['userid']);
$allEmploymentHistoryData = $userEmploymentHistory->getAllEmploymentOptions();
$employmentHistoryJoinOrganisation = $userEmploymentHistory->employmentHistoryJoinOrganisation($_GET['userid']);

$vacancy = new vacancy();
$recommendedVacancies = $vacancy->getVacancies();

$organisation = new organisation();

$connections = new connections();
$connectionsData = $connections->getUserConnections($_GET['userid']);
$connectionsNumber = count($connectionsData);

// echo "<pre>";
// print_r($allQualifications);
// echo "</pre>";

$selectedSkills = array();

if (!$userData) header("location: login.php");

?>

<!DOCTYPE html>
<html>

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
                <div class="col-lg-9 pr-5">
                    <div class="row card-profile">
                        <div class="col-3 d-flex justify-content-center align-items-center">
                            <img src="<?php echo $userData['profile_picture'] ?>" class="img-fluid img-circle" />
                        </div>
                        <div class="col-6 pl-3 d-flex justify-content-center align-items-start flex-column">
                            <div class="row">
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
                                                    <label for="firstName" style="color:black">First name</label> <input class="form-control" type="text" name="firstName" style="border-radius:5px;" value=<?php echo $userData['first_name'] ?> />
                                                    <br>
                                                    <label for="lastName" style="color:black">Last name</label> <input class="form-control" type="text" name="lastName" style="border-radius:5px;" value=<?php echo $userData['last_name'] ?> />
                                                    <br>
                                                    <label for="dateOfBirth" style="color:black">Date of Birth</label> <input class="form-control" type="date" name="dateOfBirth" style="border-radius:5px;" value="<?php echo $userData['date_of_birth'] ?>" />
                                                    <br>
                                                    <label for="description" style="color:black">Description</label> <input class="form-control" type="text" name="description" style="margin-bottom:10px; height: 50px; width:95%; border-radius:5px;" maxlength="200" value="<?php echo $userData['description'] ?>" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="updateAbout" class="btn btn-primary" style="border-radius:15px; background-color: #a58aae; border-color:#876e8f">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h4 class="user-name"><?php echo $userData['first_name'] . " " . $userData['last_name'] ?></h4>
                            </div>
                            <div class="row">
                                <p class="user-profession"><?php echo $userData['profession'] ?></p>
                            </div>
                            <div class="row">
                                <p class="astro-sun"><i class="bi bi-sun"></i> <?php echo calcStarSign($userData['date_of_birth']) ?> </p>
                                <p class="astro-rising"><i class="bi bi-sunrise"></i> <?php echo calcRising() ?></p>
                                <p class="astro-moon"><i class="bi bi-moon"></i> <?php echo calcMoon() ?></p>
                            </div>
                            <div class="row">
                                <p class="user-connections">Connections: <?php echo $connectionsNumber ?> </p>
                            </div>
                            <!-- <div class="row h-50 justify-content-center" style="margin-right:15%; margin-bottom:15%;">
                                <p class="mr-3 mt-5" style="font-size: 18px;"><i class="bi bi-sun" style="color:white"></i> <?php echo calcStarSign($userData['date_of_birth']) ?> </p>
                                <p class="mr-3 mt-5" style="font-size: 18px;"><i class="bi bi-sunrise" style="color:white"></i> Cancer</p>
                                <p class="mr-3 mt-5" style="font-size: 18px;"><i class="bi bi-moon" style="color:white"></i> Taurus</p>
                            </div> -->
                        </div>
                        <div class="col-3 d-flex flex-column justify-content-between">
                            <?php
                            if ($userType == 'administrator' || $_SESSION['userid'] == $_GET['userid']) {
                            ?>
                                <div class="row d-flex justify-content-end">
                                    <button type="button" style="margin-right: 10px; margin-top: 10px; background-color: #ffffff; color: #000000; height: 35px; border-color: #876e8f; border-radius:50px;" class="btn btn-primary" data-toggle="modal" data-target="#editAboutModal">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                            <?php
                            }
                            ?>


                            <div class="row d-flex justify-content-end align-items-end">
                                <button type="button" name="connectButton" style="margin-bottom: 15px; margin-right: 15px; margin-top: 10px; background-color: #ffffff; color: #000000; height: 35px; border-color: #876e8f; border-radius:50px;" class="btn btn-primary" data-toggle="modal" data-target="#editAboutModal">
                                    Connect
                                </button>
                                <?php
                                if ($userType == 'administrator') {
                                ?>
                                    <button type="button" name="banButton" style="margin-bottom: 15px; margin-right: 15px; margin-top: 10px; background-color: #ffffff; color: #000000; height: 35px; border-color: #876e8f; border-radius:50px;" class="btn btn-primary">
                                        Ban
                                    </button>
                                <?php
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                    <div class="row h-22 mt-3">
                        <div class="col">
                            <div class="row mt-2">
                                <h8 class="mb-2">About</h8>
                            </div>
                            <div class="row card-about" ]>
                                <p style=""><?php echo $userData['description'] ?></p>
                            </div>
                        </div>

                    </div>

                    <!-- ADD Employment History -->
                    <div class="row mt-3">
                        <div class="col-9">
                            <div class="row">
                                <h8>Employment History</h8>
                            </div>
                        </div>
                        <?php
                        if ($userType == 'administrator' || $_SESSION['userid'] == $_GET['userid']) {
                        ?>
                            <div class="col-3 d-flex justify-content-end">
                                <div class="row">
                                    <button type="button" style=" background-color: #ffffff; color: #000000; height: 35px; border-color: #876e8f; border-radius:50px;" class="btn btn-primary" data-toggle="modal" data-target="#addEmploymentHistoryModal">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

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
                                            <div class="form-group">
                                                <!-- DROP DOWN -->
                                                <label id="searchLabel" for="organisation" style="color:black">Organisation *</label>
                                                <input autocomplete="off" class="form-control" value="" id="search" type="search" placeholder="" name="organisation">
                                                <div class="list-group" id="show-list">
                                                    <!-- <a href="#" class="list-group-item list-group-item-action">List 1</a> -->
                                                </div>
                                                <input name="orgId" id="orgId" type="hidden">
                                                <br>
                                                <label for="position" style="color:black">Position *</label>
                                                <input class="form-control" type="text" name="position" style="border-radius:5px;" value="" />
                                                <br>
                                                <label for="startDate" style="color:black">Start Date *</label>
                                                <input class="form-control" type="date" name="startDate" style="border-radius:5px;" value="" />
                                                <br>
                                                <label for="endDate" style="color:black">End Date *</label>
                                                <input class="form-control" type="date" name="endDate" style="border-radius:5px;" value="" />
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="addEmploymentHistory" class="btn btn-primary" style="border-radius:15px; background-color: #a58aae; border-color:#876e8f">Save changes</button>
                                    </div>
                                    </form>
                                    <script type="text/javascript">
                                        let orgId
                                        $(document).ready(function() {
                                            $("#search").keyup(function() {
                                                $("#searchLabel").text("Organisation *")
                                                $("#orgId").val(0);
                                                $("#orgId").text(0);
                                                let searchText = $(this).val();
                                                if (searchText != "") {
                                                    $.ajax({
                                                        url: "autocomplete.php",
                                                        method: "post",
                                                        data: {
                                                            query: searchText,
                                                        },
                                                        success: function(response) {
                                                            $("#show-list").html(response);
                                                        },
                                                    });
                                                } else {
                                                    $("#show-list").html("");
                                                }
                                            });
                                            // Set searched text in input field on click of search button
                                            $(document).on("click", "a", function() {
                                                $("#search").val($(this).text());
                                                $("#orgId").val($(this).attr("value"));
                                                $("#orgId").text($(this).attr("value"));
                                                $("#show-list").html("");
                                                $("#searchLabel").text("Organisation * PsychNova")

                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Employment History DISPLAY -->
                    <?php
                    if (empty($employmentHistoryJoinOrganisation)) {
                    ?>
                        <div class="row mt-3">
                            <div class="card-no-result d-flex align-items-center">
                                <p>No Employment History Found</p>
                            </div>
                        </div>
                        <?php
                    } else {

                        foreach ($employmentHistoryJoinOrganisation as $key => $value) {
                            // echo "<pre>";
                            // print_r($userQualificationData);
                            // echo "</pre>";
                            $id = "employmentModal" . $value['emp_his_id'];
                        ?>
                            <div class="row mt-3">
                                <div class="card-employmentHistory">
                                    <div class="employmentHistory d-flex">
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <h8 class="size-change" style="font-size: 18px" id="margin-add"><strong><?php if ($value['org_id'] == 0) {
                                                                                                                            echo $value['organisation_name'];
                                                                                                                        } else {
                                                                                                                            echo $value['name'];
                                                                                                                        } ?></strong></h8><br>
                                            </div>
                                            <div class="row">
                                                <h9 style="font-size: 12px"><?php echo $value['position'] ?></h9><br>
                                            </div>
                                            <div class="row">
                                                <h9><?php echo $value['start_date'] . " - " .  $value['end_date']  ?></h9><br>
                                            </div>


                                        </div>

                                        <?php
                                        if ($userType == 'administrator' || $_SESSION['userid'] == $_GET['userid']) {
                                        ?>
                                            <div class="col-lg-3">
                                                <div class="row d-flex justify-content-end align-items-end">
                                                    <button type="button" class="btn employmentHistory-button btn-primary" data-toggle="modal" data-target="#<?php echo $id ?>">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>


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
                                                        <div class="form-group">
                                                            <!-- DROP DOWN -->
                                                            <label id="searchLabel" for="organisation" style="color:black">Organisation *</label>
                                                            <input autocomplete="off" class="form-control" id="search" type="search" placeholder="" name="organisation" value="<?php if ($value['org_id'] == 0) {
                                                                                                                                                                                    echo $value['organisation_name'];
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo $value['name'];
                                                                                                                                                                                } ?>">
                                                            <div class="list-group" id="show-list">
                                                                <!-- <a href="#" class="list-group-item list-group-item-action">List 1</a> -->
                                                            </div>
                                                            <input name="orgId" id="orgId" type="hidden">
                                                            <br>
                                                            <label for="position" style="color:black">Position *</label>
                                                            <input class="form-control" type="text" name="position" style="border-radius:5px;" value="<?php echo $value['position'] ?>" />
                                                            <br>
                                                            <label for="startDate" style="color:black">Start Date *</label>
                                                            <input class="form-control" type="date" name="startDate" style="border-radius:5px;" value="<?php echo $value['start_date'] ?>" />
                                                            <br>
                                                            <label for="endDate" style="color:black">End Date *</label>
                                                            <input class="form-control" type="date" name="endDate" style="border-radius:5px;" value="<?php echo $value['end_date'] ?>" />
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="deleteEmploymentHistory" class="btn btn-primary" style="border-radius:15px; background-color: #a58aae; border-color:#876e8f">Delete</button>
                                                    <button type="submit" name="updateEmploymentHistory" class="btn btn-primary" style="border-radius:15px; background-color: #a58aae; border-color:#876e8f">Save changes</button>
                                                </div>
                                                </form>
                                                <script type="text/javascript">
                                                    let orgId
                                                    $(document).ready(function() {
                                                        $("#search").keyup(function() {
                                                            $("#searchLabel").text("Organisation *")
                                                            $("#orgId").val(0);
                                                            $("#orgId").text(0);
                                                            let searchText = $(this).val();
                                                            if (searchText != "") {
                                                                $.ajax({
                                                                    url: "autocomplete.php",
                                                                    method: "post",
                                                                    data: {
                                                                        query: searchText,
                                                                    },
                                                                    success: function(response) {
                                                                        $("#show-list").html(response);
                                                                    },
                                                                });
                                                            } else {
                                                                $("#show-list").html("");
                                                            }
                                                        });
                                                        // Set searched text in input field on click of search button
                                                        $(document).on("click", "a", function() {
                                                            $("#search").val($(this).text());
                                                            $("#orgId").val($(this).attr("value"));
                                                            $("#orgId").text($(this).attr("value"));
                                                            $("#show-list").html("");
                                                            $("#searchLabel").text("Organisation * PsychNova")

                                                        });
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>

                    <!-- ADD qualification -->
                    <div class="row mt-3">
                        <div class="col-9">
                            <div class="row">
                                <h8>Qualifications</h8>
                            </div>
                        </div>
                        <?php
                        if ($userType == 'administrator' || $_SESSION['userid'] == $_GET['userid']) {
                        ?>
                            <div class="col-3 d-flex justify-content-end">
                                <div class="row">
                                    <button type="button" style=" background-color: #ffffff; color: #000000; height: 35px; border-color: #876e8f; border-radius:50px;" class="btn btn-primary" data-toggle="modal" data-target="#addQualificationModal">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
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
                                            <label for="institute" style="color:black">Institute</label> <input class="form-control" type="text" name="institute" style="border-radius:5px;" value="" />
                                            <br>
                                            <label for="title" style="color:black">Title</label><input class="form-control" type="text" name="title" style="border-radius:5px;" value="" />
                                            <br>
                                            <label for="dateObtained" style="color:black">Date obtained</label> <input class="form-control" type="date" name="dateObtained" style="border-radius:5px;" value="" />
                                            <br>
                                            <label for="description" style="color:black">Description</label><input class="form-control" type="text" name="description" style="border-radius:5px;" value="" />
                                            <br>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="addQualification" class="btn btn-primary" style="border-radius:15px; background-color: #a58aae; border-color:#876e8f">Save changes</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Qualifications DISPLAY -->
                    <?php
                    foreach ($userQualificationData as $key => $value) {
                        $qualificationData = $qualification->getQualificationFromId($value['qualification_id']);
                        $id = "qualificationModal" . $qualificationData['qualification_id'];
                    ?>
                        <div class="row mt-3">
                            <div class="card-qualification">
                                <div class="qualification d-flex">
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <h8 class="size-change" style="font-size: 18px" id="margin-add"><strong><?php echo $qualificationData['institute'] ?></strong></h8><br>
                                        </div>
                                        <div class="row">
                                            <h9><?php echo $value['title'] ?></h9><br>
                                        </div>
                                        <div class="row">
                                            <h9><?php echo $value['date_obtained'] ?></h9><br>
                                        </div>
                                        <div class="row">
                                            <p><?php echo $value['description'] ?></p>
                                        </div>

                                    </div>

                                    <?php
                                    if ($userType == 'administrator' || $_SESSION['userid'] == $_GET['userid']) {
                                    ?>
                                        <div class="col-lg-3">
                                            <div class="row d-flex justify-content-end align-items-end">
                                                <button type="button" class="btn employmentHistory-button btn-primary" data-toggle="modal" data-target="#<?php echo $id ?>">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>

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
                                                        <label for="dateObtained" style="color:black">Date obtained</label> <input class="form-control" type="date" name="dateObtained" style="border-radius:5px;" value=<?php echo $value['date_obtained'] ?> />
                                                        <br>
                                                        <label for="institute" style="color:black">Institute</label><input class="form-control" type="text" name="institute" style="border-radius:5px;" value='<?php echo $qualificationData['institute'] ?>' />
                                                        <br>
                                                        <label for="title" style="color:black">Title</label><input class="form-control" type="text" name="title" style="border-radius:5px;" value='<?php echo $qualificationData['title'] ?>' />
                                                        <br>
                                                        <label for="description" style="color:black">Description</label><input class="form-control" type="text" name="description" style="border-radius:5px;" value='<?php echo $qualificationData['description'] ?>' />

                                                        <input type="hidden" name="qualificationId" value=<?php echo $value['qualification_id'] ?> />
                                                        <input type="hidden" name="userId" value=<?php echo $value['user_id'] ?> />

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="delete" name="deleteQualification" class="btn btn-primary" style="border-radius:15px; background-color: #a58aae; border-color:#876e8f">Delete</button>
                                                    <button type="submit" name="updateQualification" class="btn btn-primary" style="border-radius:15px; background-color: #a58aae; border-color:#876e8f">Save changes</button>
                                                </div>
                                                </form>
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
                        <h8>Skills</h8>
                    </div>
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

                        <?php
                        if ($userType == 'administrator' || $_SESSION['userid'] == $_GET['userid']) {
                        ?>
                            <button type="button" onclick="<?php $selectedSkills = $userSkillsData ?>" style="margin-bottom:20px; background-color: #ffffff; color: #000000; height: 35px; border-color: #876e8f; border-radius:50px;" class="btn btn-primary" data-toggle="modal" data-target="#editSkillsModal">
                                <i class="bi bi-pencil"></i>
                            </button>
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
                                        <form action="" method="post">
                                            <div class="form-group">
                                                <?php foreach ($allSkillsData as $key => $value) {
                                                    //if ($hasSkill == true) {
                                                    if (array_key_exists($key, $userSkillsData)) {
                                                ?>
                                                        <BR/>
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="selectedSkills[]" type="checkbox" value="<?php echo $key ?>" id="defaultCheck1" checked>
                                                            <label class="form-check-label" for="defaultCheck1">
                                                                <?php echo $value['title'] ?>
                                                            </label>
                                                        </div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <BR/>
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
                                        <button type="submit" name="updateSkills" class="btn btn-primary" style="border-radius:15px; background-color: #a58aae; border-color:#876e8f">Save changes</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vacancies -->
                <div class="col-lg-3">
                    <div class="vacancies-card">
                        <h7 style="text-align:center">Recommended Vacancies</h7>
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

                                <div class="row mt-2">
                                    <div class="col">
                                        <div class="row">
                                            <h9 style="color: #876e8f"><?php echo $value['title'] ?></h9><br>
                                        </div>
                                        <div class="row">
                                            <h9 style="font-weight: lighter"><?php echo $vacancyOrgData['name'] ?></h9><br>
                                        </div>
                                    </div>
                                    <div class="col d-flex justify-content-end align-items-center">
                                        <a class="btn btn-purple" href="jobs.php">Apply</a>
                                    </div>
                                </div>

                                <!-- <div class="connection-row">
                                    <div class="vacancy-header">
                                        <div class="vacancy-title">
                                            
                                        </div>
                                    </div>
                                    <br>
                                    <a class="btn float-right" href="jobs.php">Apply</a>

                                    <br>
                                </div> -->
                        <?php
                            }
                        }
                        ?>
                        <a class="btn float-center" href="jobs.php"> More</a>
                    </div>
                </div>

            </div>
        </div>
</body>

</html>