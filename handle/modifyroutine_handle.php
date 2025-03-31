<?php
// Check whether cookie is present
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if(empty($_SESSION['username'])) {
		header("Location: ../dashboard.php");
	}

if(isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = '';
}

include('mysqli_connect.php');


if ($action == "createRoutine") {
    // Value Checks
    $name = !empty($_POST['routineName']) ?  ucwords(trim($_POST['routineName'])) : NULL;
    $description = !empty($_POST['routineDescription']) ?  ucfirst(trim($_POST['routineDescription'])) : NULL;

    // Unfilled Form Message
    if ($name == NULL || $description == NULL) {
        header("Location: ../modifyroutine.php?action=create&status=error");
    } else {
        // Prepared statement to insert
        $query = "INSERT INTO custom_workouts (
            workout_name, description, user_id) VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($dbc, $query);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'ssi',
            $name, $description, $_SESSION["user_id"]);

        // Execute and check result, return header
        if (mysqli_stmt_execute($stmt)) {

            $routine_id = mysqli_insert_id($dbc);


            header("Location: ../modifyroutine.php?id=$routine_id&status=success");
        } else {
            header("Location: ../modifyroutine.php?action=create&status=error");
        }
    }
} else if ($action == "modifyRoutine") {
    // Selecting Routine
    if(!(isset($_GET["routine"]))){
        $routine_id = ($_POST['modifyRoutineName'] != '') ? trim( $_POST['modifyRoutineName']) : NULL;
        
        if ($routine_id == NULL) {
            header("Location: ../modifyroutine.php?action=modifyRoutine&status=error");
        } else {
            // Formulate the and run query to check if routine exists in the database
            $check_id = "SELECT * from custom_workouts WHERE workout_id = '$routine_id'"; 
            $check_id_result = mysqli_query($dbc, $check_id);
    
            if(mysqli_num_rows($check_id_result) > 0){
                header("Location: ../modifyroutine.php?action=modifyRoutine&id=$routine_id#top");
            } else {
                    header("Location: ../modifyroutine.php?action=modifyRoutine&status=error#top");
            }
        }
    
    // Routine Selected
    
    } else if (isset($_GET['sequence'])){
        $routine_id = ($_GET['routine'] != '') ? trim( $_GET['routine']) : NULL;
        $sequence = ($_GET['sequence'] != '') ? trim( $_GET['sequence']) : NULL;

        if ($sequence == NULL) {
            header("Location: ../modifyroutine.php?action=modifyRoutine&id=$routine_id&status=error");
        } else if ($sequence == "details") {

            if(isset($_GET['r'])) {
                $query = "DELETE FROM custom_workouts WHERE workout_id = ?";

                $deletestmt = mysqli_prepare($dbc, $query);
                mysqli_stmt_bind_param($deletestmt, 'i', $routine_id);

                if (mysqli_stmt_execute($deletestmt)) {
                    header("Location: ../workouts.php");
                    exit();
                } else {
                    header("Location: ../modifyroutine.php?action=modifyRoutine&status=error#top4");
                    exit();
                }
            }

            // Value Checks
            $name = !empty($_POST['routineDetailName']) ?  ucwords(trim($_POST['routineDetailName'])) : NULL;
            $description = !empty($_POST['routineDetailDescription']) ?  ucfirst(trim($_POST['routineDetailDescription'])) : NULL;

            // Unfilled Form Message
            if ($name == NULL || $description == NULL) {
                header("Location: ../modifyroutine.php?action=modifyRoutine&id=$routine_id&status=error");
            } else {
                    // Prepared statement to insert
                    $query = "UPDATE custom_workouts
                              SET workout_name = ?, description = ?
                              WHERE workout_id = ? AND user_id = ?";

                    $stmt = mysqli_prepare($dbc, $query);

                    // Bind parameters
                    mysqli_stmt_bind_param($stmt, 'ssii',
                                $name,  $description, $routine_id, $_SESSION['user_id']);

                    // Execute and check result, return header
                    // Execute the query
                    mysqli_stmt_execute($stmt);

                    // Optional: check for success
                    if (mysqli_stmt_affected_rows($stmt) > 0) {
                        header("Location: ../modifyroutine.php?action=modifyRoutine&id=$routine_id&status=success");
                    } else {
                        header("Location: ../modifyroutine.php?action=modifyRoutine&id=$routine_id&status=error");
                    }
            }
        } else {
            // Sequence is Set
            if(isset($_GET['r'])) {
                $query = "DELETE FROM custom_workout_exercises WHERE workout_id = ? AND sequence = ?";

                $deletestmt = mysqli_prepare($dbc, $query);
                mysqli_stmt_bind_param($deletestmt, 'ii', $routine_id, $sequence);

                if (mysqli_stmt_execute($deletestmt)) {
                    header("Location: ../modifyroutine.php?action=modifyRoutine&id=$routine_id&status=success#top5");
                    exit();
                } else {
                    header("Location: ../modifyroutine.php?action=modifyRoutine&id=$routine_id&status=error#top6");
                    exit();
                }
            }
            
            // Value Checks
            $rest = !empty($_POST['modifyRoutineRest']) ?  trim($_POST['modifyRoutineRest']) : NULL;
            $reps = !empty($_POST['modifyRoutineReps']) ?  trim($_POST['modifyRoutineReps']) : NULL;
            $sets = !empty($_POST['modifyRoutineSets']) ?  trim($_POST['modifyRoutineSets']) : NULL;
            $notes = !empty($_POST['modifyRoutineNotes']) ?  ucfirst(trim($_POST['modifyRoutineNotes'])) : NULL;
            
            // Selection Checks
            $exercise = ($_POST['modifyRoutineExercise'] != '') ? trim( $_POST['modifyRoutineExercise']) : NULL;

            // Unfilled Form Message
            if ($rest == NULL || $reps == NULL || $sets == NULL || $notes == NULL || $exercise == NULL) {
                // echo "Error 1: " . mysqli_stmt_error($stmt);
                // exit();
                header("Location: ../modifyroutine.php?action=modifyRoutine&id=$routine_id&status=error#top7");
            } else {
                // Formulate and run query to check that exercise exists in the database
                $check_name = "SELECT * from exercises WHERE exercise_id = '$exercise'"; 
                $check_name_result = mysqli_query($dbc, $check_name);

                if(mysqli_num_rows($check_name_result) == 0){
                    // echo "Error 1: " . mysqli_stmt_error($stmt);
                    // exit();
                    header("Location: ../modifyroutine.php?action=modifyRoutine&id=$routine_id&status=error#top8");
                } else {
                    // New Exercise
                    if ($sequence === 'new') {
                        // Get current highest sequence number
                        $seqQuery = "SELECT MAX(sequence) AS max_seq FROM custom_workout_exercises WHERE workout_id = ?";
                        $seqStmt = mysqli_prepare($dbc, $seqQuery);
                        mysqli_stmt_bind_param($seqStmt, 'i', $routine_id);
                        mysqli_stmt_execute($seqStmt);
                        $seqResult = mysqli_stmt_get_result($seqStmt);
                        $row = mysqli_fetch_assoc($seqResult);
                        $sequence = isset($row['max_seq']) && $row['max_seq'] !== null ? $row['max_seq'] + 1 : 1;
                        mysqli_stmt_close($seqStmt);

                        // Prepared statement to insert new exercise into routine
                        $query = "INSERT INTO custom_workout_exercises (
                            workout_id, exercise_id, sequence, reps, sets, rest_time, notes) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
                        $stmt = mysqli_prepare($dbc, $query);
        
                        // Bind parameters
                        mysqli_stmt_bind_param($stmt, 'iiiiiis',
                            $routine_id,$exercise, $sequence, $reps, $sets, $rest, $notes);
        
                        // Execute and check result, return header
                        if (mysqli_stmt_execute($stmt)) {
                            header("Location: ../modifyroutine.php?action=modifyRoutine&id=$routine_id&status=success#top9");
                        } else {
                            // echo "Error 3: " . mysqli_stmt_error($stmt);
                            // exit();
                            header("Location: ../modifyroutine.php?action=modifyRoutine&id=$routine_id&status=error#top10");
                        }
                    } else {
                        // Update Existing Exercise
                        // Prepared statement to update existing exercise from routine
                        $query = "UPDATE custom_workout_exercises 
                                SET exercise_id = ?, reps = ?, sets = ?, rest_time = ?, notes = ?
                                WHERE workout_id = ? AND sequence = ?";
        
                        $stmt = mysqli_prepare($dbc, $query);
        
                        // Bind parameters
                        mysqli_stmt_bind_param($stmt, 'iiiisii',
                            $exercise,  $reps, $sets, $rest, $notes, $routine_id, $sequence);
        
                        // Execute and check result, return header
                        if (mysqli_stmt_execute($stmt)) {
                            header("Location: ../modifyroutine.php?action=modifyRoutine&id=$routine_id&status=success#top11");
                        } else {
                            // echo "Error 4: " . mysqli_stmt_error($stmt);
                            // exit();
                            header("Location: ../modifyroutine.php?action=modifyRoutine&id=$routine_id&status=error#top12");
                        }

                    }
                }

            }
        }

    }

    } else {
        header("Location: ../workouts.php");
    }






?>