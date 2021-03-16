<html>
<head>
    <title> PsychNova login </title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
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
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn"> Login </button>
                </form>
                <h6> Don't have an account? Register. </h6>
                <a href="register.php"><button class="btn">Create an account</button></a>
            </div>
        </div>
    </div>
</div>
</body>
</html>