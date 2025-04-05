<?php
// Redirect user if not logged in
session_start();
if (empty($_SESSION['username'])) { 
    header("Location: login.php");    
    exit();
    } 

  include('handle/mysqli_connect.php');

  if (isset($_GET['id'])) {
    $_SESSION['id'] = (int) $_GET['id'];

    $routineList = "SELECT * FROM custom_workouts WHERE user_id = ? AND workout_id = ?";
    $stmt = mysqli_prepare($dbc, $routineList);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ii', $_SESSION["user_id"],$_SESSION['id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $numRows = mysqli_num_rows($result);

      if($numRows != 1) {
        header("Location: dashboard.php");
      } 

    } else {
      header("Location: dashboard.php");
    }
    
  } else if (isset($_GET["action"]) && $_GET["action"] == "create") {
    $_SESSION['id'] = 'new';
  }
  else {
    header("Location: dashboard.php");
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Modify Routine  | Endurify</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/form-styles.css">
  </head>
  
  <body class="background-gradient">
    <!-- Left Sidebar -->
    <div>
      <?php 
        $currentPage = "workouts";
        include('shared/sidebar.php'); 
        ?>
    </div>
    
    <!-- Dashboard -->
    <div class="dashboard-container">

    <!-- Dashboard Content -->
      <div class="dash-content">        
          <!-- Main Content -->
          <div class="main-content">
            <div class="dash-item">
              <?php
                if ($_SESSION['id'] == 'new') {
                  // Create New Routine
                  echo '
                      <form class="adminForm" id="createRoutine" action="handle/modifyroutine_handle.php?action=createRoutine" method="post">
                          <h1>Create New Routine</h1>';
                          
                      if (isset($_GET["status"]) && $_GET["status"] === 'error' && isset($_GET["action"])) {
                          echo '<span class="error-message invalid-message" style="display:block; text-align:left;">An unknown exception has occurred. Please try again.</span>';
                      }

                      echo '
                          <div class="formItem doubleRow">
                              <div class="inputContainer">
                                  <label for="routineName">Routine Name</label>
                                  <input type="text" id="routineName" name="routineName">
                              </div>
                          </div>

                          <div class="formItem">
                              <label for="routineDescription">Description</label>
                              <textarea id="routineDescription" name="routineDescription" rows="4"></textarea>
                          </div>

                          <span id="createRoutineIncomplete" class="error-message" style="text-align:left; margin-bottom: 5px;">Error: Please complete all required fields.</span>
                          <input class="button" type="submit" name="submit" value="Create Routine">

                          <script>
                              document.getElementById("createRoutine").addEventListener("submit", function(event) {
                                  const requiredFields = ["routineName", "routineDescription"];
                                  let formValid = true;

                                  requiredFields.forEach(id => {
                                      const field = document.getElementById(id);
                                      if (!field.value.trim()) {
                                          field.style.border = "1px solid red";
                                          formValid = false;
                                      } else {
                                          field.style.border = "";
                                      }
                                  });

                                  if (!formValid) {
                                      let incomplete = document.getElementById("createRoutineIncomplete");
                                      incomplete.classList.add("invalid-message");
                                      event.preventDefault();
                                  }
                              });
                          </script>
                      </form>';

                } else {
                  // Modify Existing Routine
                      $routine_id = mysqli_real_escape_string($dbc, $_GET['id']);
      
                      $routine_details_sql = "SELECT * FROM custom_workouts WHERE workout_id = ?";
      
                      if ($stmt = mysqli_prepare($dbc, $routine_details_sql)) {
                          mysqli_stmt_bind_param($stmt, 'i', $routine_id);
                          mysqli_stmt_execute($stmt);
                          $result = mysqli_stmt_get_result($stmt);
                          $numRows = mysqli_num_rows($result);
      
                          while ($row = mysqli_fetch_assoc($result)) {
                              echo "
                              <form class='adminForm routineDetails' id='createRoutine' action='handle/modifyroutine_handle.php?action=modifyRoutine&routine=$routine_id&sequence=details' method='post' style='margin-bottom:20px;'>
                                      <h1>Modify {$row["workout_name"]}</h1>";
                                      if(isset($_GET["status"]) && $_GET["status"] === 'error' && isset($_GET["action"]) && $_GET["action"] === 'modifyRoutine') { echo '<span class="error-message invalid-message" style="display:block; text-align:left;">An unknown exception has occured. Please try again.</span>';}
                                      if(isset($_GET["status"]) && $_GET["status"] === 'success' && isset($_GET["action"]) && $_GET["action"] === 'modifyRoutine') { echo '<span class="error-message invalid-message" style="display: block; text-align:left; color: green;">Successfully modified routine!</span>';}
                              echo "
                                      <h3>Details</h3>
                                      
                                        <div class='inputContainer compressedItem'>
                                            <label for='routineDetailName'>Routine Name</label>
                                            <input type='text' id='routineDetailName' name='routineDetailName' value='{$row["workout_name"]}'>
                                        </div>
    
                                        <div class='formItem compressedItem'>
                                            <label for='routineDetailDescription'>Description</label>
                                            <textarea id='routineDetailDescription' name='routineDetailDescription' rows='4'>{$row["description"]}</textarea>
                                        </div>
      
                                  <span id='createRoutineDetailIncomplete' class='error-message' style='text-align:left; margin-bottom: 5px;'>Error: Please complete all required fields.</span>
                                  <div class='formItem doubleRow'>
                                      <div class='inputContainer'>
                                          <input class='button' type='submit' name='submit' value='Update Details'>
                                      </div>
                                      <div class='inputContainer'>
                                          <a class='button remove' href='handle/modifyroutine_handle.php?action=modifyRoutine&routine={$row["workout_id"]}&sequence=details&r=1'>Delete Routine</a>
                                      </div>
                                  </div>
      
                                  <script>
                                      document.querySelectorAll('.sequence-new').forEach(form => {
                                          form.addEventListener('submit', function(event) {
                                              const requiredFields = ['routineDetailName', 'routineDetailDescription'];
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
                                                  let incomplete = document.getElementById('createRoutineDetailIncomplete');
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
      
      
      
      
      
      
      
                      $routine_exercises_sql = "SELECT cwe.*, e.name FROM custom_workout_exercises cwe JOIN exercises e ON cwe.exercise_id = e.exercise_id WHERE cwe.workout_id = ? ORDER BY sequence";
                      
                      if ($stmt = mysqli_prepare($dbc, $routine_exercises_sql)) {
                          mysqli_stmt_bind_param($stmt, 'i', $routine_id);
                          mysqli_stmt_execute($stmt);
                          $result = mysqli_stmt_get_result($stmt);
                          $numRows = mysqli_num_rows($result);
      
      
                          echo '<h3 class="adminForm">Exercises</h3>';
      
                          // Routine Has no Current Exercises in It
                          if ($numRows === 0) {
                              echo "
                                      <form class='adminForm sequence-new' id='modifyRoutine' action='handle/modifyroutine_handle.php?action=modifyRoutine&routine=$routine_id&sequence=new' method='post' style='margin-bottom:20px;'>
                                          <div class='formItem doubleRow compressedItem'>
                                              <div class='inputContainer'>
                                                  <label for='modifyRoutineExercise-new'>Exercise</label>
                                                  <select class='dropdown' id='modifyRoutineExercise-new' name='modifyRoutineExercise'>
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
                                                  <label for='modifyRoutineRest-new'>Rest (sec)</label>
                                                  <input type='number' id='modifyRoutineRest-new' name='modifyRoutineRest' min='0'>
                                              </div>
                                              <div class='inputContainer'>
                                                  <label for='modifyRoutineReps-new'>Reps</label>
                                                  <input type='number' id='modifyRoutineReps-new' name='modifyRoutineReps' min='1'>
                                              </div>
      
                                              <div class='inputContainer'>
                                                  <label for='modifyRoutineSets-new'>Sets</label>
                                                  <input type='number' id='modifyRoutineSets-new' name='modifyRoutineSets' min='1'>
                                              </div>
                                          </div>
      
                                          <div class='formItem compressedItem'>
                                              <label for='modifyRoutineNotes-new'>Notes</label>
                                              <textarea id='modifyRoutineNotes-new' name='modifyRoutineNotes' rows='2'></textarea>
                                          </div>
                                          
                                          <span id='modifyRoutinenewIncomplete' class='error-message' style='text-align:left; margin-bottom: 5px;'>Error: Please complete all required fields.</span>
                                          <input class='button' type='submit' name='submit' value='Add New Exercise'>
                                      </form>
                                  ";
      
                                  // Dynamic Exercise Form Validation Scripts
                                  echo "
                                      <script>
                                          document.querySelectorAll('.sequence-new').forEach(form => {
                                              form.addEventListener('submit', function(event) {
                                                  const requiredFields = ['modifyRoutineExercise-new', 'modifyRoutineRest-new', 'modifyRoutineReps-new', 'modifyRoutineSets-new', 'modifyRoutineNotes-new'];
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
                                                      let incomplete = document.getElementById('modifyRoutinenewIncomplete');
                                                      incomplete.classList.add('invalid-message');
                                                      event.preventDefault();
                                                  }
                                              });
                                          });
                                      </script>
                                  ";
                          
                              } else {
                          // Routine Has Current Exercises
                              while ($row = mysqli_fetch_assoc($result)) {
      
                                  echo "
                                      <form class='adminForm sequence-{$row["sequence"]}' id='modifyRoutine' action='handle/modifyroutine_handle.php?action=modifyRoutine&routine={$row["workout_id"]}&sequence={$row["sequence"]}' method='post' style='margin-bottom:20px;'>
                                          <div class='formItem doubleRow compressedItem'>
                                              <div class='inputContainer'>
                                                  <label for='modifyRoutineExercise-{$row["sequence"]}'>Exercise</label>
                                                  <select class='dropdown' id='modifyRoutineExercise-{$row["sequence"]}' name='modifyRoutineExercise'>
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
                                                  <label for='modifyRoutineRest-{$row["sequence"]}'>Rest (sec)</label>
                                                  <input type='number' value='{$row['rest_time']}' id='modifyRoutineRest-{$row["sequence"]}' name='modifyRoutineRest' min='0'>
                                              </div>
                                              <div class='inputContainer'>
                                                  <label for='modifyRoutineReps-{$row["sequence"]}'>Reps</label>
                                                  <input type='number' value='{$row['reps']}' id='modifyRoutineReps-{$row["sequence"]}' name='modifyRoutineReps' min='1'>
                                              </div>
      
                                              <div class='inputContainer'>
                                                  <label for='modifyRoutineSets-{$row["sequence"]}'>Sets</label>
                                                  <input type='number' value='{$row['sets']}' id='modifyRoutineSets-{$row["sequence"]}' name='modifyRoutineSets' min='1'>
                                              </div>
                                          </div>
      
                                          <div class='formItem compressedItem'>
                                              <label for='modifyRoutineNotes-{$row["sequence"]}'>Notes</label>
                                              <textarea id='modifyRoutineNotes-{$row["sequence"]}' name='modifyRoutineNotes' rows='2'>{$row['notes']}</textarea>
                                          </div>
      
                                          <span id='modifyRoutine{$row["sequence"]}Incomplete' class='error-message' style='text-align:left; margin-bottom: 5px;'>Error: Please complete all required fields.</span>
                                          
                                          <div class='formItem doubleRow'>
                                              <div class='inputContainer'>
                                                  <input class='button' type='submit' name='submit' value='Update'>
                                              </div>
                                              <div class='inputContainer'>
                                                  <a class='button remove' href='handle/modifyroutine_handle.php?action=modifyRoutine&routine={$row["workout_id"]}&sequence={$row["sequence"]}&r=1'>Remove</a>
                                              </div>
                                          </div>
                                          
                                      </form>
                                  ";
      
                                  // Dynamic Exercise Form Validation Scripts
                                  echo "
                                      <script>
                                          document.querySelectorAll('.sequence-{$row["sequence"]}').forEach(form => {
                                              form.addEventListener('submit', function(event) {
                                                  const requiredFields = ['modifyRoutineExercise-{$row["sequence"]}', 'modifyRoutineRest-{$row["sequence"]}', 'modifyRoutineReps-{$row["sequence"]}', 'modifyRoutineSets-{$row["sequence"]}', 'modifyRoutineNotes-{$row["sequence"]}'];
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
                                                      let incomplete = document.getElementById('modifyRoutine{$row["sequence"]}Incomplete');
                                                      incomplete.classList.add('invalid-message');
                                                      event.preventDefault();
                                                  }
                                              });
                                          });
                                      </script>
                                  ";
      
                              }
      
                              // Add Additional Exercise to Routine
                              echo "
                                      <form class='adminForm sequence-new' id='modifyRoutine' action='handle/modifyroutine_handle.php?action=modifyRoutine&routine=$routine_id&sequence=new' method='post' style='margin-bottom:20px;'>
                                          <div class='formItem doubleRow compressedItem'>
                                              <div class='inputContainer'>
                                                  <label for='modifyRoutineExercise-new'>Exercise</label>
                                                  <select class='dropdown' id='modifyRoutineExercise-new' name='modifyRoutineExercise'>
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
                                                  <label for='modifyRoutineRest-new'>Rest (sec)</label>
                                                  <input type='number' id='modifyRoutineRest-new' name='modifyRoutineRest' min='0'>
                                              </div>
                                              <div class='inputContainer'>
                                                  <label for='modifyRoutineReps-new'>Reps</label>
                                                  <input type='number' id='modifyRoutineReps-new' name='modifyRoutineReps' min='1'>
                                              </div>
      
                                              <div class='inputContainer'>
                                                  <label for='modifyRoutineSets-new'>Sets</label>
                                                  <input type='number' id='modifyRoutineSets-new' name='modifyRoutineSets' min='1'>
                                              </div>
                                          </div>
      
                                          <div class='formItem compressedItem'>
                                              <label for='modifyRoutineNotes-new'>Notes</label>
                                              <textarea id='modifyRoutineNotes-new' name='modifyRoutineNotes' rows='2'></textarea>
                                          </div>
                                          
                                          <span id='modifyRoutinenewIncomplete' class='error-message' style='text-align:left; margin-bottom: 5px;'>Error: Please complete all required fields.</span>
                                          <input class='button' type='submit' name='submit' value='Add New Exercise'>
                                      </form>
                                  ";
      
                                  // Dynamic Exercise Form Validation Scripts
                                  echo "
                                      <script>
                                          document.querySelectorAll('.sequence-new').forEach(form => {
                                              form.addEventListener('submit', function(event) {
                                                  const requiredFields = ['modifyRoutineExercise-new', 'modifyRoutineRest-new', 'modifyRoutineReps-new', 'modifyRoutineSets-new', 'modifyRoutineNotes-new'];
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
                                                      let incomplete = document.getElementById('modifyRoutinenewIncomplete');
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

          <div class="side-content">
            <div class="dash-item">
                <h1>Your Routines</h1>
                <div class="routines">
                <?php 
                    $routineList = "SELECT * FROM custom_workouts WHERE user_id = ? ORDER BY workout_id";
                    $stmt = mysqli_prepare($dbc, $routineList);
                    
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, 'i', $_SESSION["user_id"]);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $numRows = mysqli_num_rows($result);

                        if($numRows === 0) {
                        echo "None";
                        } else {
                        while ($row = mysqli_fetch_assoc($result)) {

                            echo "
                            <div class='routine-card'>
                                <div class='details'>
                                    <h3>{$row["workout_name"]}</h3>
                                    <span class='description'>{$row["description"]}</span>
                                </div>
                                <a class='select' href='viewroutine.php?routine={$row["workout_id"]}'>
                                <i class='fa fa-play'></i>
                                </a>
                            </div>
                            ";
                        }
                        }
                    } else {
                        echo 'Error retreiving routines! (Ref: err)';
                    }
                ?>

                    <a class='button' href='modifyroutine.php?action=create'>Create Routine</a>
                </div>
                </div>
          </div>
     
      </div>
    </div>
    
  </body>
</html>