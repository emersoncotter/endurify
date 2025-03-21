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
      <div id="calendar" class="calendar compressable compressed">
      <?php 
          $currentPage = "dashboard";
          include('shared/calendar.php'); 
        ?>
      </div>

      <div class="main-content compressable compressed">
        <h1>Main Content</h1>
        <div style="height: 1500px;">This is a long block to test scrolling.</div>
      </div>

     
    </div>
  </body>
</html>