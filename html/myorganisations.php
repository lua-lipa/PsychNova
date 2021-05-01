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
    <div class="container-fluid">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <h5> Create a new PsychNova organisation or view an existing one. </h5>
            </div>
            <div class="col-3"></div>
        </div>
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="result-card">
                    <h6 class="cardTitle"> Your organisations </h6>
                    <div class="scrolling-wrapper row flex-row flex-nowrap mt-4 pb-4 pt-2">
                        <div class="col-4">
                            <div class="card card-block card-1">
                                <div class="profile-image">
                                    <img src="https://dummyimage.com/100x100/cfcfcf/000000" class="rounded-circle" alt="...">
                                </div>
                                <div class="profile-name">
                                    <h6>Honest Potions</h6>
                                    <button class="myBtn" href="../html/organisation_profile"> View </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card card-block card-1">
                                <div class="profile-image">
                                    <img src="https://dummyimage.com/100x100/cfcfcf/000000" class="rounded-circle" alt="...">
                                </div>
                                <div class="profile-name">
                                    <h6>Honest Potions</h6>
                                    <button class="myBtn"> View </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card card-block card-1">
                                <div class="profile-image">
                                    <img src="https://dummyimage.com/100x100/cfcfcf/000000" class="rounded-circle" alt="...">
                                </div>
                                <div class="profile-name">
                                    <h6>Honest Potions</h6>
                                    <button class="myBtn"> View </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card card-block card-1">
                                <div class="profile-image">
                                    <img src="https://dummyimage.com/100x100/cfcfcf/000000" class="rounded-circle" alt="...">
                                </div>
                                <div class="profile-name">
                                    <h6>Honest Potions</h6>
                                    <button class="myBtn"> View </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <button type="button" class="orgBtn btn-block"> Create a new organisation </button>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</body>

</html>