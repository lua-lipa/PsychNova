<?php
session_start();
include("../classes/connect.php");
include("../classes/organisation.php");
include("../classes/user.php");
include("../classes/userOrganisations.php");

if (!isset($_SESSION['userid'])) {
    header("location: login.php");
}

$user = new User();
$userData = $user->getUserData($_SESSION['userid']);

$org = new organisation();

$userOrganisations = new userOrganisations();
$userOrganisationsData = $userOrganisations->getUserOrganisations($_SESSION['userid']);

?>

<html>

<head>
    <title> PsychNova </title>
    <?php include("../components/head.php"); ?>
    <link href="../css/myOrganisations.css" rel="stylesheet">
</head>

<body>
    <?php include("../components/navbar.php"); ?>
    <div class="container">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <?php
                foreach ($userOrganisationsData as $key => $value) {
                ?>
                    <div class="result-card">
                        <div class="result-container">
                            <div class="col-3">
                                <img src="https://dummyimage.com/64x64/cfcfcf/000000" class="rounded-circle" alt="...">
                            </div>
                            <div class="col-9">
                                <div class="row">
                                    <h6><a href="http://localhost/psychnova_official_2/PsychNova/html/organisation_profile.php" style="color: black"><?php echo $value['name'] ?></h6>
                                </div>
                                <div class="row">
                                    <h7>Established: <?php echo $value['date_established'] ?></h7>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="col-3"></div>
        </div>
    </div>

</body>

</html>