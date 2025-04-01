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
    <title>Endurify | Learn</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/view-styles.css">
  </head>
  
  <body class="background-gradient">
    <!-- Left Sidebar -->
    <div>
      <?php 
        $currentPage = "learn";
        include('shared/sidebar.php'); 
        ?>
    </div>
    
    <!-- Dashboard -->
    <div class="dashboard-container">
      <!-- Main Header -->
      <div class="dash-header">
        <?php 
          $title = 'Learning';

          $Subtitles = [
            "Expand your knowledge today,",
            "Sharpen your skills,",
            "Take on a new challenge,",
            "Discover something new,",
            "Fuel your fitness mindset,",
            "Unlock a new lesson,",
            "Boost your brainpower,",
            "Explore the next level,",
            "Upgrade your understanding,",
            "Keep your mind moving,",
            "Ready when you are,"
          ];

          if (isset($_SESSION["learn_subtitle"])) {
            $subtitle = $_SESSION["learn_subtitle"];
          } else {
            $subtitle = $Subtitles[array_rand($Subtitles,1)];
            $_SESSION["learn_subtitle"] = $subtitle;
          }

          $subtitle = $subtitle." ".$_SESSION['first_name']."!";

          include('shared/dashboard-header.php'); 
        ?>
      </div>
    
    <!-- Dashboard Content -->
      <div class="dash-content">        
          <!-- Main Content -->
          <div class="main-content">
            <div class="dash-item">
              <h1 style='margin-bottom: 10px;'>Featured Courses</h1>
              <?php 
                    $featuredCourseList = "SELECT c.*, ec.name as category_name FROM courses c JOIN exercise_categories ec ON c.category_id = ec.category_id WHERE featured = 1 ORDER BY category_id";
                    $stmt = mysqli_prepare($dbc, $featuredCourseList);
                  

                    if ($stmt) {
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $numRows = mysqli_num_rows($result);

                      if($numRows > 0) {
                        echo "<div class='result-grid' style='justify-content: left;'>";

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
                              <h3>{$row["course_name"]}</h3>
                              <span class='description'>{$row["description"]}</span>
                            </div>
                            <div class='bottom'>
                                <span class='xp'>{$row["xp_amount"]} xp</span>
                                <a class='select {$row["difficulty"]}' href='viewregimen.php?regimen={$row["course_id"]}'>
                                  <i class='fa fa-play'></i>
                                </a>
                            </div>
                          </div>
                          ";
                          
                        }
                        echo "</div>";
                    } else {
                        echo "No currently featured courses!";
                        
                        }
                      
                    } else {
                      echo "Could not load featured courses!";
                    }
                    ?>
            </div>

            <div class="dash-item" id="category">
              <h1>Browse Courses</h1>
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
                      <a href='learn.php#category'>
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
                      <a href='learn.php?filter={$row['category_id']}#category'>
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
                    $courseList = "SELECT c.*, ec.name as category_name FROM courses c JOIN exercise_categories ec ON c.category_id = ec.category_id WHERE c.category_id = ? ORDER BY category_id";
                    $stmt = mysqli_prepare($dbc, $courseList);

                    if ($stmt) {
                      mysqli_stmt_bind_param($stmt, 'i', $filter);
                      }

                  } else {
                    $courseList = "SELECT c.*, ec.name as category_name FROM courses c JOIN exercise_categories ec ON c.category_id = ec.category_id ORDER BY category_id";
                    $stmt = mysqli_prepare($dbc, $courseList);
                  }

                    if ($stmt) {
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $numRows = mysqli_num_rows($result);

                        echo "<div class='result-header'> <h2>Results</h2>";

                      if($numRows === 0) {
                        echo "<span class='result-count'>Showing $numRows results</span></div>";
                        echo "No courses match the current filter!";
                      } else {
                        echo "<span class='result-count'>Showing $numRows results</span></div>";
                        echo "<div class=''>";

                        while ($row = mysqli_fetch_assoc($result)) {

                          $img = htmlspecialchars("media/regimens/{$row["category_name"]}.png");
                          echo "
                          <div class='exercise-row-card'>
                            <div class='exercise-image' style=\"background-image: linear-gradient(135deg,rgba(0, 200, 255, 0.6),rgba(0, 115, 255, 0.6)), url('$img');\"></div>
                            <div class='exercise-content-wrapper'>
                              <div class='exercise-body'>
                                <h2 class='exercise-title'>{$row["course_name"]}</h2>
                                <p class='exercise-notes'>{$row['description']}</p>
                                <div class='exercise-tags'>
                                  <span class='tag difficulty {$row['difficulty']}'>{$row['difficulty']}</span>
                                  <span class='tag xp'>{$row['xp_amount']} xp</span>
                                  <span class='tag category'>{$row['category_name']}</span>
                                </div>
                              </div>
                              <div class='exercise-right'>
                                <a class='select {$row["difficulty"]}' href='viewregimen.php?regimen={$row["course_id"]}'>
                                  <i class='fa fa-play'></i>
                                </a>
                              </div>
                            </div>
                          </div>
                          ";
                        }
                        echo "</div>";
                      }
                      
                    } else {
                      echo "Could not load courses!";
                    }
                    ?>
                
            </div>
          </div>
          
          <div class="side-content">
            <div class="dash-item">
              <h1>Progress</h1>
              <div style="height: 100px;">Overall learning progress here.</div>
            </div>

            <div class="dash-item">
              <h1>Badges</h1>
              <div style="height: 150px;">4 Most Recent Collected Badges Here</div>
            </div>
          </div>
      
      </div>
    </div>
    
  </body>
</html>