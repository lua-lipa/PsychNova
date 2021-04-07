<?php
session_start();
include("../classes/connect.php");
include("../classes/organisation.php");
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
                        $userOrg = $org->getOrganisationData($value['org_id']);
                ?>
                        <div class="result-card">
                            <div class="result-container">
                                <div class="col-3">
                                    <img src="https://dummyimage.com/64x64/cfcfcf/000000" class="rounded-circle" alt="...">
                                </div>
                                <div class="col-9">
                                    <div class="row">
                                        <h6><?php echo $userOrg['name']?></h6>
                                    </div>
                                    <div class="row">
                                        <h7>Established: <?php echo $userOrg['date_established'] ?></h7>
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