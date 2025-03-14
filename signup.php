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
    <div class="pane tall">
        <a href="index.php">
            <img src="media/logo.png" alt="Endurify Logo">
        </a>

        <h1>Sign Up</h1>

        <div class="signupForm">
            <div class="formItem">
                <input type="text" class="half-1" autocomplete="given-name" id="firstName" name="firstName" placeholder="First" size="20" maxlength="40">
                <label for="lastName"></label><input type="text" class="half-2" autocomplete="family-name" id="lastName" name="lastName" placeholder="Last" size="20" maxlength="40">
            </div>
            <div class="formItem">
                <input type="email" autocomplete="email" id="email" name="email" placeholder="Email" size="20" maxlength="40">
            </div>
            <div class="formItem">
                <input type="text" autocomplete="username" id="username" name="username" placeholder="Username" size="20" maxlength="40">
            </div>
            <div class="formItem">
                <input type="password" autocomplete="new-password" id="password" name="password" placeholder="Password" size="20" maxlength="40">
            </div>
            <div class="formItem">

                <input type="password" autocomplete="none" id="confirmPassword" name="password" placeholder="Confirm Password" size="20" maxlength="40">
            </div>
            <div class="formItem">
                <select class="half-1 dropdown" id="gender" name="gender" class="dropdown">
                    <option value="" disabled selected>Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="non-binary">Non-Binary</option>
                    <option value="prefer-not">Prefer not to say</option>
                    <option value="other">Other</option>
                </select>
                <input type="text" class="half-2" autocomplete="postal-code" id="zipcode" name="zipcode" placeholder="Zip Code" size="20" maxlength="5">
            </div>
            <div class="formItem">
                <input class="button" type="submit" name="submit" value="Login">
            </div>
            <p>Already have an account?  <a class="hover-underline-animation" href="login.php">Log In</a></p>
        </div>


    </div>

</body>
</html>