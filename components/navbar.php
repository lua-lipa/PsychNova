<?php
include("./classes/search.php");

/*
//if user logged in redirect to timeline
if (isset($_SESSION['userid'])) {
    header("location: timeline.php");
}
*/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['searchinput'])) {
        $search = new Search();
        $_SESSION['searchresults'] = $search->searchUser($_POST);

        if ($_SESSION['searchresults']) {
            header("location: searchresult.php");
        }
    }
}

?>

<style>
    /* Set black background color, white text and some padding */
    .form-inline .form-control {
        width: 300px;
        border-radius: 50px;
    }
</style>

<div class="nav-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">PsychNova</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <div class="search-box ml-auto mr-auto mt-2 mt-lg-0 d-flex">

                    <form action="" method="post" class="form-inline">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" name="searchinput">
                    </form>
                </div>
                <ul class="navbar-nav my-2 my-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="timeline.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
</div>


</body>

</html>