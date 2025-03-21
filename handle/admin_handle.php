<?php

// Check whether cookie is present
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if(empty($_SESSION['username']) || $_SESSION['role'] != "admin") {
		header("Location: ../dashboard.php");
	}

include('mysqli_connect.php');

		// Value Checks
        $exercise_name = !empty($_POST['name']) ? mysqli_real_escape_string($dbc, ucwords(trim($_POST['name']))) : NULL;
        $difficulty = !empty($_POST['difficulty']) ? mysqli_real_escape_string($dbc, trim($_POST['difficulty'])) : NULL;
        $duration = !empty($_POST['duration']) ? mysqli_real_escape_string($dbc, trim($_POST['duration'])) : NULL;
        $short_desc = !empty($_POST['shorthand_description']) ? mysqli_real_escape_string($dbc, ucfirst(trim($_POST['shorthand_description']))) : NULL;
        $description = !empty($_POST['description']) ? mysqli_real_escape_string($dbc, ucfirst(trim($_POST['description']))) : NULL;
        
        // Selection Checks
        $category = ($_POST['category'] != '') ? trim(mysqli_real_escape_string($dbc, $_POST['category'])) : NULL;
        $equipment = ($_POST['equipment'] != '') ? trim(mysqli_real_escape_string($dbc, $_POST['equipment'])) : NULL;
        $muscle = ($_POST['muscle'] != '') ? trim(mysqli_real_escape_string($dbc, $_POST['muscle'])) : NULL;

		// Unfilled Form Message
		if ($exercise_name == NULL || $difficulty == NULL || $duration == NULL || $short_desc == NULL || $description == NULL || $category == NULL || $equipment == NULL || $muscle == NULL) {
			header("Location: ../admin.php?status=error");
		} else {
            // Formulate the and run query to check if email exists in the database
            $check_name = "SELECT * from exercises WHERE name = '$exercise_name'"; 
            $check_name_result = mysqli_query($dbc, $check_name);

            if(mysqli_num_rows($check_name_result) > 0){
                header("Location: ../admin.php?status=duplicate");
            } else {
                // Prepared statement to insert
                $query = "INSERT INTO exercises (
                    name, category, difficulty, duration, equipment, muscle, shorthand_description, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = mysqli_prepare($dbc, $query);

                // Bind parameters
                mysqli_stmt_bind_param($stmt, 'siiiiiss',
                    $exercise_name,$category, $difficulty, $duration, $equipment, $muscle, $short_desc, $description);

                // Execute and check result, return header
                if (mysqli_stmt_execute($stmt)) {
                    header("Location: ../admin.php?status=success");
                } else {
                    header("Location: ../admin.php?status=error");
                }
            }

            }
	?>