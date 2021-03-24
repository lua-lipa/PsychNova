<?php
session_start();
include("./classes/connect.php");
include("./classes/user.php");
include("./classes/userQualification.php");
include("./classes/qualification.php");
include("./classes/userSkills.php");
include("./classes/skills.php");

//if user not logged in redirect to login
if (!isset($_SESSION['userid'])) {
    header("location: login.php");
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
// echo "<pre>";
// print_r($userSkillsData);
// echo "</pre>";

if (!$userData) header("location: login.php");

?>

<!-- LEFT COLOURS IN FOR EASIER VIEW of whats going on -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./css/profile-style.css">
    <script src="https://kit.fontawesome.com/0bb62d8e50.js" crossorigin="anonymous"></script>
    <title>Profile</title>
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="col-md-2"></a>
        <a class="navbar-brand" href="#">PsychNova</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- search bar -->
            <form class="col-md-5 form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search for people, companies, jobs ... " aria-label="Search">
                <button class="btn btn-default" id="search-btn" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <!-- navbar links -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="#Home">Home <span class="sr-only">(current)</span></a></li>
                <li class="nav-item"><a class="nav-link" href="#Organisation">Organisation</a></li>
                <li class="nav-item"><a class="nav-link" href="#Vacancies">Vacancies</a></li>
                <li class="nav-item"><a class="nav-link" href="#Profile">People</a></li>
                <li class="nav-item"><a class="nav-link" href="#Profile">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-3">
        <div class="main-page">
            <div class="row">
                <div class="col-sm-9 pr-5">
                    <!--  style=" border: 2px solid green" -->
                    <div class="row card-profile">
                        <div class="col-sm-3">
                            <img src="../images/jlo.jpg" class="img-circle" />
                            <div class="card-profile-info">
                                <p><?php echo $userData['first_name'] . " " . $userData['last_name'] ?></p>
                                <p><?php echo $userData['profession'] ?></p>
                                <p>Connections:</p>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="row h-50 d-flex justify-content-center">
                                <p class="mr-3 mt-5">Sun: Gemini </p>
                                <p class="mr-3 mt-5">Rising: Cancer</p>
                                <p class="mr-3 mt-5">Moon: Taurus</p>
                            </div>
                            <div class="row h-50">
                                <div class="card-about text-center px-4">
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
                    ?>
                        <div class="row mt-3">
                            <div class="card-qualifications">
                                <div class="qualification">
                                    <h8 class="size-change" id="margin-add"><strong><?php echo $qualificationData['institute'] ?></strong></h8><br>
                                    <h9><?php echo $qualificationData['title'] ?></h9><br>
                                    <p><?php echo $qualificationData['description'] ?></p>
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
                            <div class="col mt-3">
                                <div class="card-skills">
                                    <div class="skills" style="flex-wrap: wrap;">
                                        <h9><?php echo $skillsData['title'] ?></h9><br>
                                        <p><?php echo $skillsData['description'] ?></p>
                                    </div>
                                </div>
                            </div>

                        <?php
                        }
                        ?>
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