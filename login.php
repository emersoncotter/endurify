<?php
session_start();

// redirect to home page if already logged in
if(isset($_SESSION['username'])) {
	if($_SESSION['username'] != '') {
		header("Location: dashboard.php");
	}
}

?>

