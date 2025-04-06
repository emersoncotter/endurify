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
    <title>Profile | Endurify</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  </head>
  
  <body class="background-gradient">
    <!-- Left Sidebar -->
    <div>
      <?php 
        $currentPage = "profile";
        include('shared/sidebar.php'); 
        ?>
    </div>
    
    <!-- Dashboard -->
    <div class="dashboard-container">
      <!-- Main Header -->
      <div class="dash-header">
        <?php 
        $title = 'Your Profile';

        $subtitle = "Welcome back, ".$_SESSION['first_name']."!";
        include('shared/dashboard-header.php'); 
        ?>
      </div>
    
    <!-- Dashboard Content -->
      <div class="dash-content">        
          <!-- Main Content -->
          <div class="main-content">
            <div class="dash-item">
              <div class="item-header">
                <i class="fa fa-user gradient-text"></i>
                <h2 class="title">Account Information</h2>
              </div>
              <div style="height: 1000px;">Profile Information Here</div>
            </div>
          </div>
          
          <div class="side-content">
            <div class="dash-item profile">
              <?php include('shared/profile-overview.php'); ?>
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
    
  </body>
</html>