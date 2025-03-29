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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inria+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/sidebar-styles.css">
    <link rel="stylesheet" href="css/dashboard-styles.css">
    <link rel="stylesheet" href="css/dashboard-module-styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    
<!-- Sidebar -->
    <div class="sidebar sidebar-responsive visible">
        <div class="sidebar-top">
            <!-- Logo -->
            <a class="" href="index.php">
                <img src="media/logo.png" alt="Endurify Logo">
            </a>
                
            <!-- Page Navigation -->
            <div class="sidebar-container">
                <div class="sidebar-row <?php if(isset($currentPage) && $currentPage == 'dashboard'){echo 'current';} else {echo 'hover';};?>">
                    <div class="background">
                        <div class="sidebar-column">
                            <a href="dashboard.php"><i class="<?php if(isset($currentPage) && $currentPage != 'dashboard'){echo 'gradient-text';}?> fas fa-table-columns"></i></a>
                        </div>
                        <div class="sidebar-column sidebar-responsive visible">
                            <a href="dashboard.php">
                                <span>Dashboard</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="sidebar-row <?php if(isset($currentPage) && $currentPage == 'workouts'){echo 'current';} else {echo 'hover';};?>">
                    <div class="background">
                        <div class="sidebar-column">
                            <a href="workouts.php"><i class="<?php if(isset($currentPage) && $currentPage != 'workouts'){echo 'gradient-text';}?> fa fa-dumbbell fa-rotate-by" style="--fa-rotate-angle: 315deg;"></i></a>
                        </div>
                        <div class="sidebar-column sidebar-responsive visible">
                            <a href="workouts.php">
                                <span>Workouts</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="sidebar-row <?php if(isset($currentPage) && $currentPage == 'learn'){echo 'current';} else {echo 'hover';};?>">
                    <div class="background">
                        <div class="sidebar-column">
                            <a href="learn.php"><i class="<?php if(isset($currentPage) && $currentPage != 'learn'){echo 'gradient-text';}?> fa fa-graduation-cap"></i></a>
                        </div>
                        <div class="sidebar-column sidebar-responsive visible">
                            <a href="learn.php">
                                <span>Learn</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="sidebar-row <?php if(isset($currentPage) && $currentPage == 'profile'){echo 'current';} else {echo 'hover';};?>">
                    <div class="background">
                        <div class="sidebar-column">
                            <a href="profile.php"><i class="<?php if(isset($currentPage) && $currentPage != 'profile'){echo 'gradient-text';}?> fa fa-user"></i></i></a>
                        </div>
                        <div class="sidebar-column sidebar-responsive visible">
                            <a href="profile.php">
                                <span>Profile</span>
                            </a>
                        </div>
                    </div>
                </div>

                <?php

                if(isset($currentPage) && $currentPage == 'admin'){
                    $class = 'current';
                    $gradient = '';
                } else {
                    $class = 'hover';
                    $gradient = 'gradient-text';
                }

                if ($_SESSION["role"] === "admin") {
                    echo 
                        "<div class='sidebar-row $class'>
                            <div class='background'>
                                <div class='sidebar-column'>
                                    <a href='admin.php'><i class='$gradient fa fa-shield-halved'></i></a>
                                </div>
                                <div class='sidebar-column sidebar-responsive visible'>
                                    <a href='admin.php'>
                                        <span>Admin</span>
                                    </a>
                                </div>
                            </div>
                        </div>";
                        }
                ?>
                
                <div class="sidebar-row mobile-visible">
                    <div class="sidebar-column">
                        <a href="handle/signout_handle.php"><i class="gradient-text fa fa-arrow-right-from-bracket"></i></a>
                    </div>
                    <div class="sidebar-column sidebar-responsive visible">
                        
                        </a>
                    </div>
                </div>

            </div>          
        </div>
        
        <div class="sidebar-bottom mobile-hidden">
            <div class="sidebar-container">

                    <div class="sidebar-row hover">
                        <div class="background">
                            <div class="sidebar-column">
                                <a href="handle/signout_handle.php"><i class="gradient-text fa fa-arrow-right-from-bracket"></i></a>
                            </div>
                            <div class="sidebar-column sidebar-responsive visible">
                                <a href="handle/signout_handle.php">
                                    <span>Sign Out</span>
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="sidebar-row responsive">
                        <div class="sidebar-column">
                            <a href="javascript:void(0);" class="responsive" onclick="toggleMenu()">
                                <i class="gradient-text fa fa-chevron-right sidebar-responsive"></i>
                                <i class="gradient-text fa fa-chevron-left sidebar-responsive visible"></i>
                            </a>
                    </div>
                </div>
            </div>
            
        </div>

    </div>

    <script>
        function toggleMenu() {
            var elements = document.querySelectorAll(".sidebar-responsive"); // Select all elements with class "toggle"
            
            elements.forEach(function(element) {
                element.classList.toggle("visible"); // visible a "visible" class
            });

            var elements = document.querySelectorAll(".dashboard-container"); // Select all elements with class "toggle"
            
            elements.forEach(function(element) {
                element.classList.toggle("compressed"); // visible a "visible" class
            });
}
    </script>
</body>
</html>