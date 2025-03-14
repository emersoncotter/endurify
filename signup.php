<?php
session_start();

// redirect to dashboard page if already logged in
if(isset($_SESSION['username'])) {
	if($_SESSION['username'] != '') {
		header("Location: dashboard.php");
	}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Endurify</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href='https://fonts.googleapis.com/css?family=Inria Sans' rel='stylesheet'>
<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="css/login-styles.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<style>

</style>
</head>
<body class="background-gradient">
    <div class="pane">
        <a href="index.php">
            <img src="media/logo.png" alt="Endurify Logo">
        </a>

        <h1>Sign Up</h1>

        <div class="loginForm">
            <div class="formItem">
                <label for="firstName"></label><i class="fa fa-id-card"></i><input type="text" autocomplete="given-name" id="firstName" name="firstName" placeholder="First" size="20" maxlength="40">
                <label for="lastName"></label><input type="text" autocomplete="family-name" id="lastName" name="lastName" placeholder="Last" size="20" maxlength="40">
            </div>
            <div class="formItem">
                <label for="email"></label><i class="fa fa-envelope"></i><input type="email" autocomplete="email" id="email" name="email" placeholder="Email" size="20" maxlength="40">
            </div>
            <div class="formItem">
                <label for="username"></label><i class="fa fa-user"></i><input type="text" autocomplete="username" id="username" name="username" placeholder="Username" size="20" maxlength="40">
            </div>
            <div class="formItem">
                <label for="password"><i class="fa fa-lock"></i></label><input type="password" autocomplete="new-password" id="password" name="password" placeholder="Password" size="20" maxlength="40">
            </div>
            <div class="formItem">
                <label for="confirmPassword"><i class="fa fa-lock"></i></label><input type="password" autocomplete="none" id="confirmPassword" name="password" placeholder="Confirm Password" size="20" maxlength="40">
            </div>
            <div class="formItem">
                <input class="button" type="submit" name="submit" value="Login">
            </div>
            <p>Already have an account?  <a class="hover-underline-animation" href="login.php">Log In</a></p>
        </div>


    </div>

</body>
</html>