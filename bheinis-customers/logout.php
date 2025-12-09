<?php
session_start();
include '../db.php';  // ✅ Make sure database connection is available

// ✅ Log activity before destroying the session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $activity_type = "Logout";
    $activity_details = "User logged out from the system";

    $log = $conn->prepare("INSERT INTO customer_activity (user_id, activity_type, activity_details) VALUES (?, ?, ?)");
    $log->bind_param("iss", $user_id, $activity_type, $activity_details);
    $log->execute();
}

// ✅ Clear all session data
$_SESSION = array();

// ✅ Destroy the session
session_destroy();

// ✅ Redirect to login page
header("Location: login.php");
exit;
?>
