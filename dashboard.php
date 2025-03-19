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
    <div class="">
        <?php 
        $currentPage = "dashboard";
        include('shared/sidebar.php'); 
        ?>
    </div>
    <div class="dash-row">
      <div class="side-content compressable compressed">
        <div class="profile">
            <h2>Welcome, User</h2>
        </div>

        <div class="summary">
          <h2>Progress Summary</h2>
        </div>

        <div class="quest">
          <h2>Daily Quest</h2>
        </div>
      </div>

      <div class="calendar compressable compressed">
          <h2>Calendar</h2>
      </div>

      <div class="main-content compressable compressed">
        <h1>Main Content</h1>
        <p>Scroll me if content overflows...</p>
        <div style="height: 1500px;">This is a long block to test scrolling.</div>
      </div>

     
    </div>
  </body>
</html>