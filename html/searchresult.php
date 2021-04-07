<?php
session_start();
include("../classes/connect.php");
include("../classes/user.php");


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
        unset($_SESSION['searchinput']);
    ?>
    <div class="container">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <?php

                if (empty($_SESSION["searchresults"])) {
                    echo "no search results";
                } else {



                    foreach ($_SESSION["searchresults"] as $key => $value) {


                ?>
                        <div class="result-card">
                            <div class="result-container">
                                <?php
                                if ($_SESSION["dropdowninput"] == "Users") {
                                ?>
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

                                <?php
                                } else if ($_SESSION["dropdowninput"] == "Organisations") {
                                ?>
                                    <div class="col-3">
                                        <img src="https://dummyimage.com/64x64/cfcfcf/000000" class="rounded-circle" alt="...">
                                    </div>
                                    <div class="col-9">
                                        <div class="row">
                                            <h6><?php echo $value['name'] ?></h6>
                                        </div>
                                        <div class="row">
                                            <h7><?php echo $value['description'] ?></h7>
                                        </div>
                                    </div>
                            </div>
                        <?php
                                }
                        ?>
                <?php
                    }
                }
                ?>
                        </div>
            </div>
            <div class="col-2"></div>
        </div>


    </div>
</body>

</html>