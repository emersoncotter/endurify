<?php
// Redirect user if not logged in
session_start();
if (empty($_SESSION['username'])) { 
    header("Location: login.php");    
    exit();
    } 

    include('handle/mysqli_connect.php');
  
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Profile | Endurify</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/form-styles.css">
  </head>
  
  <body class="background-gradient">
    <!-- Left Sidebar -->
    <div>
      <?php 
        $currentPage = "profile";
        include('shared/sidebar.php'); 
        ?>
    </div>
    
    <!-- Dashboard -->
    <div class="dashboard-container">
      <!-- Main Header -->
      <div class="dash-header">
        <?php 
        $title = 'Your Profile';

        $subtitle = "Welcome back, ".$_SESSION['first_name']."!";
        include('shared/dashboard-header.php'); 
        ?>
      </div>
    
    <!-- Dashboard Content -->
      <div class="dash-content">        
          <!-- Main Content -->
          <div class="main-content">
            <div class="dash-item">
              <div class="item-header">
                <i class="fa fa-user gradient-text"></i>
                <h2 class="title">Account Information</h2>
              </div>

              <?php 
                $user_id = mysqli_real_escape_string($dbc, $_SESSION['user_id']);
        
                $user_details_sql = "SELECT * FROM users WHERE user_id = ?";

                if ($stmt = mysqli_prepare($dbc, $user_details_sql)) {
                    mysqli_stmt_bind_param($stmt, 'i', $user_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $numRows = mysqli_num_rows($result);

                    while ($row = mysqli_fetch_assoc($result)) {
                              echo "<form class='update-profile' action='handle/profile_handle.php' method='post' id='signinForm'>
                              <div class='adminForm'>";
                              
                              if(isset($_GET["status"]) && $_GET["status"] === 'error') { echo '<span class="error-message invalid-message" style="display:block; text-align:left;">An unknown exception has occured. Please try again.</span>';}
                              if(isset($_GET["status"]) && $_GET["status"] === 'updated') { echo '<span class="error-message invalid-message" style="display: block; text-align:left; color: green;">Successfully updated account information!</span>';}
                              
                              echo "
                                <div class='formItem doubleRow'>
                                  <div class='inputContainer'>
                                    <label for='firstName'>First</label>
                                    <input type='text' class='doubleField required-field' autocomplete='none' id='firstName' name='firstName' value='{$row["first_name"]}' size='20' maxlength='40'>
                                    <span class='error-message'></span>
                                  </div>

                                  <div class='inputContainer'>
                                    <label for='lastName'>Last</label>
                                    <input type='text' class='doubleField required-field' autocomplete='none' id='lastName' name='lastName' value='{$row["last_name"]}' size='20' maxlength='40'>
                                    <span class='error-message'></span>
                                  </div>
                                </div>

                                <div class='formItem'>
                                  <label for='email'>Email</label>
                                  <input type='email' class='required-field' autocomplete='none' id='email' name='email' value='{$row["email"]}' size='20' maxlength='40'>
                                  <span class='error-message'></span>";
                                  
                                  if(isset($_GET['status']) && $_GET['status'] === 'email') { echo '<span class="error-message invalid-message" style="display:block; text-align: left;">That email already exists!</span>'; }
                                
                                  echo "
                                  </div>

                                <div class='formItem'>
                                  <label for='username'>Username</label>
                                  <input type='text' class='required-field' autocomplete='none' id='username' name='username' value='{$row["user_name"]}' size='20' maxlength='40'>
                                  <span class='error-message'></span>";

                                  if(isset($_GET['status']) && $_GET['status'] === 'username') { echo '<span class="error-message invalid-message" style="display:block; text-align: left;">That username already exists!</span>'; }
                                
                                  echo " 
                                  </div>

                                <div class='formItem doubleRow'>
                                  <div class='inputContainer'>
                                    <label for='gender'>Gender</label>
                                    <select class='doubleField dropdown required-field' id='gender' name='gender'>
                                      <option value='{$row["gender"]}' selected hidden>{$row["gender"]}</option>
                                      <option value='male'>Male</option>
                                      <option value='female'>Female</option>
                                      <option value='non-binary'>Non-Binary</option>
                                      <option value='prefer-not'>Prefer not to say</option>
                                      <option value='other'>Other</option>
                                    </select>
                                    <span class='error-message'></span>
                                  </div>
                                  <div class='inputContainer'>
                                    <label for='zipcode'>Zip Code</label>
                                    <input type='text' class='doubleField required-field' autocomplete='none' id='zipcode' name='zipcode' value='{$row["zipcode"]}' size='20' maxlength='5'>
                                    <span class='error-message'></span>
                                  </div>
                                </div>

                                <div class='formItem'>
                                  <input class='button' type='submit' name='submit' value='Update Information'>
                                  <span id='profileUpdateIncomplete' class='error-message' style='text-align:left; margin-bottom: 5px;'>Error: Please complete all required fields.</span>
                                </div>
                              </div>
                            </form>

                            
                            ";

                          echo "
                            <script>
                                document.querySelectorAll('.update-profile').forEach(form => {
                                    form.addEventListener('submit', function(event) {
                                        const requiredFields = ['firstName', 'lastName', 'email', 'username', 'gender', 'zipcode'];
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
                                            let incomplete = document.getElementById('profileUpdateIncomplete');
                                            incomplete.classList.add('invalid-message');
                                            event.preventDefault();
                                        }
                                    });
                                });
                            </script>
                          ";
                    }
                  }
              
              
              
              
              
              ?>
              











            </div>
          </div>
          
          <div class="side-content">
            <div class="dash-item profile">
              <?php include('shared/profile-overview.php'); ?>
            </div>
          </div>
      
      </div>
    </div>
    
  </body>
</html>