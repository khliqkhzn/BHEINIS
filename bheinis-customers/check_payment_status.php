<?php
header('Content-Type: application/json');
include '../db.php'; 

// Get token
$token = $_GET['token'] ?? '';
if (empty($token)) {
    echo json_encode(['status' => 'Invalid', 'message' => 'No token provided']);
    exit;
}

// Fetch payment record
$stmt = $conn->prepare("SELECT payment_status FROM payments WHERE payment_token=? LIMIT 1");
if (!$stmt) {
    echo json_encode(['status' => 'Error', 'message' => 'Prepare failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$payment = $result->fetch_assoc();
$stmt->close();

if (!$payment) {
    echo json_encode(['status' => 'Invalid', 'message' => 'Payment not found']);
    exit;
}

// Return JSON status
$status = $payment['payment_status'];
echo json_encode(['status' => $status]);
