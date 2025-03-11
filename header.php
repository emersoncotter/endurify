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
	<link rel="stylesheet" href="css/styles.css">
</head>
<body>
	<!-- Navigation Bar -->
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
  
 
</div>
</body>
</html>