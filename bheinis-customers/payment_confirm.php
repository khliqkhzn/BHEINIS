<?php
include 'db.php';

// GET token
$token = $_GET['token'] ?? '';
if (empty($token)) die("❌ Invalid payment confirmation link.");

// Find payment record
$stmt = $conn->prepare("SELECT * FROM payments WHERE payment_token=? LIMIT 1");
if (!$stmt) die("❌ Prepare failed: " . $conn->error);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$payment = $result->fetch_assoc();
$stmt->close();

if (!$payment) die("❌ Payment not found or invalid token.");

// Variables
$order_id = $payment['order_id'];
$amount = $payment['amount'];
$wallet_type = $payment['ewallet_type'];
$already_paid = ($payment['payment_status'] === "Paid");

// Only update if not paid yet
if (!$already_paid) {
    // Update payments table
    $update_payment = $conn->prepare("UPDATE payments SET payment_status='Paid', payment_date=NOW() WHERE payment_token=?");
    $update_payment->bind_param("s", $token);
    $update_payment->execute();
    $update_payment->close();

    // Update orders table (only payment_status, no order_status)
    $update_order = $conn->prepare("UPDATE orders SET payment_status='Paid' WHERE id=?");
    $update_order->bind_param("i", $order_id);
    $update_order->execute();
    $update_order->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payment Confirmed</title>
<style>
body { background: #f5f6fa; font-family: Arial; display:flex; justify-content:center; align-items:center; height:100vh; }
.box { background:white; border-radius:20px; padding:40px; text-align:center; width:350px; box-shadow:0 0 10px rgba(0,0,0,0.2); }
.success { color:green; font-weight:bold; font-size:18px; }
.btn { background:#4CAF50;color:white;border:none;padding:12px 25px;border-radius:8px;font-size:16px;cursor:pointer;transition:0.3s; }
.btn:hover { background:#43a047; }
</style>
</head>
<body>
<div class="box">
    <h2>✅ Payment Successful!</h2>
    <p><strong>Order ID:</strong> <?= htmlspecialchars($order_id) ?></p>
    <p><strong>Amount Paid:</strong> RM <?= number_format($amount, 2) ?></p>
    <p><strong>Wallet:</strong> <?= htmlspecialchars(ucfirst($wallet_type)) ?></p>
    <p class="success"><?= $already_paid ? "This payment was already confirmed." : "Your payment has been confirmed." ?></p>

    <form action="payment_success.php" method="get">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <button type="submit" class="btn">View Order Summary</button>
    </form>
</div>
</body>
</html>
