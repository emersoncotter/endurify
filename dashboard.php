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
    <title>Endurify | Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  </head>
  
  <body class="background-gradient">
    <!-- Left Sidebar -->
    <div>
      <?php 
        $currentPage = "dashboard";
        include('shared/sidebar.php'); 
        ?>
    </div>
    
    <!-- Dashboard -->
    <div class="dashboard-container">
      <!-- Main Header -->
      <div class="dash-header">
        <?php 
        $title = 'Dashboard';
        $subtitle = "Welcome back, ".$_SESSION['first_name']."!";
        include('shared/dashboard-header.php'); 
        ?>
      </div>
    
    <!-- Dashboard Content -->
      <div class="dash-content">        
          <!-- Main Content -->
          <div class="main-content">
            <div class="dash-item">
              <h1>Activity Feed</h1>
              <div style="height: 450px;">Activity Feed Content Here.</div>
            </div>

            <div class="dash-item">
              <h1>Challenge Hub</h1>
              <div style="height: 450px;">Challenge Hub Content Here.</div>
            </div>
          </div>
          
          <div class="side-content">
            <div class="dash-item">
              <h1>Progress Summary</h1>
              <div style="height: 150px;">This is a long block to test scrolling.</div>
            </div>

            <div class="dash-item">
              <h1>Leaderboard</h1>
              <div style="height: 100px;">This is a long block to test scrolling.</div>
            </div>

            <div class="dash-item">
              <h1>Daily Reward</h1>
              <div style="height: 100px;">This is a long block to test scrolling.</div>
            </div>
          </div>
      
      </div>
    </div>
    
  </body>
</html>