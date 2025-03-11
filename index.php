<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Endurify</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/styles.css">
<style>

</style>
</head>
<body class="background-gradient">

<!-- Navigation Bar
<div class="navbar">
 <div class="logo">
    <img src="media/logo.png" alt="Endurify Logo">
 </div>
 <div class="navmain">
    <div class="gradient-text">
        <a href="#">Home</a>
        <a href="features.php">Features</a>
        <a href="about.php">About Us</a>
    </div>
 </div>
<div class="user">
    <?php

    if (empty($_SESSION['username'])) {
        // show sign in button
        echo '<a class="gradient-text" href="login.php">Log In</a>';
        echo '<button class="button" onclick="location.href=\'signup.php\';">Sign Up</button>';
    }
    else {
    // welcome user
    echo "<p>Welcome back, ".$_SESSION['first_name']."!</p>";

    if($_SESSION['admin'] == 1) {
    // show admin page button if administrator
    echo '<button class="button" type="button" onclick="location.href=\'admin.php\';">Admin</button>';
    } else {
    // show cart button if normal user
        if(count($_SESSION['cart']) > 0) {
            echo '<button class="button" type="button" onclick="location.href=\'cart.php\';">Cart ('.count($_SESSION['cart']).')</button>';
        } else {
            echo '<button class="button" type="button" onclick="location.href=\'cart.php\';">Cart</button>';
        }
    }

    // show log out button
    echo '<button class="button" type="button" onclick="location.href=\'logout.php\';">Log Out</button>';



    }  
    ?>
</div>
  
 
</div> -->

<?php include('header.php'); ?>

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


