<?php
    session_start();
    include("./classes/user.php");

    //if user not logged in redirect to login
    if(!isset($_SESSION['userid'])) {
        header("location: login.php");
    }

    $user = new User();
    $userData = $user->getData($_SESSION['userid']);

    if (!$userData) header("location: login.php");

?>

<!-- LEFT COLOURS IN FOR EASIER VIEW of whats going on -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/profile-style.css">
    <script src="https://kit.fontawesome.com/0bb62d8e50.js" crossorigin="anonymous"></script>
    <title>Profile</title>
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="col-md-2"></a>
        <a class="navbar-brand" href="#">PsychNova</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- search bar -->
            <form class="col-md-5 form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search for people, companies, jobs ... " aria-label="Search">
                <button class="btn btn-default" id="search-btn" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <!-- navbar links -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="#Home">Home <span class="sr-only">(current)</span></a></li>
                <li class="nav-item"><a class="nav-link" href="#Organisation">Organisation</a></li>
                <li class="nav-item"><a class="nav-link" href="#Vacancies">Vacancies</a></li>
                <li class="nav-item"><a class="nav-link" href="#Profile">People</a></li>
                <li class="nav-item"><a class="nav-link" href="#Profile">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-3" style="border: 2px solid black">
        <div class="main-page">
            <div class="row" style="border: 2px solid purple">
                <div class="col-sm-9 pr-5" style=" border: 2px solid green">
                    <div class="row card-profile">
                        <div class="col-sm-3" style="border: 2px solid yellow">
                            <img src="../images/jlo.jpg" class="img-circle" />
                            <div class="card-profile-info">
                                <p><?php echo $userData['first_name'] ?></p>
                                <p><?php echo $userData['profession'] ?></p>
                                <p>Connections:</p>
                            </div>
                        </div>
                        <div class="col-sm-9" style="border: 2px solid black">
                            <div class="row h-50 d-flex justify-content-center" style="border: 2px solid red;">
                                <p class="mr-3 mt-5">Sun: Gemini </p>
                                <p class="mr-3 mt-5">Rising: Cancer</p>
                                <p class="mr-3 mt-5">Moon: Taurus</p>
                            </div>
                            <div class="row h-50" style="border: 2px solid black">
                                <div class="card-about text-center px-4">
                                    <h8><strong>About</strong></h8>
                                    <p>sLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class=" card-qualifications">
                        <div class="qualification">
                            <h8 class="size-change" id="margin-add"><strong>University of Limerick</strong></h8><br>
                            <h9>Student</h9><br>
                            <h9>Full-time</h9>
                            <h9>Sept 2017 - Sept 2021</h9>
                            <p>sLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                        </div>
                        <hr>
                        <div class="qualification">
                            <h8 class="size-change"><strong>University of Limerick</strong></h8><br>
                            <h9>Student</h9><br>
                            <h9>Full-time</h9>
                            <h9>Sept 2017 - Sept 2021</h9>
                            <p>sLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 skills">
                </div>
            </div>
            <div class="col-sm-3" style="border: 2px solid red">
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
    </div>
</body>

</html>