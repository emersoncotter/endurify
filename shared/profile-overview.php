<?php 

require_once 'scripts/functions.php'; 
include('handle/mysqli_connect.php');

// Get user from database to update every time this is loaded
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($dbc, $query);
mysqli_stmt_bind_param($stmt, 'i', $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    // Get from database
    $_SESSION["xp"] = $row["xp"];

    // Calculate level info off XP amount
    $levelinfo = getLevelInfo($_SESSION["xp"]);

    $_SESSION["level"] = $levelinfo["level"];
    $_SESSION["xp_into"] = $levelinfo["xp_into"];
    $_SESSION["xp_needed"] = $levelinfo["xp_needed"];
    $_SESSION["progress_percent"] = $levelinfo["progress_percent"];
}

?>
<a href="profile.php">
<div class="profile-icon">
<?php 
    $initial = $_SESSION['first_name'][0].$_SESSION['last_name'][0];
    echo $initial;
?>
</div>
</a>
<div class="spacer"></div>
<div class="content">
<?php 
$name = $_SESSION['first_name']." ".$_SESSION['last_name'];
echo "<h1>$name</h1>";
?>

<div class="badge-container">
<div class="badge badge-green">
    <i class="fa fa-trophy"></i>
    <span>Level <?php echo $_SESSION["level"]; // TODO: pull level here ?></span>
</div>
<div class="badge badge-blue">
    <i class="fa fa-fire"></i>
    <span><?php echo getStreakWeek($_SESSION["streak_start_date"]); // TODO: pull streak weeks here ?> Week Streak</span>
</div>
</div>

<div class="xp-container">
<div class="xp-header">
    <span class="xp-label">XP Progress</span>
    <span class="xp-needed"><span class="xp-earned"><?php echo $_SESSION["xp_into"]; // TODO: xp earned here ?></span> / <?php echo $_SESSION["xp_needed"]; // TODO: pull xp total here ?></span>
</div>
<div class="xp-bar">
    <div class="xp-fill" style="width: <?php echo $_SESSION["progress_percent"]; // TODO: level percentage here ?>%;"></div>
</div>
</div>

</div>