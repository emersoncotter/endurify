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
    <link rel="stylesheet" href="css/sidebar-styles.css">
    <link rel="stylesheet" href="css/dashboard-styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    
<!-- Sidebar -->
    <div class="sidebar sidebar-responsive visible">
        <!-- Logo -->
        <a class="" href="index.php">
            <img src="media/logo.png" alt="Endurify Logo">
        </a>
        
        <!-- Page Navigation -->
        <div class="sidebar-container">
            <div class="sidebar-row responsive">
                <div class="sidebar-column">
                    <a href="javascript:void(0);" class="responsive" onclick="toggleMenu()">
                        <i class="gradient-text fa fa-arrow-right sidebar-responsive"></i>
                        <i class="gradient-text fa fa-arrow-left sidebar-responsive visible"></i>
                    </a>
                </div>
                <div class="sidebar-column sidebar-responsive visible">
                    <a class="gradient-text" href="javascript:void(0);" onclick="toggleMenu()">
                        <span>Collapse</span>
                    </a>
                </div>
            </div>
            <div class="sidebar-row">
                <div class="sidebar-column">
                    <a href="dashboard.php"><i class="gradient-text fa fa-house"></i></a>
                </div>
                <div class="sidebar-column sidebar-responsive visible">
                    <a class="gradient-text <?php if(isset($currentPage) && $currentPage == 'dashboard'){echo 'current';} else {echo 'hover-underline-animation';};?>" href="dashboard.php">
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>

            <div class="sidebar-row">
                <div class="sidebar-column">
                    <a href="dashboard/workouts.php"><i class="gradient-text fa fa-dumbbell"></i></a>
                </div>
                <div class="sidebar-column sidebar-responsive visible">
                    <a class="gradient-text <?php if(isset($currentPage) && $currentPage == 'workouts'){echo 'current';} else {echo 'hover-underline-animation';};?>" href="dashboard/workouts.php">
                        <span>Workouts</span>
                    </a>
                </div>
            </div>

            <div class="sidebar-row">
                <div class="sidebar-column">
                    <a href="dashboard/learn.php"><i class="gradient-text fa fa-graduation-cap"></i></a>
                </div>
                <div class="sidebar-column sidebar-responsive visible">
                    <a class="gradient-text <?php if(isset($currentPage) && $currentPage == 'learn'){echo 'current';} else {echo 'hover-underline-animation';};?>" href="dashboard/learn.php">
                        <span>Learn</span>
                    </a>
                </div>
            </div>

            <div class="sidebar-row">
                <div class="sidebar-column">
                    <a href="dashboard/profile.php"><i class="gradient-text fa fa-user"></i></a>
                </div>
                <div class="sidebar-column sidebar-responsive visible">
                    <a class="gradient-text <?php if(isset($currentPage) && $currentPage == 'profile'){echo 'current';} else {echo 'hover-underline-animation';};?>" href="dashboard/profile.php">
                        <span>Profile</span>
                    </a>
                </div>
            </div>

            <div class="sidebar-row">
                <div class="sidebar-column">
                    <a href="dashboard/settings.php"><i class="gradient-text fa fa-gear"></i></a>
                </div>
                <div class="sidebar-column sidebar-responsive visible">
                    <a class="gradient-text <?php if(isset($currentPage) && $currentPage == 'settings'){echo 'current';} else {echo 'hover-underline-animation';};?>" href="dashboard/settings.php">
                        <span>Settings</span>
                    </a>
                </div>
            </div>
    </div>

    <script>
        function toggleMenu() {
            var elements = document.querySelectorAll(".sidebar-responsive"); // Select all elements with class "toggle"
            
            elements.forEach(function(element) {
                element.classList.toggle("visible"); // visible a "visible" class
            });

            var elements = document.querySelectorAll(".compressable"); // Select all elements with class "toggle"
            
            elements.forEach(function(element) {
                element.classList.toggle("compressed"); // visible a "visible" class
            });
}
    </script>
</body>
</html>