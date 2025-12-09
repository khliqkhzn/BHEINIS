<?php
include '../db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $return_id = intval($_POST['return_id']);
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE returns SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $return_id);

    if ($stmt->execute()) {
        // ✅ Show success alert and redirect
        echo "<script>
                alert('✅ Return status updated successfully!');
                window.location.href = 'admin_request_return.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('❌ Failed to update status. Please try again.');
                window.history.back();
              </script>";
    }
}
?>
