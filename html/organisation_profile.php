<?php
session_start();
include("../classes/connect.php");
include("../classes/user.php");
include("../classes/organisation.php");
include("../classes/star_sign.php");

if (!isset($_SESSION['userid'])) {
    header("location: myorganisations.php");
}

$organisation = new organisation();
$organisationData = $organisation->getOrganisationData($_SESSION['userid']);

$user = new User();
$userData = $user->getUserData($_SESSION['userid']);

?>

<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/organisations-profile.css">
    <script src="https://kit.fontawesome.com/0bb62d8e50.js" crossorigin="anonymous"></script>
    <title>Profile</title>
</head>

<!-- navbar -->
<?php include("../components/navbar.php"); ?>

<div class="container mt-3">
    <div class="main-page">
        <div class="row">
            <div class="col-sm-9 pr-5">
                <!--  style=" border: 2px solid green" -->
                <div class="row card-profile">
                    <div class="col-sm-3">
                        <img src="../images/background-stars.jpg" class="img-circle" />
                        <div class="card-profile-info">
                            <p><?php echo $organisationData['name'] ?></p>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="row h-45 d-flex justify-content-center">
                            <p class="mr-3 mt-5">Sun: <?php echo calcStarSign($organisationData['date_established']) ?></p>
                            <p class="mr-3 mt-5">Rising: Cancer</p>
                            <p class="mr-3 mt-5">Moon: Taurus</p>
                        </div>
                        <div class="row h-20 d-flex justify-content-center ">
                            <p>Owner: <?php echo $userData['first_name'] . " " . $userData['last_name'] ?> </p>
                        </div>

                        <div class=" row h-50">
                            <div class="card-about text-center px-4">
                                <h8><strong>About</strong></h8>
                                <p><?php echo $organisationData['description'] ?></p>
                            </div>
                        </div>
                    </div>
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