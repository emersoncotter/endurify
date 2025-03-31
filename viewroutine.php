<?php
// Redirect user if not logged in
session_start();
if (empty($_SESSION['username'])) { 
    header("Location: login.php");    
    exit();
    } 

  include('handle/mysqli_connect.php');

  if (isset($_GET['routine'])) {
    $_SESSION['routine'] = (int) $_GET['routine'];

    $routineList = "SELECT * FROM custom_workouts WHERE user_id = ? AND workout_id = ?";
    $stmt = mysqli_prepare($dbc, $routineList);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ii', $_SESSION["user_id"],$_SESSION['routine']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $numRows = mysqli_num_rows($result);

      if($numRows != 1) {
        header("Location: dashboard.php");
      } 

    } else {
      header("Location: dashboard.php");
    }

  } else {
    header("Location: dashboard.php");
  }


  
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Endurify | View Routine</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/view-styles.css">

  </head>
  
  <body class="background-gradient">
    <!-- Left Sidebar -->
    <div>
      <?php 
        $currentPage = "workouts";
        include('shared/sidebar.php'); 
        ?>
    </div>
    
    <!-- Dashboard -->
    <div class="dashboard-container">

    <!-- Dashboard Content -->
      <div class="dash-content">        
          <!-- Main Content -->
          <div class="main-content">
            <div class="dash-item">
              

              <?php
                $routine = $_SESSION['routine'];
                
                $query = "SELECT cw.* FROM custom_workouts cw WHERE workout_id = ?";
                $stmt = mysqli_prepare($dbc, $query);
                mysqli_stmt_bind_param($stmt, 'i', $routine);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                if ($row = mysqli_fetch_assoc($result)) {

                  $creation_date = date('m-d-Y', strtotime($row["creation_date"]));

                  echo "
                    <h1 class='workout-title'>{$row['workout_name']}</h1>
                    <div class='workout-info'>
                    <span class='tag xp'>Custom Routine</span>
                      <span class='tag category'>Created: $creation_date</span>
                    </div>
                    <p class='workout-desc'>{$row['description']}</p>
                    <a href='modifyroutine.php?id={$row["workout_id"]}' class='button'>Modify</a>
                  ";
                }

                $workout_id = mysqli_real_escape_string($dbc, $_GET['routine']);
                $workout_exercises_sql = "SELECT cwe.*, e.*, ec.name AS category_name FROM custom_workout_exercises cwe JOIN exercises e ON cwe.exercise_id = e.exercise_id JOIN exercise_categories ec ON e.category = ec.category_id WHERE cwe.workout_id = ? ORDER BY sequence";

                if ($stmt = mysqli_prepare($dbc, $workout_exercises_sql)) {
                    mysqli_stmt_bind_param($stmt, 'i', $routine);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $numRows = mysqli_num_rows($result);


                    echo '<h3>Exercises</h3>';

                    
                    if ($numRows === 0) {
                        echo "<h4>No exercises to display!</h4>";
                    } else {
                      while ($row = mysqli_fetch_assoc($result)) {

                      // echo " {$row["name"]} | {$row['rest_time']} sec | {$row['reps']} reps | {$row['sets']} sets | Notes: {$row['notes']} <br> ";
                      $img = htmlspecialchars("media/regimens/{$row["category_name"]}.png");

                      echo " 
                      <div class='exercise-row-card'>
                        <div class='exercise-left' style=\"background-image: linear-gradient(135deg,rgba(0, 200, 255, 0.6),rgba(0, 115, 255, 0.6)), url('$img');\">
                          
                        </div>
                        
                        <div class='exercise-body'>
                          <h2 class='exercise-title'>{$row["name"]}</h2>
                          
                          <div class='exercise-info'>
                            <span><i class='fa fa-dumbbell'></i> {$row['sets']} × {$row['reps']}</span>
                            <span><i class='fa fa-stopwatch'></i> {$row['rest_time']} sec rest</span>
                          </div>

                          <p class='exercise-notes'>{$row['notes']}</p>
                          
                          <div class='exercise-tags'>
                            <span class='tag category'>Difficulty: {$row['difficulty']}/5</span>
                            <span class='tag category'>{$row['category_name']}</span>
                          </div>
                        </div>
                      </div>
                      
                      ";
                  }
                }
              }

              ?>
            </div>

          </div>

          <div class="side-content">
          </div>
     
      </div>
    </div>
    
  </body>
</html>