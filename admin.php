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
    
    <!-- Dashboard -->
    <div class="dashboard-container">
      <!-- Main Header -->
      <div class="dash-header">
        <?php 
        $title = 'Admin Dashboard';

        $subtitle = "Welcome back, ".$_SESSION['first_name']."!";
        include('shared/dashboard-header.php'); 
        ?>
      </div>
    
    <!-- Dashboard Content -->
      <div class="dash-content reverse">
      <div class="side-content reverse">
        <div class="dash-item">
            <h1>Actions</h1>
            <select class="selectionDropdown" id="formDropdown" onchange="handleDropdownChange()">
                <?php if(!(isset($_GET['action']))) {$_GET['action'] = 'createExercise';}?>
                <option <?php if(isset($_GET['action']) && $_GET['action'] === 'createExercise'){echo 'selected';}?> value="createExercise">Create Exercise</option>
                <option <?php if(isset($_GET['action']) && $_GET['action'] === 'createRegimen'){echo 'selected';}?> value="createRegimen">Create Regimen</option>
                <option <?php if(isset($_GET['action']) && $_GET['action'] === 'modifyRegimen'){echo 'selected';}?> value="modifyRegimen">Modify Regimen</option>
            </select>
            <script>
                function handleDropdownChange() {
                    const selected = document.getElementById('formDropdown').value;

                    // Hide all form sections
                    document.querySelectorAll('.adminForm').forEach(el => el.style.display = 'none');

                    // Show the one that matches the selected value
                    if (selected) {
                    document.getElementById(selected).style.display = 'block';
                    }
                }
            </script>

        </div>

        <div class="dash-item">
            <h1>Database Status</h1>
            <div style="height: 100px;">Database Information Here</div>
        </div>
        </div>        
          <!-- Main Content -->
        <div class="main-content">
            <div class="dash-item">
        <!-- Create Exercise Form -->
        <form class="adminForm <?php if(isset($_GET['action']) && $_GET['action'] !='createExercise'){echo 'hidden';}?>" id="createExercise" action="handle/admin_handle.php?action=createExercise" method="post">
              <h3>Create New Exercise</h3>
              <?php if(isset($_GET["status"]) && $_GET["status"] === 'error' && isset($_GET["action"]) && $_GET["action"] === 'createExercise') { echo '<span class="error-message invalid-message" style="display:block; text-align:left;">An unknown exception has occured. Please try again.</span>';}?>
              <?php if(isset($_GET["status"]) && $_GET["status"] === 'success' && isset($_GET["action"]) && $_GET["action"] === 'createExercise') { echo '<span class="error-message invalid-message" style="display: block; text-align:left; color: green;">Successfully created exercise!</span>';}?>
              
              <div class="formItem">
                  <label for="name">Exercise Name</label>
                  <input type="text" id="name" name="name">
                  <?php if(isset($_GET["status"]) && $_GET["status"] === 'duplicate' && isset($_GET["action"]) && $_GET["action"] === 'createExercise') { echo '<span class="error-message invalid-message" style="display:block; text-align:left;">That exercise name already exists!</span>';}?>
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
                <select class="dropdown" id="category"  name="category">
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
                        <select class="dropdown" id="equipment" name="equipment">
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
                        <select class="dropdown" id="muscle" name="muscle">
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

            <span id="createExerciseIncomplete" class="error-message" style="text-align:left; margin-bottom: 5px;">Error: Please complete all required fields.</span>
            <input class="button" type="submit" name="submit" value="Add Exercise">

            <script>
                document.getElementById('createExercise').addEventListener('submit', function(event) {
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
                        let incomplete = document.getElementById('createExerciseIncomplete');
                        incomplete.classList.add('invalid-message');
                        event.preventDefault();
                    }
                });
            </script>
        </form>

        <!-- Create Regimen Form -->
        <form class="adminForm <?php if(isset($_GET['action']) && $_GET['action'] !='createRegimen'){echo 'hidden';}?>" id="createRegimen" action="handle/admin_handle.php?action=createRegimen" method="post">
            <h3>Create New Regimen</h3>
            <?php if(isset($_GET["status"]) && $_GET["status"] === 'error' && isset($_GET["action"]) && $_GET["action"] === 'createRegimen') { echo '<span class="error-message invalid-message" style="display:block; text-align:left;">An unknown exception has occured. Please try again.</span>';}?>
            <?php if(isset($_GET["status"]) && $_GET["status"] === 'success' && isset($_GET["action"]) && $_GET["action"] === 'createRegimen') { echo '<span class="error-message invalid-message" style="display: block; text-align:left; color: green;">Successfully created regimen!</span>';}?>
            <div class="formItem doubleRow">
                <div class="inputContainer">
                    <label for="regimenName">Regimen Name</label>
                    <input type="text" id="regimenName" name="regimenName">
                    <?php if(isset($_GET["status"]) && $_GET["status"] === 'duplicate' && isset($_GET["action"]) && $_GET["action"] === 'createRegimen') { echo '<span class="error-message invalid-message" style="display:block; text-align:left;">That regimen name already exists!</span>';}?>
                </div>

                <div class="inputContainer">
                    <label for="regimenCategory">Category</label>
                    <select class="dropdown" id="regimenCategory"  name="regimenCategory">
                        <?php
                            $categories = mysqli_query($dbc, "SELECT category_id, name FROM exercise_categories ORDER BY name");
                            echo "<option value='' disabled selected hidden>Select Option</option>";
                            while($row = mysqli_fetch_assoc($categories)) {
                                echo "<option value='" . $row['category_id'] . "'>" . $row['name'] . "</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="formItem doubleRow">
                    <div class="inputContainer">
                        <label for="regimenXp">Completion XP</label>
                        <input type="number" id="regimenXp" name="regimenXp" min="0">
                    </div>

                    <div class="inputContainer">
                        <label for="regimenDifficulty">Difficulty</label>
                        <select class="dropdown" id="regimenDifficulty"  name="regimenDifficulty">
                            <option value='' disabled selected hidden>Select Option</option>
                            <option value='Beginner'>Beginner</option>
                            <option value='Intermediate'>Intermediate</option>
                            <option value='Advanced'>Advanced</option>
                        </select>
                    </div>
                </div>

            <div class="formItem">
                <label for="regimenDescription">Description</label>
                <textarea id="regimenDescription" name="regimenDescription" rows="4"></textarea>
            </div>

            <span id="createRegimenIncomplete" class="error-message" style="text-align:left; margin-bottom: 5px;">Error: Please complete all required fields.</span>
            <input class="button" type="submit" name="submit" value="Create Regimen">

            <script>
                document.getElementById('createRegimen').addEventListener('submit', function(event) {
                    const requiredFields = ['regimenName', 'regimenCategory', 'regimenXp', 'regimenDifficulty', 'regimenDescription'];
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
                        let incomplete = document.getElementById('createRegimenIncomplete');
                        incomplete.classList.add('invalid-message');
                        event.preventDefault();
                    }
                });
            </script>
        </form>

        <!-- Modify Regimen Form -->
        <form class="adminForm <?php if(isset($_GET['action']) && $_GET['action'] !='modifyRegimen'){echo 'hidden';}?>" id="modifyRegimen" action="handle/admin_handle.php?action=modifyRegimen" method="post">
            <h3>Modify Regimen</h3>
            <?php if(isset($_GET["status"]) && $_GET["status"] === 'error' && isset($_GET["action"]) && $_GET["action"] === 'modifyRegimen') { echo '<span class="error-message invalid-message" style="display:block; text-align:left;">An unknown exception has occured. Please try again.</span>';}?>
            <?php if(isset($_GET["status"]) && $_GET["status"] === 'success' && isset($_GET["action"]) && $_GET["action"] === 'modifyRegimen') { echo '<span class="error-message invalid-message" style="display: block; text-align:left; color: green;">Successfully modified regimen!</span>';}?>
              
            <div class="formItem doubleRow" style="margin-bottom: 3px">
                <div class="inputContainer">
                    <select class="dropdown" id="modifyRegimenName"  name="modifyRegimenName">
                        <?php
                            $regimens = mysqli_query($dbc, "SELECT regimen_id, regimen_name FROM workout_regimens ORDER BY regimen_name");
                            $selected = false;
                            $selectedValue = false;
                            while($row = mysqli_fetch_assoc($regimens)) {
                                $selected = (isset($_GET["regimen"]) && $_GET["regimen"] == $row['regimen_id']) ? true : false;
                                if ($selected) {
                                    echo "<option selected value='" . $row['regimen_id'] . "'>" . $row['regimen_name'] . "</option>";
                                    $selectedValue = true;
                                } else {
                                    echo "<option value='" . $row['regimen_id'] . "'>" . $row['regimen_name'] . "</option>";
                                }
                            }
                            if (!$selectedValue) {
                                echo "<option value='' disabled selected hidden>Select Option</option>";
                            }
                        ?>
                    </select>
                </div>
                    
                <div class="inputContainer">
                    <input id="submit" class="button" type="submit" name="submit" value="Select">
                </div>
            </div>

            <span id="modifyRegimenIncomplete" class="error-message" style="text-align:left; margin-bottom: 5px; margin-top:5px;">Error: Please complete all required fields.</span>

            <script>
                document.getElementById('modifyRegimen').addEventListener('submit', function(event) {
                    const select = document.getElementById('modifyRegimenName');
                    let formValid = select.value !== '';

                    if (!formValid) {
                        select.style.border = '1px solid red';
                        document.getElementById('modifyRegimenIncomplete').classList.add('invalid-message');
                        event.preventDefault();
                    } else {
                        select.style.border = '';
                    }
                });
            </script>
        </form>

        <!-- Selected Regimen to Modify Forms -->
        <?php 
        
            if(isset($_GET['action']) && $_GET['action'] === "modifyRegimen" && isset($_GET['regimen'])) {
                $regimen_id = mysqli_real_escape_string($dbc, $_GET['regimen']);

                $regimen_details_sql = "SELECT * FROM workout_regimens WHERE regimen_id = ?";

                if ($stmt = mysqli_prepare($dbc, $regimen_details_sql)) {
                    mysqli_stmt_bind_param($stmt, 'i', $regimen_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $numRows = mysqli_num_rows($result);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "
                            <form class='adminForm regimenDetails' id='createRegimen' action='handle/admin_handle.php?action=modifyRegimen&regimen=$regimen_id&sequence=details' method='post' style='margin-bottom:20px;'>
                                <h3>Details</h3>
                                <div class='formItem compressedItem doubleRow'>
                                    <div class='inputContainer'>
                                        <label for='regimenDetailName'>Regimen Name</label>
                                        <input type='text' id='regimenDetailName' name='regimenDetailName' value='{$row["regimen_name"]}'>";
                                if(isset($_GET['status']) && $_GET['status'] === 'duplicate' && isset($_GET['action']) && $_GET['action'] === 'modifyRegimen') { echo '<span class="error-message invalid-message" style="display:block; text-align:left;">That regimen name already exists!</span>';}
                        echo "</div>

                                <div class='inputContainer'>
                                    <label for='regimenDetailCategory'>Category</label>
                                    <select class='dropdown' id='regimenDetailCategory' name='regimenDetailCategory'>";
                                $categories = mysqli_query($dbc, 'SELECT category_id, name FROM exercise_categories ORDER BY name');
                                while ($categoryrow = mysqli_fetch_assoc($categories)) {
                                    $selected = ($row['category_id'] == $categoryrow['category_id']) ? true : false;
                                    if ($selected) {
                                        echo "<option selected value='{$categoryrow["category_id"]}'>{$categoryrow["name"]}</option>";
                                        $selectedValue = true;
                                    } else {
                                        echo "<option value='{$categoryrow["category_id"]}'>{$categoryrow["name"]}</option>";
                                    }
                                } 
                        echo "
                                    </select>
                                </div>
                            </div>
                            
                            <div class='formItem compressedItem doubleRow'>
                                <div class='inputContainer'>
                                    <label for='regimenDetailXp'>Completion XP</label>
                                    <input type='number' id='regimenDetailXp' name='regimenDetailXp' min='0' value='{$row["xp_amount"]}'>
                                </div>

                                <div class='inputContainer'>
                                    <label for='regimenDetailDifficulty'>Difficulty</label>
                                    <select class='dropdown' id='regimenDetailDifficulty' name='regimenDetailDifficulty'>";

                                $difficultyOptions = ['Beginner', 'Intermediate', 'Advanced'];
                                foreach ($difficultyOptions as $option) {
                                    $selected = ($row['difficulty'] == $option) ? 'selected' : '';
                                    echo "<option value='$option' $selected>$option</option>";
                                }

                                echo "
                                    </select>
                                </div>
                            </div>

                            <div class='formItem compressedItem'>
                                <label for='regimenDetailDescription'>Description</label>
                                <textarea id='regimenDetailDescription' name='regimenDetailDescription' rows='4'>{$row["description"]}</textarea>
                            </div>

                            <span id='createRegimenDetailIncomplete' class='error-message' style='text-align:left; margin-bottom: 5px;'>Error: Please complete all required fields.</span>
                            <div class='formItem doubleRow'>
                                <div class='inputContainer'>
                                    <input class='button' type='submit' name='submit' value='Update Details'>
                                </div>
                                <div class='inputContainer'>
                                    <a class='button remove' href='handle/admin_handle.php?action=modifyRegimen&regimen={$row["regimen_id"]}&sequence=details&r=1'>Delete Regimen</a>
                                </div>
                            </div>

                            <script>
                                document.querySelectorAll('.sequence-new').forEach(form => {
                                    form.addEventListener('submit', function(event) {
                                        const requiredFields = ['regimenDetailName', 'regimenDetailCategory', 'regimenDetailXp', 'regimenDetailDifficulty', 'regimenDetailDescription'];
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
                                            let incomplete = document.getElementById('createRegimenDetailIncomplete');
                                            incomplete.classList.add('invalid-message');
                                            event.preventDefault();
                                        }
                                    });
                                });
                            </script>
                        </form> 
                        ";
                    }
                }







                $regimen_exercises_sql = "SELECT we.*, e.name FROM workout_exercises we JOIN exercises e ON we.exercise_id = e.exercise_id WHERE we.regimen_id = ? ORDER BY sequence";
                
                if ($stmt = mysqli_prepare($dbc, $regimen_exercises_sql)) {
                    mysqli_stmt_bind_param($stmt, 'i', $regimen_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $numRows = mysqli_num_rows($result);


                    echo '<h3 class="adminForm">Exercises</h3>';

                    // Regimen Has no Current Exercises in It
                    if ($numRows === 0) {
                        echo "
                                <form class='adminForm sequence-new' id='modifyRegimen' action='handle/admin_handle.php?action=modifyRegimen&regimen=$regimen_id&sequence=new' method='post' style='margin-bottom:20px;'>
                                    <div class='formItem doubleRow compressedItem'>
                                        <div class='inputContainer'>
                                            <label for='modifyRegimenExercise-new'>Exercise</label>
                                            <select class='dropdown' id='modifyRegimenExercise-new' name='modifyRegimenExercise'>
                            ";

                            $exercises = mysqli_query($dbc, "SELECT exercise_id, name FROM exercises ORDER BY name");
                            echo "<option value='' disabled selected hidden>Select Exercise</option>";
                            $selected = false;
                            while ($exerciserow = mysqli_fetch_assoc($exercises)) {

                                $selected = ($row['exercise_id'] == $exerciserow['exercise_id']) ? true : false;
                                if ($selected) {
                                    echo "<option selected value='{$exerciserow["exercise_id"]}'>{$exerciserow["name"]}</option>";
                                    $selectedValue = true;
                                } else {
                                    echo "<option value='{$exerciserow["exercise_id"]}'>{$exerciserow["name"]}</option>";
                                }
                            }

                            echo "
                                            </select>
                                        </div>   
                                    </div>

                                    <div class='formItem doubleRow compressedItem'>
                                    <div class='inputContainer'>
                                            <label for='modifyRegimenRest-new'>Rest (sec)</label>
                                            <input type='number' id='modifyRegimenRest-new' name='modifyRegimenRest' min='0'>
                                        </div>
                                        <div class='inputContainer'>
                                            <label for='modifyRegimenReps-new'>Reps</label>
                                            <input type='number' id='modifyRegimenReps-new' name='modifyRegimenReps' min='1'>
                                        </div>

                                        <div class='inputContainer'>
                                            <label for='modifyRegimenSets-new'>Sets</label>
                                            <input type='number' id='modifyRegimenSets-new' name='modifyRegimenSets' min='1'>
                                        </div>
                                    </div>

                                    <div class='formItem compressedItem'>
                                        <label for='modifyRegimenNotes-new'>Notes</label>
                                        <textarea id='modifyRegimenNotes-new' name='modifyRegimenNotes' rows='2'></textarea>
                                    </div>
                                    
                                    <span id='modifyRegimennewIncomplete' class='error-message' style='text-align:left; margin-bottom: 5px;'>Error: Please complete all required fields.</span>
                                    <input class='button' type='submit' name='submit' value='Add New Exercise'>
                                </form>
                            ";

                            // Dynamic Exercise Form Validation Scripts
                            echo "
                                <script>
                                    document.querySelectorAll('.sequence-new').forEach(form => {
                                        form.addEventListener('submit', function(event) {
                                            const requiredFields = ['modifyRegimenExercise-new', 'modifyRegimenRest-new', 'modifyRegimenReps-new', 'modifyRegimenSets-new', 'modifyRegimenNotes-new'];
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
                                                let incomplete = document.getElementById('modifyRegimennewIncomplete');
                                                incomplete.classList.add('invalid-message');
                                                event.preventDefault();
                                            }
                                        });
                                    });
                                </script>
                            ";
                    
                        } else {
                    // Regimen Has Current Exercises
                        while ($row = mysqli_fetch_assoc($result)) {

                            echo "
                                <form class='adminForm sequence-{$row["sequence"]}' id='modifyRegimen' action='handle/admin_handle.php?action=modifyRegimen&regimen={$row["regimen_id"]}&sequence={$row["sequence"]}' method='post' style='margin-bottom:20px;'>
                                    <div class='formItem doubleRow compressedItem'>
                                        <div class='inputContainer'>
                                            <label for='modifyRegimenExercise-{$row["sequence"]}'>Exercise</label>
                                            <select class='dropdown' id='modifyRegimenExercise-{$row["sequence"]}' name='modifyRegimenExercise'>
                            ";

                            $exercises = mysqli_query($dbc, "SELECT exercise_id, name FROM exercises ORDER BY name");
                            $selected = false;
                            while ($exerciserow = mysqli_fetch_assoc($exercises)) {

                                $selected = ($row['exercise_id'] == $exerciserow['exercise_id']) ? true : false;
                                if ($selected) {
                                    echo "<option selected value='{$exerciserow["exercise_id"]}'>{$exerciserow["name"]}</option>";
                                    $selectedValue = true;
                                } else {
                                    echo "<option value='{$exerciserow["exercise_id"]}'>{$exerciserow["name"]}</option>";
                                }
                            }

                            echo "
                                            </select>
                                        </div>
                                    </div>

                                    <div class='formItem doubleRow compressedItem'>
                                    <div class='inputContainer'>
                                            <label for='modifyRegimenRest-{$row["sequence"]}'>Rest (sec)</label>
                                            <input type='number' value='{$row['rest_time']}' id='modifyRegimenRest-{$row["sequence"]}' name='modifyRegimenRest' min='0'>
                                        </div>
                                        <div class='inputContainer'>
                                            <label for='modifyRegimenReps-{$row["sequence"]}'>Reps</label>
                                            <input type='number' value='{$row['reps']}' id='modifyRegimenReps-{$row["sequence"]}' name='modifyRegimenReps' min='1'>
                                        </div>

                                        <div class='inputContainer'>
                                            <label for='modifyRegimenSets-{$row["sequence"]}'>Sets</label>
                                            <input type='number' value='{$row['sets']}' id='modifyRegimenSets-{$row["sequence"]}' name='modifyRegimenSets' min='1'>
                                        </div>
                                    </div>

                                    <div class='formItem compressedItem'>
                                        <label for='modifyRegimenNotes-{$row["sequence"]}'>Notes</label>
                                        <textarea id='modifyRegimenNotes-{$row["sequence"]}' name='modifyRegimenNotes' rows='2'>{$row['notes']}</textarea>
                                    </div>

                                    <span id='modifyRegimen{$row["sequence"]}Incomplete' class='error-message' style='text-align:left; margin-bottom: 5px;'>Error: Please complete all required fields.</span>
                                    
                                    <div class='formItem doubleRow'>
                                        <div class='inputContainer'>
                                            <input class='button' type='submit' name='submit' value='Update'>
                                        </div>
                                        <div class='inputContainer'>
                                            <a class='button remove' href='handle/admin_handle.php?action=modifyRegimen&regimen={$row["regimen_id"]}&sequence={$row["sequence"]}&r=1'>Remove</a>
                                        </div>
                                    </div>
                                    
                                </form>
                            ";

                            // Dynamic Exercise Form Validation Scripts
                            echo "
                                <script>
                                    document.querySelectorAll('.sequence-{$row["sequence"]}').forEach(form => {
                                        form.addEventListener('submit', function(event) {
                                            const requiredFields = ['modifyRegimenExercise-{$row["sequence"]}', 'modifyRegimenRest-{$row["sequence"]}', 'modifyRegimenReps-{$row["sequence"]}', 'modifyRegimenSets-{$row["sequence"]}', 'modifyRegimenNotes-{$row["sequence"]}'];
                                            let formValid = true;

                                            requiredFields.forEach(id => {
                                                const field = document.getElementById(id);
                                                if (!field || !field.value.trim()) {
                                                    field.style.border = '1px solid red';
                                                    formValid = false;
                                                } else {
                                                    field.style.border = '';
                                                }
                                            });

                                            if (!formValid) {
                                                let incomplete = document.getElementById('modifyRegimen{$row["sequence"]}Incomplete');
                                                incomplete.classList.add('invalid-message');
                                                event.preventDefault();
                                            }
                                        });
                                    });
                                </script>
                            ";

                        }

                        // Add Additional Exercise to Regimen
                        echo "
                                <form class='adminForm sequence-new' id='modifyRegimen' action='handle/admin_handle.php?action=modifyRegimen&regimen=$regimen_id&sequence=new' method='post' style='margin-bottom:20px;'>
                                    <div class='formItem doubleRow compressedItem'>
                                        <div class='inputContainer'>
                                            <label for='modifyRegimenExercise-new'>Exercise</label>
                                            <select class='dropdown' id='modifyRegimenExercise-new' name='modifyRegimenExercise'>
                            ";

                            $exercises = mysqli_query($dbc, "SELECT exercise_id, name FROM exercises ORDER BY name");
                            echo "<option value='' disabled selected hidden>Select Exercise</option>";
                            $selected = false;
                            while ($exerciserow = mysqli_fetch_assoc($exercises)) {

                                $selected = ($row['exercise_id'] == $exerciserow['exercise_id']) ? true : false;
                                if ($selected) {
                                    echo "<option selected value='{$exerciserow["exercise_id"]}'>{$exerciserow["name"]}</option>";
                                    $selectedValue = true;
                                } else {
                                    echo "<option value='{$exerciserow["exercise_id"]}'>{$exerciserow["name"]}</option>";
                                }
                            }

                            echo "
                                            </select>
                                        </div>   
                                    </div>

                                    <div class='formItem doubleRow compressedItem'>
                                    <div class='inputContainer'>
                                            <label for='modifyRegimenRest-new'>Rest (sec)</label>
                                            <input type='number' id='modifyRegimenRest-new' name='modifyRegimenRest' min='0'>
                                        </div>
                                        <div class='inputContainer'>
                                            <label for='modifyRegimenReps-new'>Reps</label>
                                            <input type='number' id='modifyRegimenReps-new' name='modifyRegimenReps' min='1'>
                                        </div>

                                        <div class='inputContainer'>
                                            <label for='modifyRegimenSets-new'>Sets</label>
                                            <input type='number' id='modifyRegimenSets-new' name='modifyRegimenSets' min='1'>
                                        </div>
                                    </div>

                                    <div class='formItem compressedItem'>
                                        <label for='modifyRegimenNotes-new'>Notes</label>
                                        <textarea id='modifyRegimenNotes-new' name='modifyRegimenNotes' rows='2'></textarea>
                                    </div>
                                    
                                    <span id='modifyRegimennewIncomplete' class='error-message' style='text-align:left; margin-bottom: 5px;'>Error: Please complete all required fields.</span>
                                    <input class='button' type='submit' name='submit' value='Add New Exercise'>
                                </form>
                            ";

                            // Dynamic Exercise Form Validation Scripts
                            echo "
                                <script>
                                    document.querySelectorAll('.sequence-new').forEach(form => {
                                        form.addEventListener('submit', function(event) {
                                            const requiredFields = ['modifyRegimenExercise-new', 'modifyRegimenRest-new', 'modifyRegimenReps-new', 'modifyRegimenSets-new', 'modifyRegimenNotes-new'];
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
                                                let incomplete = document.getElementById('modifyRegimennewIncomplete');
                                                incomplete.classList.add('invalid-message');
                                                event.preventDefault();
                                            }
                                        });
                                    });
                                </script>
                            ";


                    }
                
                    mysqli_stmt_close($stmt);
                } else {
                    echo "Error while preparing statement: " . mysqli_error($dbc);
                }
            }
        
        ?>


              
            </div>
        </div>
        </div>
    </div>
    
  </body>
</html>