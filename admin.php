<?php
session_start();

if (empty($_SESSION['username']) || $_SESSION['role'] != "admin") {
    // redirect user to the login page
    header("Location: login.php");
    
    // terminate the current script
    exit();
    } 

include('handle/mysqli_connect.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Endurify | Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/form-styles.css">
  </head>

  <body class="background-gradient">
    <!-- Left Sidebar -->
    <div>
        <?php 
        $currentPage = "admin";
        include('shared/sidebar.php'); 
        ?>
    </div>

    <!-- Dashboard Content -->
    <div class="dash-row">
      <!-- Right Side Content -->
      <div class="side-content compressable compressed">
        <div class="profile">
            <h2>Welcome, <?php echo $_SESSION['first_name']; ?>!</h2>
        </div>

        <div class="learn" style="height: 700px;">
          <h2>Database Statistics</h2>
        </div>
      </div>
    <!-- Main Content -->
      <div class="calendar header compressable compressed">
        <h1>Administrator Dashboard</h1>
      </div>

      <div class="main-content compressable compressed">
          <form class="adminForm" id="exerciseForm" action="handle/admin_handle.php" method="post">
              <h2>Add New Exercise</h2>
              <?php if(isset($_GET["status"]) && $_GET["status"] === 'error') { echo '<span class="error-message invalid-message" style="display:block; text-align:left;">An unknown exception has occured. Please try again.</span>';}?>
              <?php if(isset($_GET["status"]) && $_GET["status"] === 'success') { echo '<span class="error-message invalid-message" style="display: block; text-align:left; color: green;">Successfully created exercise!</span>';}?>
              <div class="formItem">
                  <label for="name">Exercise Name</label>
                  <input type="text" id="name" name="name">
                  <?php if(isset($_GET["status"]) && $_GET["status"] === 'duplicate') { echo '<span class="error-message invalid-message" style="display:block; text-align:left;">That exercise name already exists!</span>';}?>
                </div>
                
                <div class="formItem doubleRow">
                    <div class="inputContainer">
                        <label for="difficulty">Difficulty (1-5)</label>
                        <input type="number" id="difficulty" name="difficulty" min="1" max="5">
                    </div>

                    <div class="inputContainer">
                        <label for="duration">Duration (seconds)</label>
                        <input type="number" id="duration" name="duration" min="1">
                    </div>
            </div>
            
            <div class="formItem">
                <label for="category">Category</label>
                <select id="category"  name="category">
                    <?php
                        $categories = mysqli_query($dbc, "SELECT category_id, name FROM exercise_categories ORDER BY name");
                        echo "<option value='' disabled selected hidden>Select Option</option>";
                        while($row = mysqli_fetch_assoc($categories)) {
                            echo "<option value='" . $row['category_id'] . "'>" . $row['name'] . "</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="formItem doubleRow">
                    <div class="inputContainer">
                        <label for="equipment">Equipment</label>
                        <select id="equipment" name="equipment">
                            <?php
                                $equipment = mysqli_query($dbc, "SELECT equipment_id, name FROM equipment_types ORDER BY name");
                                echo "<option value='' disabled selected hidden>Select Option</option>";
                                while($row = mysqli_fetch_assoc($equipment)) {
                                    echo "<option value='" . $row['equipment_id'] . "'>" . $row['name'] . "</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="inputContainer">
                        <label for="muscle">Muscle Targeted</label>
                        <select id="muscle" name="muscle">
                            <?php
                                $muscles = mysqli_query($dbc, "SELECT muscle_id, name FROM muscles ORDER BY name");
                                echo "<option value='' disabled selected hidden>Select Option</option>";
                                while($row = mysqli_fetch_assoc($muscles)) {
                                    echo "<option value='" . $row['muscle_id'] . "'>" . $row['name'] . "</option>";
                                }
                            ?>
                        </select>
                    </div>
            </div>

            <div class="formItem">
                <label for="shorthand_description">Shorthand Description</label>
                <input type="text" id="shorthand_description" name="shorthand_description">
            </div>

            <div class="formItem">
                <label for="description">Full Description</label>
                <textarea id="description" name="description" rows="4"></textarea>
            </div>

            <span id="incomplete" class="error-message" style="text-align:left; margin-bottom: 5px;">Error. Please complete all required fields.</span>
            <input class="button" type="submit" name="submit" value="Add Exercise">

        </form>

        <script>
            document.getElementById('exerciseForm').addEventListener('submit', function(event) {
                const requiredFields = ['name', 'category', 'difficulty', 'duration', 'equipment', 'muscle', 'shorthand_description', 'description'];
                let formValid = true;

                requiredFields.forEach(id => {
                    const field = document.getElementById(id);
                    if (!field.value.trim()) {
                        field.style.border = '1px solid red';
                        formValid = false;
                    } else {
                        field.style.border = '';
                    }
                });

                if (!formValid) {
                    let incomplete = document.getElementById('incomplete');
                    incomplete.classList.add('invalid-message');
                    event.preventDefault();
                }
            });
        </script>  
      </div>

     
    </div>
  </body>
</html>