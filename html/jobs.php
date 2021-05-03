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
    <link href="../css/searchresult.css" rel="stylesheet">
</head>

<body>
    <?php
    include("../components/navbar.php");
    ?>
    <div class="container">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-lg-9">

                <!-- filters -->
                <div class="filters-wrapper">
                    <form action="" method="GET" class="form-inline">
                        <div class="form-group">
                            <input class="form-control mr-sm-2" name="title" type="search" value="<?php if(isset($_GET['title'])) echo $_GET['title']; ?>"  placeholder="Job Title" >
                            <input class="form-control mr-sm-2" name="companyName" type="search" value="<?php if(isset($_GET['companyName'])) echo $_GET['companyName']; ?>"  placeholder="Company Name" >
                            <input class="form-control mr-sm-2" name="dateCreated" type="date" value="<?php if(isset($_GET['dateCreated'])) echo $_GET['dateCreated']; ?>"  placeholder="Date Created" >
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
                                <div class="col-3">
                                    <img src="https://dummyimage.com/64x64/cfcfcf/000000" class="rounded-circle" alt="...">
                                </div>
                                <div class="col-9">
                                    <div class="row">
                                        <h6><?php echo $value['title'] ?></h6>
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