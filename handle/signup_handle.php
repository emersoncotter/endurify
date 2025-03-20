<?php

// This page is administrator only. It will show when the user is logged in.
// If user is not logged in, user will be redirected to log in 

// Check whether cookie is present
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if(isset($_SESSION['username'])) {
	if($_SESSION['username'] != '') {
		header("Location: dashboard.php");
	}
}

include('mysqli_connect.php');

		// Name Check
        $first_name = !empty($_POST['firstName']) ? mysqli_real_escape_string($dbc, trim($_POST['firstName'])) : NULL;
        $last_name = !empty($_POST['lastName']) ? mysqli_real_escape_string($dbc, trim($_POST['lastName'])) : NULL;

		// Email/Username Check
        $email = !empty($_POST['email']) ? mysqli_real_escape_string($dbc, strtolower(trim($_POST['email']))) : NULL;
        $username = !empty(trim($_POST['username'])) ? mysqli_real_escape_string($dbc, strtolower(trim($_POST['username']))) : NULL;

        // Password Checks
        $password = !empty(trim($_POST['password'])) ? mysqli_real_escape_string($dbc, trim($_POST['password'])) : NULL;
        $confirm_password = !empty(trim($_POST['confirmPassword'])) ? mysqli_real_escape_string($dbc, trim($_POST['confirmPassword'])) : NULL;

        // Gender Selection Check
        $gender = ($_POST['gender'] != '') ? trim(mysqli_real_escape_string($dbc, $_POST['gender'])) : NULL;

        // Zip code Check
        $zipcode = !empty(trim($_POST['zipcode'])) ? mysqli_real_escape_string($dbc, trim($_POST['zipcode'])) : NULL;

        // Confirm Password Check, otherwise set to null
        if ($password != $confirm_password) {
            $password == NULL;
            $confirm_password == NULL;
        }

		// Unfilled Form Message
		if ($first_name == NULL || $last_name == NULL || $email == NULL || $username == NULL || $password == NULL || $gender == NULL || $zipcode == NULL) {
			header("Location: ../signup.php?status=error");
		} else {
            // Formulate the and run query to check if email exists in the database
            $query0 = "SELECT * from users WHERE LOWER(email) = LOWER('$email')"; 
            $result0 = mysqli_query($dbc, $query0);

            if(mysqli_num_rows($result0) > 0){
                header("Location: ../signup.php?status=email");
            }

            // Formulate the and run query to check if username exists in the database
            $query1 = "SELECT * from users WHERE LOWER(user_name) = LOWER('$username')"; 
            $result1 = mysqli_query($dbc, $query1);

            if(mysqli_num_rows($result1) > 0){
                header("Location: ../signup.php?status=username");
            } else {
                // Insert user into database
                $query2 = "INSERT into users(first_name, last_name, email, user_name, password, gender, zipcode) VALUES ('$first_name', '$last_name', '$email', '$username', SHA2('$password', 256), '$gender', '$zipcode')";
                $result2 = mysqli_query($dbc, $query2);
    
                    // Check if the query is successful, result will be False if failure of running the query
                    if ($result2) { 
                        
                        header("Location: ../login.php?status=created");
    
                    // if not, return error
                    } else { header("Location: ../signup.php?status=error"); }
            }

            }
	?>