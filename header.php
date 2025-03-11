<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();

if(!isset($_SESSION["user_name"])) {
	$_SESSION["user_name"] = '';
	$_SESSION["admin"] = '';
	$_SESSION["first_name"] = '';
	$_SESSION['cart'] = array();
	$_SESSION["redir"] = 'index.php';
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
    <link rel="stylesheet" href="css/header-styles.css">
	<link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    
	<!-- Navigation Bar -->
<div class="navbar">
 <div class="navbar-left">
    <div class="adaptive-navbar">
        <!-- Initially Hidden Hamburger Icon -->
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
        
        
    </div>
 </div>
 <div class="navmain toggle" id="navmain">
        <a class="gradient-text" href="#">Home</a>
        <a class="gradient-text" href="features.php">Features</a>
        <a class="gradient-text" href="about.php">About Us</a>
        <!-- Initially hidden Get Started Button -->
            <?php
                if (empty($_SESSION['username'])) {
                    // show get started
                    echo '<button class="button responsive" onclick="location.href=\'signin.php\';">Get Started</button>';
                }
                else {
                    // Dashboard Button Appears
                    echo '<button class="button" type="button responsive" onclick="location.href=\'dashboard.php\';">Dashboard</button>';
                }  
            ?>
 </div>
<div class="user">
    <?php

    if (empty($_SESSION['username'])) {
        // show sign in button
        echo '<a class="gradient-text" href="login.php">Log In</a>';
        echo '<button class="button" onclick="location.href=\'signup.php\';">Sign Up</button>';
    }
    else {
    // Dashboard Button Appears
    echo '<button class="button" type="button" onclick="location.href=\'dashboard.php\';">Dashboard</button>';
    }  
    ?>
</div>
</div>
</body>
</html>