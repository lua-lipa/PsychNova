<?php
session_start();
include("../classes/connect.php");
include("../classes/organisation.php");
include("../classes/user.php");
include("../classes/userOrganisations.php");

if (!isset($_SESSION['userid'])) {
    header("location: login.php");
}

$user = new User();
$userData = $user->getUserData($_SESSION['userid']);

$org = new organisation();
$userOrganisationsData = $org->getUserOrganisationData($_SESSION['userid']);
$linkedOrgs = $org->getLinkedOrganisations($_SESSION['userid']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = $org->createOrg($_POST, $_SESSION['userid']);
    if ($result != "") {
        //show error
        echo $result;
    } else {
        header("Location: myorganisations.php");
    }
}

?>

<html>

<head>
    <title> PsychNova </title>
    <?php include("../components/head.php"); ?>
    <link href="../css/myOrganisations.css" rel="stylesheet">
    <link href="../css/searchresult.css" rel="stylesheet">
</head>

<body>
    <?php include("../components/navbar.php"); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <h6 class="yourOrgTitle"> Your organisation </h6>
            </div>
            <div class="col-3"></div>
        </div> 
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
            <?php
            if (empty($userOrganisationsData)) {
            ?>
                <button type="button" class="orgBtn btn-block" data-toggle="modal" data-target="#myModal"> Create an organisation </button>
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createOrgModal">Create an organisation</h5>
                            </div>
                            <form action="" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label> Name </label>
                                        <input type="text" name="name" class="form-control" pattern="[A-Za-z]+" title="Must contain only letters" required>
                                    </div>
                                    <div class="form-group">
                                        <label> Date Established </label>
                                        <input type="date" name="dateEstablished" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label> Description </label>
                                        <input type="text" name="description" class="form-control" title="Must contain only letters and be equal to or less than 250 characters." maxLength="250">
                                    </div>
                                    <div class="form-group">
                                        <label> E-mail </label>
                                        <input type="text" name="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Must be in the form psychnova@email.com" required>
                                    </div>
                                    <div class="form-group">
                                        <label> Contact Number </label>
                                        <input type="text" name="contactNo" class="form-control" pattern="[0-9]{10}" title="Must be 10 numbers." required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="modalBtn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="modalBtn btn-default">Create</button>
                                </div>
                        </form>
                        </div>
                    </div>
                </div>
            <?php
            } else {
            ?>
                <div class="result-card">
                    <div class="result-container">
                        <div class="col-3">
                            <img src="https://dummyimage.com/64x64/cfcfcf/000000" class="rounded-circle" alt="...">
                        </div>
                        <div class="col-9">
                            <div class="row">
                                <h6 class="yourOrgname"><?php echo $userOrganisationsData['name']?></h6>
                            </div>
                            <div class="row">
                                <h7 class="yourOrgDesc"><?php echo $userOrganisationsData['description']?></h7>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
            }
            ?>
            </div>
            <div class="col-3"></div>
        </div> 
        <div class="row">
            <HR>
        </div>
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <h6 class="linkedOrgTitle"> Organisations your linked to </h6>
            </div>
            <div class="col-3"></div>
        </div> 
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="org-card">
                    <div class="scrolling-wrapper row flex-row flex-nowrap mt-4 pb-4 pt-2">
                    <?php
                        if (empty($linkedOrgs)) {
                        ?>
                            <h6 class="notLinkedMsg center">You're not linked to any PsychNova organisations. Add some employment history to get linked!</h6>
                    <?php
                        } else {
                            foreach ($linkedOrgs as $key => $value) {
                                $linkedOrgsData = $org->getOrganisationData($value['org_id']);
                        ?>
                                <div class="col-4">
                                    <div class="card card-block card-1">
                                        <div class="profile-image">
                                            <img src="https://dummyimage.com/100x100/cfcfcf/000000" class="rounded-circle" alt="...">
                                        </div>
                                        <div class="profile-name" align="center">
                                            <h6 class="linkedOrgname"><?php echo $linkedOrgsData['name']?></h6>
                                            <button class="myBtn"> View </button>
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
            <div class="col-3"></div>
        </div>
    </div>
</body>

</html>