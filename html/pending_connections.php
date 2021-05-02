<?php

session_start();
include("../classes/connect.php");
include("../classes/connections.php");
include("../classes/user.php");

if (!isset($_SESSION['userid'])) {
    header("location: login.php");
}

$user = new User();
$userData = $user->getUserData($_SESSION['userid']);

$connections = new connections();
$connectionsData = $connections->getPendingConnections($_SESSION['userid']);
$connectionsNumber = count($connectionsData);

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
                                        <div class="row">
                                            <a class="btn-small float-center" href="pending_connections.php" onclick="<?php $connections->acceptPendingConnection($connectionsData['connection_id']) ?>">Accept</a>
                                        </div>
                                        <div class="row">
                                            <a class="btn-small float-center" href="pending_connections.php">Reject</a>

                                        </div>
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