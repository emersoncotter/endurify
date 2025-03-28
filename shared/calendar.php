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
            echo "<a class='arrow left' href='".$currentPage.".php?reldate=".($startday-5)."#calendar'><i class='fa-solid fa-chevron-left'></i></a>";
            echo "<h2>".date("F", $month)."</h2>";
            echo "<a class='arrow right' href='".$currentPage.".php?reldate=".($startday+5)."#calendar'><i class='fa-solid fa-chevron-right'></i></a>";
            
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
              echo "<div class='".$class."'><a href='".$currentPage.".php?reldate=".$offset."#calendar'>".
                      "<div class='date'>".date("D", $day)."</div>".
                      "<div class='date'>".date("d", $day)."</div>".
                    "</a></div>";
            }
          ?>

          <style>
            .calendar {
    background: rgba(245,245,245,.7);
    height: 100px;
    width: 100%;
    /* max-width: 1250px; */
    margin: 10px 445px 0px 350px;
    padding: 10px 15px;
    border-radius: 20px;
    display: flex;
    flex-wrap: wrap;
    gap: 1%;
    justify-content: center;
}

    .calendar h2 {
        width: 33%;
        text-align: center;
        align-content: center;
        height: 40%;
        margin: 0px;
        font-size: 22px;
        /* align-content: center; */
    }

    .calendar a.arrow {
        width: 25%;
        height: 40%;
        margin: 0px;
        font-size: 14px;
        align-content: center;
    }

        .calendar .right {
            text-align: left;
        }

        .calendar .left {
            text-align: right;
        }

    .calendar .day {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 19%; 
        height: 60%;
        border-radius: 5px;
        text-align: center;
        font-size: 16px;
        background: #F5F5F5;
        padding: 12px;
    }

    .calendar a {
        inset: 0;
        background: none;
        text-decoration: none;
        color: black;
        width: 100%;
    }

    .calendar .active-streak a {
        color: #F5F5F5;
    }

    .calendar .active-streak {
        background: linear-gradient(to left, #30E3CA,#30C4DB,#2fade894);        
    }

    .calendar .selected.active-streak {
        border: rgba(245,245,245,.8) solid 3px;
        font-weight: bold;
    }

    .calendar .selected {
        border: rgba(48,196,219,.7) solid 3px;
        font-weight: bold;
    }
          </style>