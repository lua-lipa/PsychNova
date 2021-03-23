<html>
<head>
    <title> PsychNova login </title>
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
            <div class="col-md-6 login-box">
                <form action="validation.php" method="post">
                    <div class="form-group">
                        <label> email </label>
                        <input type="text" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label> password </label>
                        <input type="text" name="password" class="form-control" required>
                    </div>
                    <p align="center">
                        <button type="submit" class="btn"> Login </button>
                    </p>
                </form>
                    <h6> Don't have an account? </h6>
                <p align="center">
                    <a href="register.php"><button class="btn">Create an account</button></a>
                </p>
            </div>
        </div>
    </div>
</div>
</body>
</html>