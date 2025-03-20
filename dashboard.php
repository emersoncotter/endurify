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
    <title>Endurify</title>
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

    <!-- Dashboard Content -->
    <div class="dash-row">
      <!-- Right Side Content -->
      <div class="side-content compressable compressed">
        <div class="profile">
            <h2>Welcome, <?php echo $_SESSION['first_name']; ?>!</h2>
        </div>

        <div class="summary">
          <h2>Progress Summary</h2>
        </div>

        <div class="quest">
          <h2>Daily Quest</h2>
        </div>
      </div>
    <!-- Main Content -->
      <div class="calendar compressable compressed">
          <?php 
          // Variable Setup
          $streak = strtotime($_SESSION["streak_start_date"]);
          $today = strtotime("today");
          $tomorrow = strtotime("tomorrow");
          
          // Get Current Day Logic
          if(isset($_GET["reldate"])) {
            $startday = $_GET["reldate"];
          } else {
            $startday = 0;
          }
          
          // Month Display & Navigation
          $month = strtotime($startday." day");
          echo "<a class='arrow left' href='dashboard.php?reldate=".($startday-5)."'><i class='fa-solid fa-chevron-left'></i></a>";
          echo "<h2>".date("F", $month)."</h2>";
          echo "<a class='arrow right' href='dashboard.php?reldate=".($startday+5)."'><i class='fa-solid fa-chevron-right'></i></a>";
          
          // Day display logic
          for($offset = ($startday - 2); $offset < ($startday + 3); $offset++) {
            $class = "day";
            $day = strtotime($offset." day");

            // highlight past dats with active streak
            if($day >= $streak && $day < $tomorrow) {
              $class = $class." active-streak";
            } 
            // highlight selected day
            if ($offset == $startday) {
              $class = $class." selected";
            } 

            echo "<div class='".$class."'><a href='dashboard.php?reldate=".$offset."'>".
                    "<div class='date'>".date("D", $day)."</div>".
                    "<div class='date'>".date("d", $day)."</div>".
                  "</a></div>";
          }


          
          
          
          
          ?>



      </div>

      <div class="main-content compressable compressed">
        <h1>Main Content</h1>
        <i class='fa-solid fa-chevron-left'></i>
        <i class='fa-solid fa-chevron-right'></i>
        <p>Scroll me if content overflows...</p>
        <div style="height: 1500px;">This is a long block to test scrolling.</div>
      </div>

     
    </div>
  </body>
</html>