<?php
session_start();

include('mysqli_connect.php');

// Pass form data
$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
$password = mysqli_real_escape_string($dbc, trim($_POST['password']));


// Formulate the query to check if password matches with the database
$query = "SELECT * from users WHERE user_name = '$username' AND password = SHA2('$password', 256)"; 

// Run the query
$result = mysqli_query($dbc, $query);

if(mysqli_num_rows($result) == 1){
    
    // Set session variables first before echoing out any HTML code
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    // Set username
	$_SESSION["username"] = $row["user_name"];

    // Set role privledges
    $_SESSION["role"] = $row["role"];

    // Set user details
    $_SESSION["first_name"] = $row["first_name"];
    $_SESSION["last_name"] = $row["last_name"];
    $_SESSION["email"] = $row["email"];
    $_SESSION["streak_start_date"] = $row["streak_start_date"];

    header("Location: dashboard.php");
        echo "<p>GOODBYE</p>";

    exit();

}
else{
// redirect user to the login page
    header("Location: login.php?status=error");
    
// terminate the current script
    exit();
}

?>