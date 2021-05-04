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


$searchResults = null;
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $search = new Search();
    $searchResults = $search->searchVacancy($_GET);
}

// echo "<pre>";
// print_r($searchResults);
// echo "</pre>";


?>

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
            <h2>Search for your Dream Job</h2>
        </div>
        <div class="row main-column">
            <div class="col-lg-12">

                <!-- filters -->
                <div class="filters-wrapper">
                    <form action="" method="GET" class="form-inline">
                        <div class="form-group">
                            <input class="form-control mr-sm-2" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" name="title" onsubmit='this.form.submit()' type="search" value="<?php if (isset($_GET['title'])) echo $_GET['title']; ?>" placeholder="Job Title">
                        </div>
                        <div class="form-group">
                            <input class="form-control mr-sm-2" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" name="companyName" onsubmit='this.form.submit()' type="search" value="<?php if (isset($_GET['title'])) echo $_GET['companyName']; ?>" placeholder="Organisation Name">
                        </div>
                        <div class="form-group">
                            <input class="form-control mr-sm-2" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }" name="dateCreated" type="date" value="<?php if (isset($_GET['dateCreated'])) echo $_GET['dateCreated']; ?>" placeholder="Company Name">
                        </div>
                        <div class="form-group">
                            <select class="form-control skill-form" onchange='this.form.submit()' name="skill">
                                <option value="" selected disabled hidden>Required Skill</option>
                                <?php foreach ($skillsData as $key => $value) {
                                    if ($key == $_GET['skill']) {
                                ?>
                                        <option selected value="<?php echo $key ?>"><?php echo $value['title'] ?></option>
                                    <?php
                                    } else {
                                    ?>
                                        <option value="<?php echo $key ?>"><?php echo $value['title'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                            <noscript><input type="submit" value="Submit"></noscript>
                        </div>




                    </form>
                </div>


                <?php

                if (empty($searchResults)) {
                    echo "no search results";
                } else {



                    foreach ($searchResults as $key => $value) {


                ?>
                        <div class="result-card">
                            <div class="result-container">
                                <div class="result-image-container">
                                    <img src="<?php echo $value['profile_picture'] ?>" width="64" height="64" class="rounded-circle" alt="...">
                                </div>
                                <div class="result-text-container">
                                    <div class="col">
                                        <div class="row">
                                            <h5><?php echo $value['title'] ?></h5>
                                        </div>
                                        <div class="row">
                                            <h8><a style="text-decoration: none;" href="organisation_profile.php?id=<?php echo $value['org_id']?>" type="submit" name="view"><?php echo $value['name'] ?></a></h7>
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
                                        <button type="submit" class="btn float-right">Apply</button>
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