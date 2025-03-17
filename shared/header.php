<?php
    if(session_status() !== PHP_SESSION_ACTIVE) session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Inria Sans' rel='stylesheet'>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/header-styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    
<!-- Navigation Bar -->
<div class="navbar">
 <!-- Logo and condensed portion of navbar -->
    <div class="navbar-left">
        <!-- condensed adaptive portion of navbar -->
        <div class="adaptive-navbar">
            <!-- Initially Hidden Hamburger Icon ☰ -->
            <div class="adaptive-left">
                <a href="javascript:void(0);" class="gradient-text responsive" onclick="toggleMenu()">
                    <i class="gradient-text fa fa-bars"></i>
                </a>
                
                <script>
                    function toggleMenu() {
                        var x = document.getElementById("navmain");
                        x.classList.toggle("toggle");
                    }
                </script>
            </div>

            <!-- Always Visible Logo -->
            <div class="adaptive-middle">
                <a href="index.php">
                    <img src="media/logo.png" alt="Endurify Logo">
                </a>
            </div>
            
            <!-- Initially Hidden Login Icon -->
            <div class="adaptive-right">
                <a href="login.php" class="icon gradient-text responsive">
                    <i class="gradient-text fa fa-user"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- Main navigation links of navbar -->
    <div class="navmain toggle" id="navmain">
        <!-- Page Navigation -->
        <a class="gradient-text <?php if(isset($currentPage) && $currentPage == "home"){echo 'current';} else {echo 'hover-underline-animation';};?>" href="#">Home</a>
        <a class="gradient-text <?php if(isset($currentPage) && $currentPage == "features"){echo 'current';} else {echo 'hover-underline-animation';};?>" href="features.php">Features</a>
        <a class="gradient-text <?php if(isset($currentPage) && $currentPage == "about"){echo 'current';} else {echo 'hover-underline-animation';};?>" href="about.php">About Us</a>
        <!-- Initially hidden Get Started Button -->
        <?php
            if (empty($_SESSION['username'])) {
                // show get started
                echo '<button class="button responsive" onclick="location.href=\'login.php\';">Get Started</button>';
            } else {
                // Dashboard Button Appears
                echo '<button class="button responsive" type="button responsive" onclick="location.href=\'dashboard.php\';">Dashboard</button>';
            }  
        ?>
    </div>
    <!-- Login / Sign Up / Dashboard portion of navbar -->
    <div class="navbar-right">
        <?php

        if (empty($_SESSION['username'])) {
            // show sign in button
            echo '<a class="gradient-text hover-underline-animation left" href="login.php">Log In</a>';
            echo '<button class="button" onclick="location.href=\'signup.php\';">Sign Up</button>';
        } else {
        // Dashboard Button Appears
        echo '<a class="gradient-text hover-underline-animation left" href="signout_handle.php">Sign Out</a>';
        echo '<button class="button" type="button" onclick="location.href=\'dashboard.php\';">Dashboard</button>';
        }  
        ?>
    </div>
</div>
</body>
</html>