<?php
session_start();
include("../classes/connect.php");
include("../classes/user.php");
include("../classes/userQualification.php");
include("../classes/qualification.php");
include("../classes/userSkills.php");
include("../classes/skills.php");
include("../classes/star_sign.php");

//if user not logged in redirect to login
if (!isset($_SESSION['userid'])) {
    header("location: login.php");
}


if (isset($_POST['updateAbout'])) {
    $user = new User();
    $user->updateAbout($_SESSION['userid'], $_POST);
}

if (isset($_POST['updateQualification'])) {
    $user = new User();
    $user->updateQualification($_POST);
}

if (isset($_POST['updateSkills'])) {
    $user = new User();
    $user->updateSkills($_SESSION['userid'], $_POST);
}

$user = new User();
$userData = $user->getUserData($_SESSION['userid']);

$userQualification = new userQualification();
$userQualificationData = $userQualification->getUserQualificationData($_SESSION['userid']);
$qualification = new Qualification();
//$qualificationData = $qualification->getQualificationData();

$userSkills = new userSkills();
$userSkillsData = $userSkills->getUserSkills($_SESSION['userid']);
$skill = new Skill();
$allSkillsData = $skill->getAllSkills();

$selectedSkills = array();

// echo "<pre>";
// print_r($allSkillsData);
// echo "</pre>";

// echo "<pre>";
// print_r($userSkillsData);
// echo "</pre>";

echo "<pre>";
print_r($userQualificationData);
echo "</pre>";

if (!$userData) header("location: login.php");

?>

<!-- LEFT COLOURS IN FOR EASIER VIEW of whats going on -->
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
    <script>
        var arr = [];
    </script>
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
                    <?php
                    foreach ($userQualificationData as $key => $value) {
                        // echo "<pre>";
                        // print_r($userQualificationData);
                        // echo "</pre>";
                        $qualificationData = $qualification->getQualificationFromId($value['qualification_id']);
                        $id = $qualificationData['qualification_id'];
                    ?>
                        <div class="row mt-3">
                            <div class="card-qualifications">
                                <div class="qualification">
                                    <h8 class="size-change" id="margin-add"><strong><?php echo $qualificationData['institue'] ?></strong></h8><br>
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
                                <hr>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

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
                                            //if ($hasSkill == true) {
                                            if (array_key_exists($key, $userSkillsData)) {
                                        ?>
                                                <!-- <a type="button" id="inDB" class="badge badge-primary" style="background-color: #a58aae; border: 3px solid #000000">?php echo $value['title'] ?> <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span></a> -->
                                                <input id="submitButton" type="submit" onclick="myFunction(this, ' <?php echo $value['skill_id'] ?>', '<?php echo $key ?>')" class="button_submit btn-sm" style="margin-top:5px; color: #ffffff; background-color: #a58aae; border: 3px solid black; border-radius: 10px" value="<?php echo $value['title'] ?>" />
                                            <?php
                                            } else {
                                            ?>
                                                <!-- <a type="button" id="notInDB" class="badge badge-primary" style="background-color: #a58aae; border: 3px solid #a58aae">?php echo $value['title'] ?> <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span></a> -->
                                                <input id="submitButton" type="submit" onclick="myFunction(this, ' <?php echo $value['skill_id'] ?>', '<?php echo $key ?>')" class="button_submit btn-sm" style="margin-top:10px; color: #ffffff;background-color: #a58aae; border: 3px solid #a58aae; border-radius: 10px" value="<?php echo $value['title'] ?>" />
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>

                                    <script type="text/javascript">
                                        function myFunction(target, value, key) {
                                            console.log($(target).css("border-right-color"));
                                            if ($(target).css("border-right-color") == "rgb(0, 0, 0)") {
                                                target.style.border = "3px solid #a58aae";
                                                <?php unset($selectedSkills['<script>key</script>']); ?>
                                                //remove here
                                            } else {
                                                //add here
                                                target.style.border = "3px solid black";
                                                <?php array_push($selectedSkills, '<script>document.write(value)</script>'); ?>
                                            }
                                            <?php
                                            echo "<pre>";
                                            print_r($allSkillsData);
                                            echo "</pre>";
                                            ?>
                                            <?php $userSkills = $selectedSkills; ?>
                                        }
                                    </script>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius:15px; background-color: #876e8f; border-color:#876e8f">Close</button>
                                        <button type="submit" name="updateSkills" class="btn btn-primary" style="border-radius:15px; background-color: #a58aae; border-color:#876e8f">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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