<?php
session_start();

  include("./classes/connect.php");
  include("./classes/post.php");
  include("./classes/user.php");

  //if user not logged in redirect to login
  if(!isset($_SESSION['userid'])) {
    header("location: login.php");
  }

  $post = new Post();
  $user = new User();

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = $post->sendPost($_SESSION['userid'], $_POST);
  }

  $postsData = $post->getData();
  $userData = $user->getData($_SESSION['userid']);
   
  echo "<pre>";
  print_r($postsData);
  echo "</pre>";

  /*
  echo "<pre>";
  print_r($_SESSION);
  echo "</pre>";
  */

?>

<html lang="en">
<head>
  <title>PsychNova</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="./css/style.css" rel = "stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  <style>    


    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
  </style>
</head>
<body>

    

<nav class="navbar navbar-default">
  <div class="container-fluid">
      <!-- NAVIGATION BAR -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">PsychNova</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
        <!-- SEARCH BAR -->
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group input-group">
          <input type="text" class="form-control" placeholder="Search for people, companies ..">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">
              <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>        
        </div>
      </form>
      <ul class="nav navbar-nav navbar-right">
          <!-- NAVIGATION LINKS -->
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">Organisations</a></li>
        <li><a href="#">People</a></li>
        <li class="active"><a href="./login.php">Logout</a></li>
      </ul>
      
      
    </div>
  </div>
</nav>
<!-- PROFILE SECTION -->
<div class="container text-center">    
  <div class="row">
    <div class="col-sm-3 well">
      <div class="well">
        
        <img src="/assets/hermione.png" class="img-circle" height="65" width="65" alt="Avatar">
        <h3><?php echo $userData['first_name'] . " " . $userData['last_name'] ?></h3>
        <p><?php echo $userData['profession'] ?></p>
      </div>
      <div class="well">
        <p><a href="#">Signs</a></p>
        <p>
          <p>Libra (libra_icon)</p>
          <p>Cancer (cancer_icon)</p>
          <p>Saggitarius (sag_icon)</p>
        </p>
      </div>
      <div class="alert alert-success fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <p><strong>Hey!</strong></p>
        People are sending you connection requests!.
      </div>
      <p><a href="#">Name LastName</a></p>
      <p><a href="#">Name LastName</a></p>
      <p><a href="#">Name LastName</a></p>
    </div>
    <div class="col-sm-7">
    
    <!-- MAKE POST -->
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-default text-left">
            <div class="panel-body">
                
              <p>How are you feeling today?</p>
              <form action="" method="post">
                <textarea id="textbox" name="postcontent"></textarea>
                <br><br>
                <input type="submit" value="Post" button type="button" class="btn btn-default btn-sm" style="float:right"> 
                    <span class="glyphicon glyphicon-send" style = "float:right"></span> </input> 
              </form>
              <!-- <button type="button" class="btn btn-default btn-sm" style="float:right" input type="submit"> -->
                <!-- <span class="glyphicon glyphicon-send"></span> Post -->
              </button>     
            </div>
          </div>
        </div>
      </div>
      <!-- POSTS -->

    <?php 
      foreach ($postsData as $key => $value) {
        $postUserData = $user->getData($value['user_id']);
        ?>
        <div class="row">
        <div class="col-sm-3">
          <div class="well">
           <p><?php echo $postUserData['first_name'] . " " . $postUserData['last_name'] ?></p>
           <img src="/assets/profilePic.jpg" class="img-circle" height="55" width="55" alt="Avatar">
          </div>
        </div>
        <div class="col-sm-9">
          <div class="well">
            <p><?php echo $value['post'] ?></p>
          </div>
        </div>
      </div>
      <?php
      }
    ?>
      <div class="row">
        <div class="col-sm-3">
          <div class="well">
           <p>Bo</p>
           <img src="/assets/profilePic.jpg" class="img-circle" height="55" width="55" alt="Avatar">
          </div>
        </div>
        <div class="col-sm-9">
          <div class="well">
            <p>Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3">
          <div class="well">
           <p>Jane</p>
           <img src="/assets/profilePic.jpg" class="img-circle" height="55" width="55" alt="Avatar">
          </div>
        </div>
        <div class="col-sm-9">
          <div class="well">
            <p>Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3">
          <div class="well">
           <p>Anja</p>
           <img src="/assets/profilePic.jpg" class="img-circle" height="55" width="55" alt="Avatar">
          </div>
        </div>
        <div class="col-sm-9">
          <div class="well">
            <p>Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.</p>
          </div>
        </div>
      </div>     
    </div>
    <!-- RIGHT SIDEBAR: VACANCIES -->
    <div class="col-sm-2 well">
      <div class="thumbnail">
        <p>Vacancies:</p>
        <img src="/assets/jobPic.png" alt="WitchAcademy" width="55" height="55">
        <p><strong>Witch Academy</strong></p>
        <p>Looking for a witch</p>
        <button class="btn btn-primary">Apply</button>
      </div>      
      
    </div>
  </div>
</div>



</body>
</html>
