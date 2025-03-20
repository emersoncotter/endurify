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

</head>
<body class="background-gradient">
    <div class="pane">
        <a href="index.php">
            <img src="media/logo.png" alt="Endurify Logo">
        </a>

        <h1>Log In</h1>

        <form action="handle/login_handle.php" method="post" id="loginForm">
            <div class="loginForm">
                <div class="formItem">
                    <label for="username"></label><i class="fa fa-user"></i><input type="text" autocomplete="username" id="username" name="username" placeholder="Username" size="20" maxlength="40">
                    <span class="error-message"></span>
                </div>
                <div class="formItem">
                    <label for="password"><i class="fa fa-lock"></i></label><input type="password" autocomplete="current-password" id="password" name="password" placeholder="Password" size="20" maxlength="40">
                    <span class="error-message"></span>
                </div>
                <div class="formItem">
                    <input class="button" type="submit" name="submit" value="Login">
                    <?php 
                        if(isset($_GET["status"]) && $_GET["status"] === 'error') { echo '<span class="error-message invalid-message">Invalid Username or Password!</span>';}
                        if(isset($_GET["status"]) && $_GET["status"] === 'created') { echo '<span class="error-message invalid-message" style="color:green;">Account created successfully, please log in!</span>';}
                    ?>
                </div>
                <p>Don't have an account?  <a class="hover-underline-animation" href="signup.php">Sign Up</a></p>
            </div>
        </form>

    </div>

    <!-- Form Validation JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
    let form = document.getElementById("loginForm");
    let inputs = document.querySelectorAll("#loginForm input[type='text'], #loginForm input[type='password']");

    // Function to validate a single input
    function validateInput(input) {
        let errorSpan = input.nextElementSibling;

        if (!input.value.trim()) {
            input.classList.add("error");
            errorSpan.textContent = "This field is required";
            errorSpan.style.display = "block";
        } else {
            input.classList.remove("error");
            errorSpan.textContent = "";
            errorSpan.style.display = "none";
        }
    }

    // Live validation while typing
    inputs.forEach(input => {
        input.addEventListener("input", function () {
            validateInput(this);
        });
    });

    // Form submission validation
    form.addEventListener("submit", function (event) {
        let isValid = true;

        inputs.forEach(input => {
            validateInput(input);
            if (input.classList.contains("error")) {
                isValid = false;
            }
        });

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if any errors exist
        }
    });
});
    </script>

</body>
</html>