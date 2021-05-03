<?php

/*
//if user logged in redirect to timeline
if (isset($_SESSION['userid'])) {
    header("location: timeline.php");
}
*/


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['searchinput'])) {

        $_SESSION['dropdowninput'] = $_POST['dropdowninput'];

        if ($_POST['dropdowninput'] == 'Users') {
            header("location: usersearch.php?name=" . $_POST['searchinput']);
        } else if ($_POST['dropdowninput'] == 'Organisations') {
            header("location: usersearch.php");
        }
    }
}

?>

<style>
    /* Set black background color, white text and some padding */


    .search-input .form-control {
        width: 300px !important;
        border-radius: 50px !important;
    }

    .navbar-wrapper {
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.075);
        border-radius: 0px 0px 10px 10px;
    }

    .navbar-brand {
        color: #A58AAE !important;
    }
</style>

<div class="nav-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4">
        <div class="container">
            <a class="navbar-brand" href="timeline.php">PsychNova</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <div class="search-box ml-auto mr-auto mt-2 mt-lg-0 d-flex">

                    <form action="" method="post" class="form-inline">
                        <div class="search-input">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" name="searchinput" value=<?php
                                                                                                                            if (isset($_SESSION['searchinput'])) {
                                                                                                                                echo $_SESSION['searchinput'];
                                                                                                                            }
                                                                                                                            ?>>
                        </div>
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" name="dropdown" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php
                                if (isset($_SESSION['dropdowninput'])) {
                                    echo $_SESSION['dropdowninput'];
                                } else {
                                    echo "Users";
                                }
                                ?>
                            </button>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <a class="dropdown-item" href="#">Users</a>
                                    <a class="dropdown-item" href="#">Organisations</a>
                                </li>

                            </div>
                            <script type="text/javascript">
                                $(".dropdown-menu").on('click', 'li a', function() {
                                    $(".btn:first-child").text($(this).text());
                                    $(".btn:first-child").val($(this).text());
                                    $("#dropdowninput").val($(this).text());

                                });
                            </script>
                        </div>

                        <input type="hidden" id="dropdowninput" name="dropdowninput" value=<?php
                                                                                            if (isset($_SESSION['dropdowninput'])) {
                                                                                                echo $_SESSION['dropdowninput'];
                                                                                            } else {
                                                                                                echo "Users";
                                                                                            }
                                                                                            ?>>

                    </form>
                </div>
                <ul class="navbar-nav my-2 my-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="people.php">People</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="jobs.php">Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="myorganisations.php">My Organisations</a>
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