<?php
// Redirect user if not logged in
session_start();
if (empty($_SESSION['username'])) { 
    header("Location: login.php");    
    exit();
    } 
  
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Endurify | Learn</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
              <h1>Featured Courses</h1>
              <div style="height: 200px;">Featured Courses Here.</div>
            </div>

            <div class="dash-item">
              <h1>Browse Courses</h1>
              <div style="height: 550px;">Browse Courses Here.</div>
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