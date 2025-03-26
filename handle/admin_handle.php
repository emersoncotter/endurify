<?php

// Check whether cookie is present
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if(empty($_SESSION['username']) || $_SESSION['role'] != "admin") {
		header("Location: ../dashboard.php");
	}

if(isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = '';
}

include('mysqli_connect.php');
        
if($action == "createExercise") {
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
        header("Location: ../admin.php?action=createExercise&status=error");
    } else {
        // Formulate the and run query to check if email exists in the database
        $check_name = "SELECT * from exercises WHERE name = '$exercise_name'"; 
        $check_name_result = mysqli_query($dbc, $check_name);

        if(mysqli_num_rows($check_name_result) > 0){
            header("Location: ../admin.php?action=createExercise&status=duplicate");
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
                header("Location: ../admin.php?action=createExercise&status=success");
            } else {
                header("Location: ../admin.php?action=createExercise&status=error");
            }
        }

    }
} else if ($action == "createRegimen") {
    // Value Checks
    $name = !empty($_POST['regimenName']) ? mysqli_real_escape_string($dbc, ucwords(trim($_POST['regimenName']))) : NULL;
    $description = !empty($_POST['regimenDescription']) ? mysqli_real_escape_string($dbc, ucfirst(trim($_POST['regimenDescription']))) : NULL;

    // Unfilled Form Message
    if ($name == NULL || $description == NULL) {
        header("Location: ../admin.php?action=createExercise&status=error");
    } else {
        // Formulate the and run query to check if email exists in the database
        $check_name = "SELECT * from workout_regimens WHERE regimen_name = '$name'"; 
        $check_name_result = mysqli_query($dbc, $check_name);

        if(mysqli_num_rows($check_name_result) > 0){
            header("Location: ../admin.php?action=createRegimen&status=duplicate");
        } else {
            // Prepared statement to insert
            $query = "INSERT INTO workout_regimens (
                regimen_name, description) VALUES (?, ?)";

            $stmt = mysqli_prepare($dbc, $query);

            // Bind parameters
            mysqli_stmt_bind_param($stmt, 'ss',
                $name, $description);

            // Execute and check result, return header
            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../admin.php?action=createRegimen&status=success");
            } else {
                header("Location: ../admin.php?action=createRegimen&status=error");
            }
        }
    }
} else if ($action == "modifyRegimen") {
    // Selecting Regimen
    if(!(isset($_GET["regimen"]))){
        $regimen_id = ($_POST['modifyRegimenName'] != '') ? trim(mysqli_real_escape_string($dbc, $_POST['modifyRegimenName'])) : NULL;
        
        if ($regimen_id == NULL) {
            header("Location: ../admin.php?action=modifyRegimen&status=error");
        } else {
            // Formulate the and run query to check if regimen exists in the database
            $check_id = "SELECT * from workout_regimens WHERE regimen_id = '$regimen_id'"; 
            $check_id_result = mysqli_query($dbc, $check_id);
    
            if(mysqli_num_rows($check_id_result) > 0){
                header("Location: ../admin.php?action=modifyRegimen&regimen=$regimen_id#top");
            } else {
                    header("Location: ../admin.php?action=modifyRegimen&status=error#top1");
            }
        }
    
    // Regimen Selected
    
    } else if (isset($_GET['sequence'])){
        $regimen_id = ($_GET['regimen'] != '') ? trim(mysqli_real_escape_string($dbc, $_GET['regimen'])) : NULL;
        $sequence = ($_GET['sequence'] != '') ? trim(mysqli_real_escape_string($dbc, $_GET['sequence'])) : NULL;

        if ($sequence == NULL) {
            header("Location: ../admin.php?action=modifyRegimen&regimen=$regimen_id&status=error");
        } else {
            // Sequence is Set
            if(isset($_GET['r'])) {
                $query = "DELETE FROM workout_exercises WHERE regimen_id = ? AND sequence = ?";

                $deletestmt = mysqli_prepare($dbc, $query);
                mysqli_stmt_bind_param($deletestmt, 'ii', $regimen_id, $sequence);

                if (mysqli_stmt_execute($deletestmt)) {
                    header("Location: ../admin.php?action=modifyRegimen&regimen=$regimen_id&status=success#top");
                    exit();
                } else {
                    header("Location: ../admin.php?action=modifyRegimen&regimen=$regimen_id&status=error#top");
                    exit();
                }
            }
            
            // Value Checks
            $rest = !empty($_POST['modifyRegimenRest']) ? mysqli_real_escape_string($dbc, trim($_POST['modifyRegimenRest'])) : NULL;
            $reps = !empty($_POST['modifyRegimenReps']) ? mysqli_real_escape_string($dbc, trim($_POST['modifyRegimenReps'])) : NULL;
            $sets = !empty($_POST['modifyRegimenSets']) ? mysqli_real_escape_string($dbc, trim($_POST['modifyRegimenSets'])) : NULL;
            $notes = !empty($_POST['modifyRegimenNotes']) ? mysqli_real_escape_string($dbc, ucwords(trim($_POST['modifyRegimenNotes']))) : NULL;
            
            // Selection Checks
            $exercise = ($_POST['modifyRegimenExercise'] != '') ? trim(mysqli_real_escape_string($dbc, $_POST['modifyRegimenExercise'])) : NULL;

            // Unfilled Form Message
            if ($rest == NULL || $reps == NULL || $sets == NULL || $notes == NULL || $exercise == NULL) {
                // echo "Error 1: " . mysqli_stmt_error($stmt);
                // exit();
                header("Location: ../admin.php?action=modifyRegimen&regimen=$regimen_id&status=error#top");
            } else {
                // Formulate and run query to check that exercise exists in the database
                $check_name = "SELECT * from exercises WHERE exercise_id = '$exercise'"; 
                $check_name_result = mysqli_query($dbc, $check_name);

                if(mysqli_num_rows($check_name_result) == 0){
                    // echo "Error 1: " . mysqli_stmt_error($stmt);
                    // exit();
                    header("Location: ../admin.php?action=modifyRegimen&regimen=$regimen_id&status=error#top");
                } else {
                    // New Exercise
                    if ($sequence === 'new') {
                        // Get current highest sequence number
                        $seqQuery = "SELECT MAX(sequence) AS max_seq FROM workout_exercises WHERE regimen_id = ?";
                        $seqStmt = mysqli_prepare($dbc, $seqQuery);
                        mysqli_stmt_bind_param($seqStmt, 'i', $regimen_id);
                        mysqli_stmt_execute($seqStmt);
                        $seqResult = mysqli_stmt_get_result($seqStmt);
                        $row = mysqli_fetch_assoc($seqResult);
                        $sequence = isset($row['max_seq']) && $row['max_seq'] !== null ? $row['max_seq'] + 1 : 1;
                        mysqli_stmt_close($seqStmt);

                        // Prepared statement to insert new exercise into regimen
                        $query = "INSERT INTO workout_exercises (
                            regimen_id, exercise_id, sequence, reps, sets, rest_time, notes) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
                        $stmt = mysqli_prepare($dbc, $query);
        
                        // Bind parameters
                        mysqli_stmt_bind_param($stmt, 'iiiiiis',
                            $regimen_id,$exercise, $sequence, $reps, $sets, $rest, $notes);
        
                        // Execute and check result, return header
                        if (mysqli_stmt_execute($stmt)) {
                            header("Location: ../admin.php?action=modifyRegimen&regimen=$regimen_id&status=success#top");
                        } else {
                            // echo "Error 3: " . mysqli_stmt_error($stmt);
                            // exit();
                            header("Location: ../admin.php?action=modifyRegimen&regimen=$regimen_id&status=error#top");
                        }
                    } else {
                        // Update Existing Exercise
                        // Prepared statement to update existing exercise from regimen
                        $query = "UPDATE workout_exercises 
                                SET exercise_id = ?, reps = ?, sets = ?, rest_time = ?, notes = ?
                                WHERE regimen_id = ? AND sequence = ?";
        
                        $stmt = mysqli_prepare($dbc, $query);
        
                        // Bind parameters
                        mysqli_stmt_bind_param($stmt, 'iiiisii',
                            $exercise,  $reps, $sets, $rest, $notes, $regimen_id, $sequence);
        
                        // Execute and check result, return header
                        if (mysqli_stmt_execute($stmt)) {
                            header("Location: ../admin.php?action=modifyRegimen&regimen=$regimen_id&status=success#top");
                        } else {
                            // echo "Error 4: " . mysqli_stmt_error($stmt);
                            // exit();
                            header("Location: ../admin.php?action=modifyRegimen&regimen=$regimen_id&status=error#top");
                        }

                    }
                }

            }
        }

    }

    } else {
        header("Location: ../admin.php");
    }


	?>