<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Endurify</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>

  <body class="background-gradient">
    <?php 
      $currentPage = "home";
      include('shared/header.php'); 
    ?>

    <!-- Main Content -->
    <div class="main">
      <img src="media/dumbbell.png" class="background-blur" />
      
      <div class="item">
        <h1>Gamify Your <br> Fitness Journey</h1>
      </div>
      <div class="item">
        <p>Track your workouts, earn acheivements, and level up your fitness with our gamified workout platform.</p>
      </div>
      <div class="item">
          <a class="button" href="signup.php">Get Started</a>
      </div>
    </div>

 

  </body>
</html>


