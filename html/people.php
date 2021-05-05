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

<!DOCTYPE html>
<html>

<head>
    <?php include("../components/head.php"); ?>
    <link href="../css/pending-connections.css" rel="stylesheet">
</head>

<body>


    <?php
    include("../components/navbar.php");
    ?>
  <div class="container-fluid">
    <div class="row">
        <HR>
    </div>
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-lg-6">
            <h6 class="connectionsTitle">Connections</h6>
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
                            $inviter_id = $value['user_inviter'];
                            $invited_id = $value['user_invited'];
                            if ($inviter_id == $_SESSION['userid']) {
                                $inviter_id = $invited_id;
                            }
                            $connectedUser = $user->getUserData($inviter_id);

                        ?>
                            <div class="col-lg-4">
                                <div class="card card-block card-1">
                                    <div class="profile-image">
                                        <img src="<?php echo $connectedUser['profile_picture'] ?>" class="rounded-circle" alt="..." width="100" height="100">
                                    </div>
                                    <div class="profile-name" align="center">
                                        <h6 class="linkedOrgname"><?php echo $connectedUser['first_name'] . " " . $connectedUser['last_name'] ?></h6>
                                        <a style="color: #A58AAE; text-decoration: none;" href="profile.php?userid=<?php echo $connectedUser['user_id'] ?>" type="submit" name="view" class="myBtn"> View </a>
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
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-lg-6">
            <h6 class="linkedOrgTitle">Pending Connections</h6>
        </div>
        <div class="col-sm-3"></div>
    </div>
    <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-lg-6">
                <?php
                if ($connectionsNumber == 0) {
                    echo "You don't have any pending connections."; // . $_SESSION['searchinput'] ;
                } else {
                    foreach ($connectionsData as $key => $value) {

                        $pendingConnectionUserData = $user->getUserData($value['user_inviter']);
                ?>
                    <div class="result-card">
                        <div class="result-container">
                            <div class="col-2">
                                <img src="<?php echo $pendingConnectionUserData['profile_picture'] ?>" class="rounded-circle" alt="..." width="64" height="64">
                            </div>
                            <div class="col-6 result-card-content">
                                <h6 class="yourOrgname"><a style="color: #A58AAE; text-decoration: none;" class="yourOrgname" href="profile.php?userid=<?php echo $pendingConnectionUserData['user_id'] ?>" type="submit" name="view"> <?php echo $pendingConnectionUserData['first_name'] .  " " . $pendingConnectionUserData['last_name'] ?></a></h6>
                            </div>
                            <div class="col-4">
                                <form action="" method="POST">
                                    <button class="btn-small" type="submit" name="acceptConnection" value=<?php echo $value['connection_id'] ?>>Accept</button>
                                    <button class="btn-small-empty" type="submit" name="rejectConnection" value=<?php echo $value['connection_id'] ?>>Reject</button>
                                </form>
                            </div>
                        </div>
                    </div>

                <?php
                    }
                }
                ?>
            </div>
        <div class="col-sm-3"></div>
    </div>
</div>

</body>

</html>