<?php
include_once('includes/dbh.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
</head>

<body>
    <?php

    //18
    function getUserPosts($conn)
    {
        $sqlGetUserPosts = "SELECT * FROM posts WHERE post_id='a';";
        $result = mysqli_query($conn, $sqlGetUserPosts);
        $resultCheck = mysqli_num_rows($result);

        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "Get User Posts: " . $row['post'] . "<br>";
            } //fetch all results from db and insert each row of data as an array
        }
        echo "<br>";
    }

    //19
    function getUserProfession($conn)
    {
        $sqlGetUserProfession = "SELECT profession FROM user WHERE first_name='Erona';";
        $result = mysqli_query($conn, $sqlGetUserProfession);
        $resultCheck = mysqli_num_rows($result);

        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "Get User Profession: " . $row['profession'] . "<br>";
                echo "<br>";
            } //fetch all results from db and insert each row of data as an array
        }
        echo "<br>";
    }

    /**Requests */
    //20
    function sendConnectionRequest($conn)
    {
        $sqlSendConnectionReq =
            "INSERT INTO connection(
            connection_id,
            user_inviter,
            user_invited,
            state
        )
        VALUES (
                1234,
                2,
                1,
                'pending'
                );";
        if ($conn->query($sqlSendConnectionReq) === true) {
            echo "connection cancelled";
        } else {
            echo "ERROR: Could not able to execute $sqlSendConnectionReq. " . $conn->error . "<br>";
        }
    }

    function acceptConnectionRequest($conn)
    {
        $sqlAcceptConnectionRequest = "UPDATE connection SET state='accepted' WHERE connection_id=1234";
        if ($conn->query($sqlAcceptConnectionRequest) === true) {
            echo "Connection Accepted";
        } else {
            echo "ERROR: Could not able to execute $sqlAcceptConnectionRequest. " . $conn->error . "<br>";
        }
    }

    //21
    function cancelConnectionRequest($conn)
    {
        $sqlCancelConnectionReq = "DELETE FROM connection WHERE connection_id=1234";

        if ($conn->query($sqlCancelConnectionReq) === true) {
            echo "connection cancelled";
        } else {
            echo "ERROR: Could not able to execute $sqlCancelConnectionReq. " . $conn->error . "<br>";
        }
    }

    //22
    function getNumberofConnections($conn)
    {
        $sqlNumberOfConnections = "SELECT user_inviter, COUNT(*) AS totalConnections FROM connection WHERE state='accepted' AND user_inviter=2";
        $result = mysqli_query($conn, $sqlNumberOfConnections);
        $resultCheck = mysqli_num_rows($result);

        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "Toal connections : " . $row['totalConnections'] . " for user: " . $row['user_inviter'] . "<br>";
            } //fetch all results from db and insert each row of data as an array
        }
    }

    /**DO UNION OF QUALIFICATION AND USER_QUALIFICATION
     *  TO GET USER ID, QUALIFICATION_ID AND DESCRIPTION */
    //23
    function getUserQualifications($conn)
    {
        $sqlGetUserQualifications = "SELECT user_qualification.user_id, user_qualification.qualification_id, qualification.description FROM user_qualification INNER JOIN qualification ON user_qualification.qualification_id=qualification.qualification_id";
        $result = mysqli_query($conn, $sqlGetUserQualifications);
        $resultCheck = mysqli_num_rows($result);

        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "Get User Qualification for user : " . $row['user_id'] . ", their Qualification is : " . $row['description'] . "<br>";
            } //fetch all results from db and insert each row of data as an array
        }
        echo "<br>";
    }

    //24
    function getUserSkills($conn)
    {
        $sqlGetUserSkills = "SELECT user_skills.user_id, skills.skill_id, skills.title FROM user_skills INNER JOIN skills ON user_skills.skill_id=skills.skill_id";
        $result = mysqli_query($conn, $sqlGetUserSkills);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "Get User Skills. User : " . $row['user_id'] . " is skilled in : " . $row['title'] . "<br>";
            } //fetch all results from db and insert each row of data as an array
        }
        echo "<br>";
    }

    //25
    function getUserEmploymentHistory($conn)
    {
        /**inner join by org_id cos there were duplicates with user_id */
        $sqlGetUserEmploymentHistory = "SELECT employment_history.user_id, employment_history.start_date, employment_history.end_date, organisation.name FROM employment_history INNER JOIN organisation ON employment_history.org_id=organisation.org_id";
        $result = mysqli_query($conn, $sqlGetUserEmploymentHistory);
        $resultCheck = mysqli_num_rows($result);

        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "Get User Employment History. User : " . $row['user_id'] . " worked at : " . $row['name'] . " from: " . $row['start_date'] . " -> " . $row['end_date'] . "<br>";
            } //fetch all results from db and insert each row of data as an array
        }
        echo "<br>";
    }

    //26
    function updateBirthInfo($conn)
    {
        $sqlUpdateBirthInfo = "UPDATE user SET date_of_birth='2001-05-30' WHERE user_id=1";

        if ($conn->query($sqlUpdateBirthInfo) === true) {
            echo "DOB updated successfully <br>";
        } else {
            echo "ERROR: Could not able to execute $sqlUpdateBirthInfo. " . $conn->error . "<br>";
        }
    }

    //27
    function updateFirstName($conn)
    {
        $sqlUpdateFirstName = "UPDATE user SET first_name='erona' WHERE user_id=1";

        if ($conn->query($sqlUpdateFirstName) === true) {
            echo "First Name updated successfully <br>";
        } else {
            echo "ERROR: Could not able to execute $sqlUpdateFirstName. " . $conn->error . "<br>";
        }
    }

    //28
    function updateLastName($conn)
    {
        $sqlUpdateLastName = "UPDATE user SET last_name='aliu' WHERE user_id=1";

        if ($conn->query($sqlUpdateLastName) === true) {
            echo "Last Name updated successfully <br>";
        } else {
            echo "ERROR: Could not able to execute $sqlUpdateLastName. " . $conn->error . "<br>";
        }
    }
    //29
    function updateUserBio($conn)
    {
        $sqlUpdateUserBio = "UPDATE user SET description='hardworking palm reader' WHERE user_id=1";

        if ($conn->query($sqlUpdateUserBio) === true) {
            echo "Bio updated successfully <br>";
        } else {
            echo "ERROR: Could not able to execute $sqlUpdateUserBio. " . $conn->error . "<br>";
        }
    }

    //30
    function updateUserProfilePicture($conn)
    {
        $sqlUpdateUserPic = "UPDATE user SET profile_picture='new pic' WHERE user_id=1";

        if ($conn->query($sqlUpdateUserPic) === true) {
            echo "Profile Picture updated successfully <br>";
        } else {
            echo "ERROR: Could not able to execute $sqlUpdateUserPic. " . $conn->error . "<br>";
        }
    }

    //31
    function updateProfession($conn)
    {
        $sqlUpdateProfession = "UPDATE user SET profession='Associate Fortune Teller' WHERE user_id=1";

        if ($conn->query($sqlUpdateProfession) === true) {
            echo "Profession updated successfully <br>";
        } else {
            echo "ERROR: Could not able to execute $sqlUpdateProfession. " . $conn->error . "<br>";
        }
    }

    //32
    function updateUserQualification($conn)
    {
        $sqlUpdateUserQualification = "UPDATE user_qualification SET qualification_id='q_2' WHERE user_id=1";

        if ($conn->query($sqlUpdateUserQualification) === true) {
            echo "Profession updated successfully <br>";
        } else {
            echo "ERROR: Could not able to execute $sqlUpdateUserQualification. " . $conn->error . "<br>";
        }
    }

    //33
    function createUserQualification($conn)
    {
        $sqlcreateUserQualification = "INSERT INTO qualification(
                                                    qualification_id,
                                                    description,
                                                    title,
                                                    institue,
                                                    level
                                                    )
                                        VALUES ('q_3', 'Leading institute of Fortune Telling', 'Fortune Telling', 'Pyschics Incorportated', '6');";

        if ($conn->query($sqlcreateUserQualification) === true) {
            echo "User Qualification added successfully <br>";
        } else {
            echo "ERROR: Could not able to execute $sqlcreateUserQualification. " . $conn->error . "<br>";
        }
    }

    //34
    function deleteUserQualification($conn)
    {
        $sqlDeleteUserQualification = "DELETE FROM user_qualification WHERE u_qualification_id='u_q_1' AND user_id=1";

        if ($conn->query($sqlDeleteUserQualification) === true) {
            echo "Qualification deleted successfully <br>";
        } else {
            echo "ERROR: Could not able to execute $sqlDeleteUserQualification. " . $conn->error . "<br>";
        }
    }

    getUserPosts($conn);
    getUserProfession($conn);
    getUserQualifications($conn);
    getUserSkills($conn);
    getUserEmploymentHistory($conn);
    updateBirthInfo($conn);
    updateFirstName($conn);
    updateLastName($conn);
    updateUserBio($conn);
    updateUserProfilePicture($conn);
    updateProfession($conn);
    updateUserQualification($conn);
    //createUserQualification($conn); //changed from create
    //deleteUserQualification($conn);
    //createNewQualification($conn); //added 

    //sendConnectionRequest($conn);
    getNumberofConnections($conn);
    //cancelConnectionRequest($conn);
    acceptConnectionRequest($conn);
    ?>


</body>

</html>