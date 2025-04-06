<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
}

include('mysqli_connect.php');

$xpAmount = isset($_POST['amount']) ? (int) $_POST['amount'] : 0;
$userId = $_SESSION['user_id'];

if ($xpAmount > 0 && $xpAmount <= 100) {
    $query = "UPDATE users SET xp = xp + ? WHERE user_id = ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $xpAmount, $userId);

    if (!mysqli_stmt_execute($stmt)) {
        echo "Statement failed: " . mysqli_stmt_error($stmt);
        exit;
    }

    header("Location: ../dashboard.php?status=success");
} else {
    header("Location: ../dashboard.php?status=failure");
}
?>