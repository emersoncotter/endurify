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
    <title>Endurify | Workouts</title>
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

        $subtitle = $Subtitles[array_rand($Subtitles,1)];

        $subtitle = $subtitle." ".$_SESSION['first_name']."!";
        include('shared/dashboard-header.php'); 
        ?>
      </div>
    
    <!-- Dashboard Content -->
      <div class="dash-content">        
          <!-- Main Content -->
          <div class="main-content">
            <div class="dash-item">
              <h1>Browse by Category</h1>
              <div style="height: 1000px;">Workouts by Category Here</div>
            </div>
          </div>
          
          <div class="side-content">
            <div class="dash-item">
              <h1>Routines</h1>
              <div style="height: 500px;">Custom routines here.</div>
            </div>

            <div class="dash-item">
              <h1>Badges</h1>
              <div style="height: 350px;">4 Most Recent Collected Badges Here</div>
            </div>
          </div>
      
      </div>
    </div>
    
  </body>
</html>