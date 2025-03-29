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
            <div class="dash-item profile">
            <a href="profile.php">
              <div class="profile-icon">
                <?php 
                    $initial = $_SESSION['first_name'][0].$_SESSION['last_name'][0];
                    echo $initial;
                ?>
              </div>
            </a>
            <div class="spacer"></div>
            <div class="content">
              <?php 
              $name = $_SESSION['first_name']." ".$_SESSION['last_name'];
              echo "<h1>$name</h1>";
              ?>

              <div class="badge-container">
                <div class="badge badge-green">
                  <i class="fa fa-fire"></i>
                  <span>Level <?php echo '7' // TODO: pull level here ?></span>
                </div>
                <div class="badge badge-blue">
                  <i class="fa fa-trophy"></i>
                  <span><?php echo '5' // TODO: pull streak weeks here ?> Week Streak</span>
                </div>
              </div>

              <div class="xp-container">
                <div class="xp-header">
                  <span class="xp-label">XP Progress</span>
                  <span class="xp-needed"><span class="xp-earned"><?php echo '650' // TODO: xp earned here ?></span> / <?php echo '1000' // TODO: pull xp total here ?></span>
                </div>
                <div class="xp-bar">
                  <div class="xp-fill" style="width: <?php echo '65' // TODO: level percentage here ?>%;"></div>
                </div>
              </div>

            </div>


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