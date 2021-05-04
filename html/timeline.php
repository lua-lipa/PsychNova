<?php
session_start();

include("../classes/connect.php");
include("../classes/post.php");
include("../classes/user.php");
include("../classes/connections.php");
include("../classes/vacancy.php");
include("../classes/star_sign.php");
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

if (isset($_POST['connectWithUser'])) {
  $connection->sendConnectionRequest($_SESSION['userid'], $_POST['connectWithUser']);
}

if (isset($_POST['deletePost'])) {
  $post->deletePost($_POST['deletePost']);
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
<!DOCTYPE html>
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
      <div class="col-lg-2">
        <div class="profile-card">
          <div class="profile-container">
            <div class="profile-image">
              <img src="<?php echo $userData['profile_picture'] ?>" href="profile.php?id=<?php echo $userData['user_id'] ?>" class=" rounded-circle" width="70" height="70" alt="...">
            </div>
            <br>
            <div class="profile-name">
              <h5 class="mt-0"><a style="color: white; text-decoration: none; font-size: 15px" href="profile.php?id=<?php echo $userData['user_id'] ?>" type="submit" name="view"><?php echo $userData['first_name'] . " " . $userData['last_name'] ?></a></h5>
            </div>
            <div class="profile-profession">
              <h7 style="font-size: 13px"><i><?php echo $userData['profession'] ?></i></h7>
            </div>
            <hr>
            <div class="star-signs">
              <p class="mr-3" style="color: white; font-size: 14px;"><i class="bi bi-sun" style="color:white"></i> <?php echo calcStarSign($userData['date_of_birth']) ?> </p>
              <p class="mr-3" style="color: white; font-size: 14px;"><i class="bi bi-sunrise" style="color:white"></i> Cancer</p>
              <p class="mr-3" style="color: white; font-size: 14px;"><i class="bi bi-moon" style="color:white"></i> Taurus</p>
            </div>
            <hr />
          </div>
        </div>


        <div class="connections-card">
          <?php if ($numberOfConections > 1) { ?>
            <h class="connections-title" style="text-align:center"><b><?php echo $numberOfConections . " connection requests" ?></b></h>

          <?php } else if ($numberOfConections == 1) { ?>
            <h class="connections-title" style="text-align:center"><b><?php echo $numberOfConections . " connection request" ?></b></h>
          <?php
          } else { ?>
            <h class="connections-title" style="text-align:center"><b>Connection requests</b></h>
          <?php } ?>

          <div class="connections-container">

            <?php
            if ($numberOfConections == 0) { ?>
              <br>
              <p style="text-align:center">No requests yet!</p><br>
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
                  <img src="<?php echo $pendingConnectionUserData['profile_picture'] ?>" class="rounded-circle" width="30" height="30" alt="...">
                  <h9 class="mt-0"><a style="color: black; text-decoration: none;" href="userprofile.php?id=<?php echo $pendingConnectionUserData['user_id'] ?>" type="submit" name="view"><?php echo $pendingConnectionUserData['first_name'] . " " . $pendingConnectionUserData['last_name'] ?></a></h9><br>

                  <br>
                </div>
            <?php
              }
            }
            ?>
            <a class="btn-view-more float-center" href="people.php">Explore</a>
            <!-- <button type=" submit" class="btn float-center">More</button> -->
          </div>
        </div>

      </div>

      <div class="col-lg-7">
        <div class="post-card">
          <div class="post-title">
            <h7>What's on your mind?</h7>
          </div>
          <form action="" method="post">
            <div class="form-group">
              <input type="text" name="postcontent" class="form-control" required>
            </div>
            <button type="submit" class="btn-search float-right">Post</button>
          </form>
        </div>

        <?php

        foreach ($postsData as $key => $value) {

          $postUserData = $user->getUserData($value['user_id']);
        ?>

          <div class="media-card">
            <div class="media">
              <img src="<?php echo $postUserData['profile_picture'] ?>" width="64" height="64" class="mr-3" alt="...">
              <div class="media-body">
                <div class="post-user-title">
                  <h5 class="mt-0"><a style="color: #A58AAE; text-decoration: none;" href="userprofile.php?id=<?php echo $postUserData['user_id'] ?>" type="submit" name="view"><?php echo $postUserData['first_name'] . " " . $postUserData['last_name'] ?></a></h5>
                  <!-- if the users are not connected, the connect button gets displayed -->
                  <?php if (count($connection->areConnected($postUserData['user_id'], $_SESSION['userid'])) == 0 && $postUserData['user_id'] != $_SESSION['userid']) { ?>
                    <form action="" method="POST">
                      <button class="connect-btn" type="submit" name="connectWithUser" value=<?php echo $postUserData['user_id'] ?>>+</button>
                    </form>
                  <?php }
                  if ($userData['type'] == 'administrator' or $postUserData['user_id'] == $userData['user_id']) { ?>
                    <form action="" method="POST">
                      <button class="connect-btn" type="submit" name="deletePost" value=<?php echo $value['post_id'] ?>>delete post</button>
                    </form>
                  <?php
                  }
                  ?>
                </div>

                <p style="font-size: 13px;"><?php echo $value['post'] ?></p>
              </div>
            </div>
          </div>

        <?php
        }
        ?>

      </div>
      <div class="col-lg-3">
        <div class="vacancies-card">
          <h class="connections-title" style="text-align:center; font-size: 12px"><b>Recommended Vacancies</b></h>
          <br>
          <?php if (count($recommendedVacancies) == 0) { ?>
            <p style="text-align:center">No vacancies to show</p><br>
            <?php
          } else {
            $numberOfVacanciesDisplayed = 0;
            foreach ($recommendedVacancies as $key => $value) {
              if ($numberOfVacanciesDisplayed == 3) break;
              else {
                $vacancyOrgData = $organisation->getOrganisationData($value['org_id']);
                $numberOfVacanciesDisplayed += 1;
              }

            ?>
              <div class="connection-row">
                <div class="vacancy-header">
                  <img src="<?php echo $vacancyOrgData['profile_picture'] ?>" width="60" height="60" class=" rounded-circle" alt="...">
                  <div class="vacancy-title">
                    <h9><a style="color: #A58AAE; text-decoration: none;" href="organisation_profile.php?id=<?php echo $vacancyOrgData['org_id'] ?>" type="submit" name="view"><?php echo $vacancyOrgData['name'] ?></a></h9><br>
                    <h9><?php echo $value['title'] ?></h9>
                    <a href="mailto:<?php echo str_replace(' ', '', $vacancyOrgData['name']) ?>@psychnova.com?subject=Job Application" class="btn-small float-center" target="https://jobs.ie/" rel="noopener noreferrer">Apply</a>

                  </div>

                </div>
                <h style="font-size:12px"><i><?php echo $value['description'] ?></i></h><br>
                <hr>
              </div>
              <!-- <a class="btn-small float-center" style="margin-top:5px" href="jobs.php">Apply</a> -->

          <?php
            }
          }
          ?>
          <a class="btn-view-more float-center" href="jobs.php">Explore</a>
        </div>
      </div>
    </div>

  </div>



</body>

</html>