<?php
session_start();

// Redirect to dashboard page if already logged in
if (isset($_SESSION['username']) && $_SESSION['username'] != '') {
    header("Location: dashboard.php");
    exit();
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

        <h1>Sign Up</h1>
        <form action="signup_handle.php" method="post" id="signinForm">
            <div class="signupForm">
                <div class="formItem doubleRow">
                    <div class="inputContainer">
                        <input type="text" class="doubleField required-field" autocomplete="given-name" id="firstName" name="firstName" placeholder="First" size="20" maxlength="40">
                        <span class="error-message"></span>
                    </div>

                    <div class="inputContainer">
                        <input type="text" class="doubleField required-field" autocomplete="family-name" id="lastName" name="lastName" placeholder="Last" size="20" maxlength="40">
                        <span class="error-message"></span>
                    </div>
                </div>
                <div class="formItem">
                    <input type="email" class="required-field" autocomplete="email" id="email" name="email" placeholder="Email" size="20" maxlength="40">
                    <span class="error-message"></span>
                </div>
                <div class="formItem">
                    <input type="text" class="required-field" autocomplete="username" id="username" name="username" placeholder="Username" size="20" maxlength="40">
                    <span class="error-message"></span>
                </div>
                <div class="formItem">
                    <input type="password" class="required-field" autocomplete="new-password" id="password" name="password" placeholder="Password" size="20" maxlength="40">
                    <span class="error-message"></span>
                </div>
                <div class="formItem">
                    <input type="password" class="required-field" autocomplete="new-password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" size="20" maxlength="40">
                    <span class="error-message"></span>
                </div>
                <div class="formItem doubleRow">
                    <div class="inputContainer">
                        <select class="doubleField dropdown required-field" id="gender" name="gender">
                            <option value="" disabled selected>Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="non-binary">Non-Binary</option>
                            <option value="prefer-not">Prefer not to say</option>
                            <option value="other">Other</option>
                        </select>
                        <span class="error-message"></span>
                    </div>
                    <div class="inputContainer">
                        <input type="text" class="doubleField required-field" autocomplete="postal-code" id="zipcode" name="zipcode" placeholder="Zip Code" size="20" maxlength="5">
                        <span class="error-message"></span>
                    </div>
                </div>
                <div class="formItem">
                    <input class="button" type="submit" name="submit" value="Sign Up">
                    <?php if(isset($_GET["status"]) && $_GET["status"] === 'username') { echo '<span class="error-message invalid-message" style="display:block;">That username already exists!</span>';}?>
                    <?php if(isset($_GET["status"]) && $_GET["status"] === 'email') { echo '<span class="error-message invalid-message" style="display:block;">That email already exists!</span>';}?>
                </div>
                <p>Already have an account? <a class="hover-underline-animation" href="login.php">Log In</a></p>
            </div>
        </form>
    </div>

    <!-- Form Validation JavaScript -->
    <script>
        document.getElementById("signinForm").addEventListener("submit", function(event) {
        let inputs = document.querySelectorAll(".required-field");
        let isValid = true;

        inputs.forEach(input => {
            let errorSpan = input.nextElementSibling;
            
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add("error");

                if (errorSpan) {
                    errorSpan.textContent = "This field is required";
                    errorSpan.style.display = "block";
                }
            } else {
                input.classList.remove("error");

                if (errorSpan) {
                    errorSpan.textContent = "";
                    errorSpan.style.display = "none";
                }
            }
        });

        // Validate password confirmation
        let password = document.getElementById("password");
        let confirmPassword = document.getElementById("confirmPassword");
        let confirmError = confirmPassword.nextElementSibling;

        if (password.value !== confirmPassword.value || confirmPassword.value.trim() === "") {
            isValid = false;
            confirmError.textContent = "Passwords do not match";
            confirmError.style.display = "block";
            confirmPassword.classList.add("error");
        } else {
            confirmError.textContent = "";
            confirmError.style.display = "none";
            confirmPassword.classList.remove("error");
        }

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if there are errors
        }
    });

    // Live validation while typing in the confirm password field
    document.getElementById("confirmPassword").addEventListener("input", function() {
        let password = document.getElementById("password").value;
        let confirmPassword = this.value;
        let confirmError = this.nextElementSibling;

        if (password !== confirmPassword) {
            confirmError.textContent = "Passwords do not match";
            confirmError.style.display = "block";
            this.classList.add("error");
        } else {
            confirmError.textContent = "";
            confirmError.style.display = "none";
            this.classList.remove("error");
        }
    });
    </script>
</body>
</html>