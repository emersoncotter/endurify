<?php
// Redirect user if not logged in
session_start();
if (empty($_SESSION['username'])) { 
    header("Location: login.php");    
    exit();
    } 
  
include('handle/mysqli_connect.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Workouts | Endurify</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
      <!-- Main Header -->
      <div class="dash-header">
        <?php 
        $title = 'Workouts';

        $Subtitles = [
            "Time to put in the work,",
            "Every rep gets you closer,",
            "Train hard. Stay strong,",
            "Your grind starts here,",
            "Let’s crush today’s workout,",
            "Push limits. Build results,",
            "Stronger every session,",
            "Ready when you are,",
            "Sweat now. Shine later,",
            "Your journey, one workout at a time,"
        ];

        if (isset($_SESSION["workouts_subtitle"])) {
          $subtitle = $_SESSION["workouts_subtitle"];
        } else {
          $subtitle = $Subtitles[array_rand($Subtitles,1)];
          $_SESSION["workouts_subtitle"] = $subtitle;
        }

        $subtitle = $subtitle." ".$_SESSION['first_name']."!";
        include('shared/dashboard-header.php'); 
        ?>
      </div>
    
    <!-- Dashboard Content -->
      <div class="dash-content">        
          <!-- Main Content -->
          <div class="main-content" id="category">
            <div class="dash-item">
              <div class="category-selector">
                <?php                       
                  $categories = mysqli_query($dbc, "SELECT category_id, name FROM exercise_categories ORDER BY category_id");
                  // All Filter Button
                  if(!isset($_GET['filter'])) {
                    $class = 'category-button active';
                  } else {
                    $class = 'category-button';
                  }

                  echo "
                      <a href='workouts.php#category'>
                        <div class='$class'>
                          <span>All</span>
                        </div>
                      </a>";

                  // Filter Buttons from Categories Table
                  while($row = mysqli_fetch_assoc($categories)) {
                    if(isset($_GET['filter']) && $row['category_id'] == $_GET['filter']) {
                      $class = 'category-button active';
                    } else {
                      $class = 'category-button';
                    }

                      echo "
                      <a href='workouts.php?filter={$row['category_id']}#category'>
                        <div class='$class'>
                          <span>{$row['name']}</span>
                        </div>
                      </a>";
                  }
                ?>
              </div>

                <?php 
                  if(isset($_GET["filter"])) {
                    $filter = (int) $_GET['filter'];
                    $regimenList = "SELECT wr.*, ec.name as category_name FROM workout_regimens wr JOIN exercise_categories ec ON wr.category_id = ec.category_id WHERE wr.category_id = ? ORDER BY category_id";
                    $stmt = mysqli_prepare($dbc, $regimenList);

                    if ($stmt) {
                      mysqli_stmt_bind_param($stmt, 'i', $filter);
                      }

                  } else {
                    $regimenList = "SELECT wr.*, ec.name as category_name FROM workout_regimens wr JOIN exercise_categories ec ON wr.category_id = ec.category_id ORDER BY category_id";
                    $stmt = mysqli_prepare($dbc, $regimenList);
                  }

                    if ($stmt) {
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $numRows = mysqli_num_rows($result);

                        echo "<div class='result-header'> <h2>Browse by Category</h2>";

                      if($numRows === 0) {
                        echo "<span class='result-count'>Showing $numRows results</span></div>";
                      } else {
                        echo "<span class='result-count'>Showing $numRows results</span></div>";
                        echo "<div class='result-grid'>";

                        while ($row = mysqli_fetch_assoc($result)) {

                          $img = htmlspecialchars("media/regimens/{$row["category_name"]}.png");
                          echo "
                          <div class='card'>
                            <div class='top' style=\"background-image: linear-gradient(135deg,rgba(0, 200, 255, 0.6),rgba(0, 115, 255, 0.6)), url('$img');\">
                              <div class='info'>
                                <span class='difficulty {$row["difficulty"]}'>{$row["difficulty"]}</span>
                              </div>
                            </div>
                            <div class='middle'>
                              <h3>{$row["regimen_name"]}</h3>
                              <span class='description'>{$row["description"]}</span>
                            </div>
                            <div class='bottom'>
                                <span class='xp'>{$row["xp_amount"]} xp</span>
                                <a class='select {$row["difficulty"]}' href='viewregimen.php?regimen={$row["regimen_id"]}'>
                                  <i class='fa fa-play'></i>
                                </a>
                            </div>
                          </div>
                          ";
                        }
                      }

                    } else {
                      echo 'No exercises found with current filter! (ref: err)';
                    }
                ?>
              </div>
            </div>
          </div>
          
          <div class="side-content">
            <div class="dash-item">
              <div class="item-header">
                <i class="fa fa-bullseye gradient-text"></i>
                <h2 class="title">Your Routines</h2>
              </div>
              <div class="routines">
              <?php 
                  $routineList = "SELECT * FROM custom_workouts WHERE user_id = ? ORDER BY workout_id";
                  $stmt = mysqli_prepare($dbc, $routineList);
                  
                  if ($stmt) {
                      mysqli_stmt_bind_param($stmt, 'i', $_SESSION["user_id"]);
                      mysqli_stmt_execute($stmt);
                      $result = mysqli_stmt_get_result($stmt);
                      $numRows = mysqli_num_rows($result);

                    if($numRows === 0) {
                    } else {
                      while ($row = mysqli_fetch_assoc($result)) {

                        echo "
                          <div class='routine-card'>
                            <div class='details'>
                                <h3>{$row["workout_name"]}</h3>
                                <span class='description'>{$row["description"]}</span>
                            </div>
                            <a class='select' href='viewroutine.php?routine={$row["workout_id"]}'>
                              <i class='fa fa-play'></i>
                            </a>
                          </div>
                        ";
                      }
                    }
                  } else {
                    echo 'Error retreiving routines! (Ref: err)';
                  }
              ?>

                <a class='button' href='modifyroutine.php?action=create'>Create Routine</a>
              </div>
            </div>

              <div class="dash-item">
                <div class="item-header">
                  <i class="fa fa-award gradient-text"></i>
                  <h2 class="title">Badges</h2>
                </div>
                <?php include('shared/badges.php'); ?>
              </div>
            </div>
          </div>
      </div>
    </div>
    
  </body>
</html>