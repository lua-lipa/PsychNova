<?php
include("./classes/search.php");

/*
//if user logged in redirect to timeline
if (isset($_SESSION['userid'])) {
    header("location: timeline.php");
}
*/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search = new Search();
    $_SESSION['searchresults'] = $search->searchUser($_POST);
    
    if ($_SESSION['searchresults']) {
        header("location: searchresult.php");
    }
}

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
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
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Select
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </li>
                    </div>
                </div>
                <script type="text/javascript">
                    $(function() {

                        $(".dropdown-menu li a").click(function() {

                            $(".btn:first-child").text($(this).text());
                            $(".btn:first-child").val($(this).text());

                        });

                    });
                </script>
            </div>
            <ul class="navbar-nav my-2 my-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>

        </div>
</nav>
</div>