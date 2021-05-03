<?php
session_start();

include("../classes/connect.php");
include("../classes/post.php");
include("../classes/user.php");
include("../classes/connections.php");
include("../classes/vacancy.php");
include("../classes/organisation.php");

//if user not logged in redirect to login
if (!isset($_SESSION['userid'])) {
  header("location: login.php");
}

$post = new Post();
$user = new User();
$connection = new connections();
$vacancy = new vacancy();
$organisation = new organisation();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['postcontent'])) {
    $result = $post->sendPost($_SESSION['userid'], $_POST);
  }
}

$postsData = $post->getPostsData();
$userData = $user->getUserData($_SESSION['userid']);
$pendingConnectionsData = $connection->getPendingConnections($_SESSION['userid']);
$numberOfConections = count($pendingConnectionsData);
$recommendedVacancies = $vacancy->getVacancies();

// $numberOfConections = 1;

/*
  echo "<pre>";
  print_r($_SESSION);
  echo "</pre>";
  */

?>

<html lang="en">



<head>
  <?php include("../components/head.php"); ?>
  <title>PsychNova</title>
  <link href="../css/timeline.css" rel="stylesheet">


</head>

<body>
  <?php include("../components/navbar.php"); ?>

  <div class="container">
    <!-- profile -->
    <div class="row">
      <div class="col-2">
        <div class="profile-card">
          <div class="profile-container">
            <div class="profile-image">
              <img src="https://dummyimage.com/100x100/cfcfcf/000000" class="rounded-circle" alt="...">
            </div>
            <div class="profile-name">
              <h6><?php echo $userData['first_name'] . " " . $userData['last_name'] ?></h6>
            </div>
            <div class="profile-profession">
              <h7><?php echo $userData['profession'] ?></h7>
            </div>
            <hr />
          </div>
        </div>


        <div class="connections-card">
          <?php if ($numberOfConections > 1) { ?>
            <h class="connections-title" style="text-align:center"><?php echo $numberOfConections . " connection requests" ?></h>

          <?php } else if ($numberOfConections == 1) { ?>
            <h class="connections-title" style="text-align:center"><?php echo $numberOfConections . " connection request" ?></h>
          <?php
          } else { ?>
            <h class="connections-title" style="text-align:center">Connection requests</h>
          <?php } ?>

          <div class="connections-container">

            <?php
            if ($numberOfConections == 0) { ?>
              <p style="font-size:11px">No requests yet!</p>
              <?php
            } else {
              $noOfConnectionsDisplayed = 0;
              foreach ($pendingConnectionsData as $key => $value) {
                if ($noOfConnectionsDisplayed == 3) break;
                else {
                  $pendingConnectionUserData = $user->getUserData($value['user_inviter']);
                  $noOfConnectionsDisplayed += 1;
                }
              ?>
                <div class="connection-row">
                  <img src="https://dummyimage.com/40x40/cfcfcf/000000" class="rounded-circle" alt="...">
                  <h9><?php echo $pendingConnectionUserData['first_name'] . " " . $pendingConnectionUserData['last_name'] ?></h9><br>
                  <br>
                </div>
            <?php
              }
            }
            ?>
            <a class="btn-small float-center" href="people.php">Explore</a>
            <!-- <button type=" submit" class="btn float-center">More</button> -->
          </div>
        </div>

      </div>

      <div class="col-7">
        <div class="post-card">
          <div class="post-title">
            <h7>What's on your mind?</h7>
          </div>
          <form action="" method="post">
            <div class="form-group">
              <input type="text" name="postcontent" class="form-control" required>
            </div>
            <button type="submit" class="btn float-right">Post</button>
          </form>
        </div>

        <?php

        foreach ($postsData as $key => $value) {

          $postUserData = $user->getUserData($value['user_id']);
        ?>

          <div class="media-card">
            <div class="media">
              <img src="https://dummyimage.com/64x64/cfcfcf/000000" class="mr-3" alt="...">
              <div class="media-body">
                <h5 class="mt-0"><?php echo $postUserData['first_name'] . " " . $postUserData['last_name'] ?></h5>
                <p><?php echo $value['post'] ?></p>
              </div>
            </div>
          </div>

        <?php
        }
        ?>

      </div>
      <div class="col-3">
        <div class="vacancies-card">
          <h class="connections-title" style="text-align:center">Recommended Vacancies</h>
          <hr>
          <?php if (count($recommendedVacancies) == 0) {
            echo "no vacancies to show.";
          } else {
            $numberOfVacanciesDisplayed = 0;
            foreach ($recommendedVacancies as $key => $value) {
              if ($numberOfVacanciesDisplayed == 4) break;
              else {
                $vacancyOrgData = $organisation->getOrganisationData($value['org_id']);
                $numberOfVacanciesDisplayed += 1;
              }

          ?>
              <div class="connection-row">
                <img src=<?php $vacancyOrgData['profile_picture'] ?> class="rounded-circle" alt="...">
                <h9><?php echo $vacancyOrgData['name'] ?></h9><br>
                <h9><?php echo $value['title'] ?></h9><br>
                <h9><?php echo $value['description'] ?></h9><br>
                <h9><?php echo $value['requirements'] ?></h9><br>

                <br>
              </div>
          <?php
            }
          }
          ?>
          <a class="btn-small float-center" href="jobs.php">More</a>
        </div>
      </div>
    </div>

  </div>



</body>

</html>