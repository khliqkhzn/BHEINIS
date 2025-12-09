<?php
session_start();
include '../db.php';  // Make sure this file connects to $conn

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to submit feedback.");
}

// ✅ Validate POST data
if (
    !isset($_POST['product_id'], $_POST['rating'], $_POST['comments']) ||
    !is_numeric($_POST['product_id']) ||
    !is_numeric($_POST['rating'])
) {
    die("Invalid form submission.");
}

$product_id = intval($_POST['product_id']);
$rating     = intval($_POST['rating']);
$comment    = trim($_POST['comments']);
$user_id    = $_SESSION['user_id'];

// Optional: basic validation
if ($rating < 1 || $rating > 5) {
    die("Invalid rating value.");
}
if (strlen($comment) < 3) {
    die("Please write a longer review.");
}

// ✅ Insert into database
$sql = "INSERT INTO feedback (product_id, user_id, rating, comment, feedback_date)
        VALUES (?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("iiis", $product_id, $user_id, $rating, $comment);

if ($stmt->execute()) {
    // ✅ Success
    header("Location: product_detail.php?id=" . $product_id);
    exit();
} else {
    die("Error submitting feedback: " . $stmt->error);
}
