<?php
session_start();
include '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// ✅ Ensure the form is submitted properly
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feedback_id'], $_POST['admin_reply'])) {
    $feedback_id = intval($_POST['feedback_id']);
    $admin_reply = trim($_POST['admin_reply']);

    if ($feedback_id > 0 && $admin_reply !== '') {
        // ✅ Update admin reply in the feedback table
        $stmt = $conn->prepare("UPDATE feedback SET admin_reply = ? WHERE feedback_id = ?");
        $stmt->bind_param("si", $admin_reply, $feedback_id);

        if ($stmt->execute()) {
            // Redirect back with success
            header("Location: admin_product_feedback.php?success=1");
            exit;
        } else {
            die("Database error: " . $stmt->error);
        }
    } else {
        die("Invalid input data.");
    }
} else {
    die("Unauthorized access.");
}
?>
