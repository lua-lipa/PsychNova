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

if (isset($_GET['skill']) || isset($_GET['companyinput'])) {
    $search = new Search();
    $_SESSION['searchresults'] = $search->searchUsers($_SESSION['searchinput']);
    //search user based
}


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
            <div class="col-3"></div>
            <div class="col-lg-6">

                <!-- filters -->
                <div class="filters-wrapper">
                    <form action="" method="GET" class="form-inline">
                        <div class="form-group">
                            <select class="form-control skill-form" onchange='this.form.submit()' name="skill">
                                <option value="" selected disabled hidden>Skill</option>
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

                    <form action="" method="GET" class="form-inline">
                        <input class="form-control mr-sm-2" type="search" placeholder="Companies worked for" name="companyinput">
                    </form>
                </div>


                <?php

                if (empty($_SESSION["searchresults"])) {
                    echo "no search results for " . $_SESSION['searchinput'];
                } else {



                    foreach ($_SESSION["searchresults"] as $key => $value) {


                ?>
                        <div class="result-card">
                            <div class="result-container">
                                <div class="col-3">
                                    <img src="https://dummyimage.com/64x64/cfcfcf/000000" class="rounded-circle" alt="...">
                                </div>
                                <div class="col-9">
                                    <div class="row">
                                        <h6><?php echo $value['first_name'] . " " . $value['last_name'] ?></h6>
                                    </div>
                                    <div class="row">
                                        <h7><?php echo $value['profession'] ?></h7>
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