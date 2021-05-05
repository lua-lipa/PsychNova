<?php
session_start();
include("../classes/connect.php");
include("../classes/user.php");
include("../classes/skills.php");
include("../classes/search.php");

//if user not logged in redirect to login
if (!isset($_SESSION['userid'])) {
    header("location: login.php");
}

$skill = new Skill();
$skillsData = $skill->getAllSkills();

/*
//if user logged in redirect to timeline
if (isset($_SESSION['userid'])) {
    header("location: timeline.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $SignUp = new SignUp();
    $result = $SignUp->createUser($_POST);

    if ($result != "") {
        //show error
        echo $result;
    } else {
        header("Location: timeline.php");
    }
}
*/

$searchResults = null;
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $search = new Search();
    $searchResults = $search->searchOrganisations($_GET);
}




?>

<!DOCTYPE html>
<html>

<head>
    <title> PsychNova </title>
    <?php include("../components/head.php"); ?>
    <link href="../css/searchresult.css" rel="stylesheet">
</head>

<body>
    <?php
    include("../components/navbar.php");
    ?>
    <div class="container">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-lg-6">

        

                <?php

                if (empty($searchResults)) {
                    echo "no search results";
                } else {



                    foreach ($searchResults as $key => $value) {

                ?>
                        <div class="result-card">
                            <div class="result-container">
                                <div class="col-2 ">
                                    <div class="row profile-img">
                                        <img style="height:64px; width:64px;" src="<?php echo $value['profile_picture'] ?>" class="rounded-circle" alt="...">
                                    </div>
                                    
                                </div>
                                <div class="col-9">
                                    <div class="row">
                                        <h6 class="mt-0"><a style="color: #A58AAE" href="organisation_profile.php?id=<?php echo $value['org_id'] ?>" type="submit" name="view"><?php echo $value['name'] ?></a></h6>
                                    </div>
                                    <div class="row">
                                        <h7><?php echo $value['description'] ?></h7>
                                    </div>
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