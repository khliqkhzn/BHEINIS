<?php
session_start();

// Check if admin is logged in and OTP verified
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    // If not logged in, redirect to login
    header("Location: login.php");
    exit();
}
?>
