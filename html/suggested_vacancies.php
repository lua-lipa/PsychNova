<?php
session_start();
include("../classes/connect.php");
include("../classes/user.php");
include("../classes/organisation.php");
include("../classes/vacancy.php");

//if user not logged in redirect to login
if (!isset($_SESSION['userid'])) {
    header("location: login.php");
}

$vacancy = new vacancy();
$organisation = new organisation();

$recommendedVacancies = $vacancy->suggestedVacancies($_SESSION['userid']);

?>
<!DOCTYPE html>
<html>

<head>
    <title> PsychNova </title>
    <?php include("../components/head.php"); ?>
    <link href="../css/jobs.css" rel="stylesheet">
</head>

<body>
    <?php
    include("../components/navbar.php");
    ?>
    <div class="container">
        <div class="row title">
            <h2>Recommended Vacancies</h2>
        </div>
        <div class="row main-column">
            <div class="col-lg-12">
                <?php

                if (empty($recommendedVacancies)) {
                    echo "no search results";
                } else {



                    foreach ($recommendedVacancies as $key => $value) {
                        $orgData = $organisation->getOrganisationData($value['org_id']);

                ?>
                        <div class="result-card">
                            <div class="result-container">
                                <div class="result-image-container">
                                    <img src="<?php echo $orgData['profile_picture'] ?>" width="64" height="64" class="rounded-circle" alt="...">
                                </div>
                                <div class="result-text-container">
                                    <div class="col">
                                        <div class="row">
                                            <h5><?php echo $value['title'] ?></h5>
                                        </div>
                                        <div class="row">
                                            <h8><a style="color: black; text-decoration: none;" href="organisation_profile.php?id=<?php echo $value['org_id']?>" type="submit" name="view"><?php echo $orgData['name'] ?></a></h7>
                                        </div>
                                        <div class="row result-card-date">
                                            <h9><?php echo $value['date_created'] ?></h9>
                                        </div>
                                        <div class="row result-card-description">
                                            <h7><?php echo $value['description'] ?></h7>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                <div class="col">
                                    <a href="mailto:<?php echo str_replace(' ', '', $orgData['name']) ?>@psychnova.com?subject=Job Application" class="btn float-right" target="https://jobs.ie/" rel="noopener noreferrer">Apply</a>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>

            </div>
            <div class="col-3"></div>
        </div>


    </div>
</body>

</html>