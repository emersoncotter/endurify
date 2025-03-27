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
      <img src="media/background.jpg" class="background-blur" />

      <h1>Gamify Your <br> Fitness Journey</h1>

      <p>Track your workouts, earn achievements, and level up your 
      fitness with our gamified workout platform.</p>

      <a class="button" href="login.php">Get Started</a>
    </div>

 

  </body>
</html>


