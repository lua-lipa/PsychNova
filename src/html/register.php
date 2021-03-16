<html>
<head>
    <title> PsychNova register </title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<div class="container">
    <h1> PsychNova </h1>
    <h2 class="slogan"> Begin or expand your career with PsychNova today. </h2>
    <div class="login-registration-box">
        <div class="row">
            <div class="col-md-6 registration-box">
                <h2> Register </h2>
                <form action="registration.php" method="post">
                    <div class="form-group">
                        <label> email </label>
                        <input type="text" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label> password </label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label> First name </label>
                        <input type="text" name="firstName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label> Last name </label>
                        <input type="text" name="lastName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label> Profession </label>
                        <input type="text" name="profession" class="form-control">
                    </div>
                    <div class="form-group">
                        <label> Date of birth </label>
                        <input type="date" name="dateOfBirth" class="form-control">
                    </div>
                    <div class="form-group">
                        <label> Time of birth </label>
                        <input type="time" name="timeOfBirth" class="form-control">
                    </div>
                    <div class="form-group">
                        <label> Place of birth </label>
                        <input type="text" name="placeOfBirth" class="form-control">
                    </div>
                    <button type="submit" class="btn"> Register </button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>