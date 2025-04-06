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
    <title>Dashboard | Endurify</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/view-styles.css">
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
              <div class="item-header">
                <i class="fa fa-heart gradient-text"></i>
                <h2 class="title">Recent Activity</h2>
              </div>

              <div class='exercise-row-card'>
                  <div class='exercise-content-wrapper'>
                    <div class='exercise-body'>
                      <h2 class='exercise-title' style='color: black;'>Start your first workout or learning adventure to see it here!</h2>
                      <p class='exercise-notes'>Power up your streak, rack up XP, and unlock your fitness potential! Head to the Workouts or Learn page to begin your next challenge.</p>
                      <div class='exercise-tags'>
                        <span class='tag difficulty Beginner'>Choose your difficulty!</span>
                        <span class='tag xp'>Gain XP!</span>
                        <span class='tag category'>Focus on your goals!</span>
                      </div>
                    </div>
                  </div>
                </div>

            </div>

            <div class="dash-item">
              <div class="item-header">
                <i class="fa fa-medal gradient-text"></i>
                <h2 class="title">Challenge Hub</h2>
              </div>
              
              <div class='result-grid'>
              <div class='card'>
                <div class='top' style="background-image: linear-gradient(135deg,rgba(0, 200, 255, 0.6),rgba(0, 115, 255, 0.6)), url('media/regimens/cardio.png');">
                  <div class='info'>
                    <span class='difficulty Beginner'>Beginner</span>
                  </div>
                </div>
                <div class='middle'>
                  <h3>Get Moving!</h3>
                  <span class='description'>Complete any one Cardio exercise or lesson for this week's beginner challenge. It's all about getting your heart rate up and building the habit!</span>
                </div>
                <div class='bottom'>
                    <span class='xp'>200 xp</span>
                </div>
              </div>

              
              <div class='card'>
                <div class='top' style="background-image: linear-gradient(135deg,rgba(0, 200, 255, 0.6),rgba(0, 115, 255, 0.6)), url('media/regimens/core.png');">
                  <div class='info'>
                    <span class='difficulty Intermediate'>Intermediate</span>
                  </div>
                </div>
                <div class='middle'>
                  <h3>Core Commitment</h3>
                  <span class='description'>Complete at least one Core and one Strength exercise or lesson this week. You’re leveling up with more control, stability, and power!</span>
                </div>
                <div class='bottom'>
                    <span class='xp'>400 xp</span>
                </div>
              </div>

              
              <div class='card'>
                <div class='top' style="background-image: linear-gradient(135deg,rgba(0, 200, 255, 0.6),rgba(0, 115, 255, 0.6)), url('media/regimens/balance.png');">
                  <div class='info'>
                    <span class='difficulty Advanced'>Advanced</span>
                  </div>
                </div>
                <div class='middle'>
                  <h3>Full Body Focus</h3>
                  <span class='description'>Complete one exercise or lesson each from Strength, Mobility, and Flexibility categories. Test your balance of force, movement, and recovery!</span>
                </div>
                <div class='bottom'>
                    <span class='xp'>600 xp</span>
                </div>
              </div>

              </div>
            </div>


            <div class="dash-item">
              <div class="item-header">
                <i class="fa fa-users gradient-text"></i>
                <h2 class="title">Community Feed</h2>
              </div>
              
              <a href="viewregimen.php?regimen=3">
                <div class='exercise-row-card'>
                  <div class='exercise-image' style="background-image: linear-gradient(135deg,rgba(0, 200, 255, 0.6),rgba(0, 115, 255, 0.6)), url('media/regimens/strength.png');"></div>
                  <div class='exercise-content-wrapper'>
                    <div class='exercise-body'>
                      <h2 class='exercise-title' style='color: black;'>Emerson C. finished a workout: Leg Strength Builder</h2>
                      <p class='exercise-notes'>A lower-body program focused on building power, endurance, and functional strength.</p>
                      <div class='exercise-tags'>
                        <span class='tag difficulty Advanced'>Advanced</span>
                        <span class='tag xp'>200 xp</span>
                        <span class='tag category'>Strength</span>
                      </div>
                    </div>
                  </div>
                </div>
              </a>

              <a href="viewcourse.php?course=26">
                <div class='exercise-row-card'>
                  <div class='exercise-image' style="background-image: linear-gradient(135deg,rgba(0, 200, 255, 0.6),rgba(0, 115, 255, 0.6)), url('media/regimens/cardio.png');"></div>
                  <div class='exercise-content-wrapper'>
                    <div class='exercise-body'>
                      <h2 class='exercise-title' style='color: black;'>Nate T. completed a course: Foundations of Cardio Fitness</h2>
                      <p class='exercise-notes'>Explore low-impact cardio methods to improve endurance.</p>
                      <div class='exercise-tags'>
                        <span class='tag difficulty Beginner'>Beginner</span>
                        <span class='tag xp'>200 xp</span>
                        <span class='tag category'>Cardio</span>
                      </div>
                    </div>
                  </div>
                </div>
              </a>

              <a href="viewregimen.php?regimen=5">
                <div class='exercise-row-card'>
                  <div class='exercise-image' style="background-image: linear-gradient(135deg,rgba(0, 200, 255, 0.6),rgba(0, 115, 255, 0.6)), url('media/regimens/core.png');"></div>
                  <div class='exercise-content-wrapper'>
                    <div class='exercise-body'>
                      <h2 class='exercise-title' style='color: black;'>Colin M. finished a workout: Core Stability Flow</h2>
                      <p class='exercise-notes'>Mid-level exercises designed to challenge your balance and strengthen deep core muscles.</p>
                      <div class='exercise-tags'>
                        <span class='tag difficulty Intermediate'>Intermediate</span>
                        <span class='tag xp'>150 xp</span>
                        <span class='tag category'>Cardio</span>
                      </div>
                    </div>
                  </div>
                </div>
              </a>

              <a href="viewcourse.php?course=33">
                <div class='exercise-row-card'>
                  <div class='exercise-image' style="background-image: linear-gradient(135deg,rgba(0, 200, 255, 0.6),rgba(0, 115, 255, 0.6)), url('media/regimens/balance.png');"></div>
                  <div class='exercise-content-wrapper'>
                    <div class='exercise-body'>
                      <h2 class='exercise-title' style='color: black;'>Nate M. completed a course: Mastering Stability</h2>
                      <p class='exercise-notes'>Challenge your body with single-leg and unstable-surface work.</p>
                      <div class='exercise-tags'>
                        <span class='tag difficulty Advanced'>Advanced</span>
                        <span class='tag xp'>400 xp</span>
                        <span class='tag category'>Strength</span>
                      </div>
                    </div>
                  </div>
                </div>
              </a>




            </div>

            
          </div>
          
          <div class="side-content">
            <div class="dash-item profile">
              <?php include('shared/profile-overview.php'); ?>
            </div>

            <div class="dash-item work-in-progress">
              <div class="item-header">
                <i class="fa fa-chart-simple gradient-text"></i>
                <h2 class="title">Weekly Leaderboard</h2>
              </div>
              
              <div class="leaderboard-module">
                <ul class="leaderboard-list">
                  <li class="leaderboard-item">
                    <i class="fa fa-award gold"></i>
                    <span class="user-badge gold">S</span>
                    <div class="user-info">
                      <strong>Nate T.</strong>
                      <span>Level 12</span>
                    </div>
                    <span class="user-xp">1250 xp</span>
                  </li>
                  <li class="leaderboard-item">
                    <i class="fa fa-award silver"></i>
                    <span class="user-badge silver">M</span>
                    <div class="user-info">
                      <strong>Colin M.</strong>
                      <span>Level 7</span>
                    </div>
                    <span class="user-xp">1120 xp</span>
                  </li>
                  <li class="leaderboard-item">
                    <i class="fa fa-award bronze"></i>
                    <span class="user-badge bronze">A</span>
                    <div class="user-info">
                      <strong>Emerson C.</strong>
                      <span>Level 9</span>
                    </div>
                    <span class="user-xp">980 xp</span>
                  </li>
                  <li class="leaderboard-item">
                  <i class="fa fa-award blue"></i>
                    <span class="user-badge blue">E</span>
                    <div class="user-info">
                      <strong>Nate M.</strong>
                      <span>Level 6</span>
                    </div>
                    <span class="user-xp">850 xp</span>
                  </li>
                </ul>
              </div>



            </div>

            <div class="dash-item" id="reward">
              <div class="item-header">
                <i class="fa fa-gift gradient-text"></i>
                <h2 class="title">Daily Reward</h2>
              </div>

              <div class="daily-reward-container">
                <div class="daily-reward-icon">75 XP</div>

                <form action="handle/daily_reward_handle.php" method="post">
                  <input type="hidden" name="amount" value="75">
                  <button class="button" <?= (isset($_GET["status"]) && $_GET["status"] === 'success') ? 'disabled' : '' ?> type="submit"><?= (isset($_GET["status"]) && $_GET["status"] === 'success') ? 'Collected' : 'Collect' ?></button>
                </form>
              </div>
            </div>
          </div>
      
      </div>
    </div>
    
  </body>
</html>