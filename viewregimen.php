<?php
// Redirect user if not logged in
session_start();
if (empty($_SESSION['username'])) { 
    header("Location: login.php");    
    exit();
    } 

  if (isset($_GET['regimen'])) {
    $_SESSION['id'] = (int) $_GET['regimen'];
  } else {
    header("Location: ..\dashboard.php");
  }

include('handle/mysqli_connect.php');
  
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Endurify | View Workout</title>
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
                $id = $_SESSION['id'];
                
                $query = "SELECT wr.*, ec.name as category_name FROM workout_regimens wr JOIN exercise_categories ec ON wr.category_id = ec.category_id WHERE regimen_id = ?";
                $stmt = mysqli_prepare($dbc, $query);
                mysqli_stmt_bind_param($stmt, 'i', $id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                if ($row = mysqli_fetch_assoc($result)) {
                  echo "
                    <h1 class='workout-title'>{$row['regimen_name']}</h1>
                    <div class='workout-info'>
                      <span class='tag {$row["difficulty"]}'>{$row["difficulty"]}</span>
                      <span class='tag xp'>{$row["xp_amount"]} xp</span>
                      <span class='tag category'>{$row["category_name"]}</span>
                    </div>
                    <p class='workout-desc'>{$row['description']}</p>
                  
                  ";
                }

                $regimen_id = mysqli_real_escape_string($dbc, $_GET['regimen']);
                $regimen_exercises_sql = "SELECT we.*, e.*, ec.name AS category_name FROM workout_exercises we JOIN exercises e ON we.exercise_id = e.exercise_id JOIN exercise_categories ec ON e.category = ec.category_id WHERE we.regimen_id = ? ORDER BY sequence";

                if ($stmt = mysqli_prepare($dbc, $regimen_exercises_sql)) {
                    mysqli_stmt_bind_param($stmt, 'i', $id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $numRows = mysqli_num_rows($result);


                    echo '<h3>Exercises</h3>';

                    
                    if ($numRows === 0) {
                        echo "No exercises to display!";
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