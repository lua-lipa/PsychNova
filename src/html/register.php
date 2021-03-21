<html>
<head>
    <title> PsychNova register </title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/login_and_registration.css">
</head>
<body>
<div class="container">
    <div class="login-registration-box">
        <div class="row">
            <div class="col-md-6 logo-box">
                <h1> PsychNova </h1>
                <h2 class="slogan"> Begin or expand your career with PsychNova today. </h2>
            </div>
            <div class="col-md-6 registration-box">
                <form action="registration.php" method="post">
                    <div class="form-group">
                        <label> email </label>
                        <input type="text" placeholder="e.g., joe.bloggs@example.com" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label> password </label>
                        <input type="password" placeholder="e.g., ********" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label> First name </label>
                        <input type="text" placeholder="e.g., Joe" name="firstName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label> Last name </label>
                        <input type="text" placeholder="e.g., Bloggs" name="lastName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label> Profession </label>
                        <input type="text" placeholder="e.g., Astrologist" name="profession" class="form-control">
                    </div>
                    <div class="form-group">
                        <label> Date of birth </label>
                        <input type="date" placeholder="e.g., yyyy/mm/dd" name="dateOfBirth" class="form-control">
                    </div>
                    <div class="form-group">
                        <label> Time of birth </label>
                        <input type="time" placeholder="e.g., HHMM" name="timeOfBirth" class="form-control">
                    </div>
                    <div class="form-group">
                        <label> Place of birth </label>
                        <input type="text" placeholder="e.g., City, Country" name="placeOfBirth" class="form-control">
                    </div>
                    <p align="center">
                        <button type="submit" class="btn"> Register </button>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>