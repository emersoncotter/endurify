<?php 
            // Variable Setup
            $streak = strtotime($_SESSION["streak_start_date"]);
            $today = strtotime("today");
            $tomorrow = strtotime("tomorrow");
            
            // Get Current Day Logic
            if(isset($_GET["reldate"])) {
              $startday = $_GET["reldate"];
            } else {
              $startday = 0;
            }
            
            // Month Display & Navigation
            $month = strtotime($startday." day");
            echo "<a class='arrow left' href='".$currentPage.".php?reldate=".($startday-5)."'><i class='fa-solid fa-chevron-left'></i></a>";
            echo "<h2>".date("F", $month)."</h2>";
            echo "<a class='arrow right' href='".$currentPage.".php?reldate=".($startday+5)."'><i class='fa-solid fa-chevron-right'></i></a>";
            
            // Day display logic
            for($offset = ($startday - 2); $offset < ($startday + 3); $offset++) {
              $class = "day";
              $day = strtotime($offset." day");

              // highlight past dates with active streak
              if($day >= $streak && $day < $tomorrow) {
                $class = $class." active-streak";
              } 
              // highlight selected day
              if ($offset == $startday) {
                $class = $class." selected";
              } 

              // Print Weekday and Date
              echo "<div class='".$class."'><a href='".$currentPage.".php?reldate=".$offset."'>".
                      "<div class='date'>".date("D", $day)."</div>".
                      "<div class='date'>".date("d", $day)."</div>".
                    "</a></div>";
            }
          ?>