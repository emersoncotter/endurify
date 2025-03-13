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

    <!-- Header -->
    <div class="header">
      <h1>My Website</h1>
      <p>With a <b>flexible</b> layout.</p>
    </div>

    <!-- The flexible grid (content) -->
    <div class="row">
      <div class="side">
        <h2>About Me</h2>
        <h5>Photo of me:</h5>
        <div class="fakeimg" style="height:200px;">Image</div>
        <p>Some text about me in culpa qui officia deserunt mollit anim..</p>
        <h3>More Text</h3>
        <p>Lorem ipsum dolor sit ame.</p>
        <div class="fakeimg" style="height:60px;">Image</div><br>
        <div class="fakeimg" style="height:60px;">Image</div><br>
        <div class="fakeimg" style="height:60px;">Image</div>
      </div>
      <div class="main">
        <h2>TITLE HEADING</h2>
        <h5>Title description, Dec 7, 2024</h5>
        <div class="fakeimg" style="height:200px;">Image</div>
        <p>Some text..</p>
        <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
        <br>
        <h2>TITLE HEADING</h2>
        <h5>Title description, Sep 2, 2024</h5>
        <div class="fakeimg" style="height:200px;">Image</div>
        <p>Some text..</p>
        <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
      </div>
    </div>

    <!-- Footer -->
    <div class="footer">
      <h2>Footer</h2>
    </div>

  </body>
</html>


