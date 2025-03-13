<?php
session_start();

// redirect to home page if already logged in
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

        <h1> Log In</h1>

        <div class="loginForm">
            <div class="formItem">
                <label for="username"></label><i class="fa fa-user"></i><input type="text" autocomplete="username" id="username" name="username" placeholder="Username" size="20" maxlength="40">
            </div>
            <div class="formItem">
                <label for="password"><i class="fa fa-lock"></i></label><input type="password" autocomplete="current-password" id="password" name="password" placeholder="Password" size="20" maxlength="40">
            </div>
            <div class="formItem">
                <input class="button" type="submit" name="submit" value="Login">
            </div>
            <p>Don't have an account?  <a class="hover-underline-animation" href="signup.php">Sign Up</a></p>
        </div>


    </div>

</body>
</html>