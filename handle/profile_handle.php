<?php
// If user is not logged in, user will be redirected to log in 

// Check whether cookie is present
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if(isset($_SESSION['username'])) {
	if($_SESSION['username'] != '') {
		header("Location: ../dashboard.php");
	}
}

include('mysqli_connect.php');

		// Name Check
        $first_name = !empty($_POST['firstName']) ? mysqli_real_escape_string($dbc, trim($_POST['firstName'])) : NULL;
        $last_name = !empty($_POST['lastName']) ? mysqli_real_escape_string($dbc, trim($_POST['lastName'])) : NULL;

		// Email/Username Check
        $email = !empty($_POST['email']) ? mysqli_real_escape_string($dbc, strtolower(trim($_POST['email']))) : NULL;
        $username = !empty(trim($_POST['username'])) ? mysqli_real_escape_string($dbc, strtolower(trim($_POST['username']))) : NULL;

        // Gender Selection Check
        $gender = ($_POST['gender'] != '') ? trim(mysqli_real_escape_string($dbc, $_POST['gender'])) : NULL;

        // Zip code Check
        $zipcode = !empty(trim($_POST['zipcode'])) ? mysqli_real_escape_string($dbc, trim($_POST['zipcode'])) : NULL;

		// Unfilled Form Message
		if ($first_name == NULL || $last_name == NULL || $email == NULL || $username == NULL || $gender == NULL || $zipcode == NULL) {
            header("Location: ../profile.php?status=error");
            exit;
		} else {
            // Formulate the and run query to check if email exists in the database
            $query0 = "SELECT * FROM users WHERE LOWER(email) = LOWER(?) AND user_id != ?";
            $stmt0 = mysqli_prepare($dbc, $query0);
            mysqli_stmt_bind_param($stmt0, 'si', $email, $_SESSION['user_id']);
            mysqli_stmt_execute($stmt0);
            $result0 = mysqli_stmt_get_result($stmt0);

            if(mysqli_num_rows($result0) > 0){
                header("Location: ../profile.php?status=email");
                exit;
            }

            // Formulate the and run query to check if username exists in the database
            $query1 = "SELECT * FROM users WHERE LOWER(user_name) = LOWER(?) AND user_id != ?";
            $stmt1 = mysqli_prepare($dbc, $query1);
            mysqli_stmt_bind_param($stmt1, 'si', $username, $_SESSION['user_id']);
            mysqli_stmt_execute($stmt1);
            $result1 = mysqli_stmt_get_result($stmt1);

            if(mysqli_num_rows($result1) > 0){
                header("Location: ../profile.php?status=username");
                exit;
            } else {
                // Prepared statement
                $query2 = "UPDATE users 
                SET first_name = ?, 
                    last_name = ?, 
                    email = ?, 
                    user_name = ?, 
                    gender = ?, 
                    zipcode = ? 
                WHERE user_id = ?";

                $stmt = mysqli_prepare($dbc, $query2);

                // Bind parameters
                mysqli_stmt_bind_param($stmt, 'ssssssi', 
                $first_name, 
                $last_name, 
                $email, 
                $username,
                $gender, 
                $zipcode, 
                $_SESSION['user_id']
                );

                // Execute and check
                if (mysqli_stmt_execute($stmt)) {
                    // Update Session Values
                    $_SESSION["username"] = $username;
                    $_SESSION["first_name"] = $first_name;
                    $_SESSION["last_name"] = $last_name;
                    $_SESSION["email"] = $email;

                    header("Location: ../profile.php?status=updated");
                    exit;
                } else {
                header("Location: ../profile.php?status=error");
                exit;
                }
            }

            }
	?>