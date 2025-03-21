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

    <!-- Dashboard Content -->
    <div class="dash-row">
      <!-- Right Side Content -->
      <div class="side-content compressable compressed">
        <div class="profile">
            <h2>Welcome, <?php echo $_SESSION['first_name']; ?>!</h2>
        </div>

        <div class="learn" style="height: 700px;">
          <h2>In Progress Courses</h2>
        </div>
      </div>
    <!-- Main Content -->
      <div id="calendar" class="calendar compressable compressed">
        <?php 
          $currentPage = "learn";
          include('shared/calendar.php'); 
        ?>
      </div>

      <div class="main-content compressable compressed">
        <h1>Explore Courses</h1>
        <div style="height: 1500px;">This is a long block to test scrolling.</div>
      </div>

     
    </div>
  </body>
</html>