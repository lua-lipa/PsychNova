<?php

session_start();
include("../classes/connect.php");
include("../classes/connections.php");
include("../classes/user.php");

if (!isset($_SESSION['userid'])) {
    header("location: login.php");
}

$connection = new connections();
if (isset($_POST['acceptConnection'])) {
    $connection->acceptPendingConnection($_POST['acceptConnection']);
}

if (isset($_POST['rejectConnection'])) {
    $connection->rejectPendingConnection($_POST['rejectConnection']);
}

$user = new User();
$userData = $user->getUserData($_SESSION['userid']);

$connections = new connections();
$connectionsData = $connections->getPendingConnections($_SESSION['userid']);
$connectionsNumber = count($connectionsData);
$connectedUsersData = $connections->getUserConnections($_SESSION['userid']);
?>

<html>

<head>
    <title> PsychNova </title>
    <?php include("../components/head.php"); ?>
    <link href="../css/pending-connections.css" rel="stylesheet">
</head>

<body>


    <?php
    include("../components/navbar.php");
    ?>

    <div class="row">
        <HR>
    </div>
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-lg-6">
            <h6 class="linkedOrgTitle"> Connected Users </h6>
        </div>
        <div class="col-sm-3"></div>
    </div>
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-lg-6">
            <div class="org-card">
                <div class="scrolling-wrapper row flex-row flex-nowrap mt-4 pb-4 pt-2">
                    <?php
                    if (empty($connectedUsersData)) {
                    ?>
                        <h6 class="notLinkedMsg center">You don't have any connections yet! Connect with people to get started.</h6>
                        <?php
                    } else {
                        foreach ($connectedUsersData as $key => $value) {
                            $connectedUser = $user->getUserData($value['user_inviter']);
                        ?>
                            <div class="col-lg-4">
                                <div class="card card-block card-1">
                                    <div class="profile-image">
                                        <img src="<?php echo $connectedUser['profile_picture'] ?>" class="rounded-circle" alt="..." width="100" height="100">
                                    </div>
                                    <div class="profile-name" align="center">
                                        <h6 class="linkedOrgname"><?php echo $connectedUser['first_name'] . " " . $connectedUser['last_name'] ?></h6>
                                        <a style="color: #A58AAE; text-decoration: none;" href="profile.php?id=<?php echo $connectedUser['user_id'] ?>" type="submit" name="view" class="myBtn"> View </a>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-3"></div>
    </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <?php
                echo "you have " . $connectionsNumber . " pending connections"; ?>
                <br><br>
                <?php
                if ($connectionsNumber == 0) {
                    echo "no connections"; // . $_SESSION['searchinput'] ;
                } else {
                    foreach ($connectionsData as $key => $value) {
                        $pendingConnectionUserData = $user->getUserData($value['user_inviter']);
                ?>
                        <div class="row">
                            <div class="result-card">
                                <div class="result-container">
                                    <div class="col-3">
                                        <img src="https://dummyimage.com/64x64/cfcfcf/000000" class="rounded-circle" alt="...">
                                    </div>
                                    <div class="col-6">
                                        <h6><?php echo $pendingConnectionUserData['first_name'] . " " . $pendingConnectionUserData['last_name'] ?></h6>
                                    </div>
                                    <div class="col-3">
                                        <form action="" method="POST">
                                            <button class="btn-small" type="submit" name="acceptConnection" value=<?php echo $value['connection_id'] ?>>Accept</button>
                                            <button class="btn-small" type="submit" name="rejectConnection" value=<?php echo $value['connection_id'] ?>>Reject</button>
                                        </form>
                                    </div>
                                </div>
                                <br><br>
                        <?php
                    }
                }
                        ?>
                            </div>
                        </div>
                        <div class="col-2"></div>
            </div>

        </div>
    </div>


</body>

</html>