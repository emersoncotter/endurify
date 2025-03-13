<?php
    if(session_status() !== PHP_SESSION_ACTIVE) session_start();

    if(!isset($_SESSION["user_name"])) {
        $_SESSION["user_name"] = '';
        $_SESSION["first_name"] = '';
        $_SESSION['last_name'] = '';
        }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
    <link rel="stylesheet" href="css/header-styles.css">
	<link rel="stylesheet" href="css/styles.css">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

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
                <a href="javascript:void(0);" class="icon gradient-text responsive" onclick="toggleMenu()">
                    <i class="fa fa-bars"></i>
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
                <img src="media/logo.png" alt="Endurify Logo">
            </div>
            
            <!-- Initially Hidden Login Icon -->
            <div class="adaptive-right">
                <a href="login.php" class="icon gradient-text responsive">
                    <i class="fa fa-user"></i>
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
                echo '<button class="button" type="button responsive" onclick="location.href=\'dashboard.php\';">Dashboard</button>';
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
        echo '<button class="button" type="button" onclick="location.href=\'dashboard.php\';">Dashboard</button>';
        }  
        ?>
    </div>
</div>
</body>
</html>