<?php
session_start();
include 'db.php';

// Step 1: Collect parameters
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$amount   = isset($_GET['amount']) ? floatval($_GET['amount']) : 0;
$wallet_type = isset($_GET['wallet']) ? trim($_GET['wallet']) : '';
$user_id = $_SESSION['user_id'] ?? 0;

if ($order_id <= 0 || $amount <= 0 || empty($wallet_type) || $user_id <= 0) {
    die("❌ Missing payment information.");
}

// Step 2: Wallet display name
switch (strtolower($wallet_type)) {
    case 'tng': $wallet_display = "Touch 'n Go eWallet"; break;
    case 'boost': $wallet_display = "Boost Wallet"; break;
    case 'grabpay': $wallet_display = "GrabPay"; break;
    default: $wallet_display = ucfirst($wallet_type);
}

// Step 3: Generate unique transaction info
$transaction_id = 'TXN' . time() . rand(100, 999);
$payment_method = "E-Wallet";
$payment_status_var = "Pending";
$ewallet_id = strtoupper($wallet_type) . '-' . substr($transaction_id, -4);

// Step 4: Generate unique payment token
do {
    $payment_token = bin2hex(random_bytes(16));
    $check_stmt = $conn->prepare("SELECT id FROM payments WHERE payment_token=? LIMIT 1");
    $check_stmt->bind_param("s", $payment_token);
    $check_stmt->execute();
    $check_stmt->store_result();
} while ($check_stmt->num_rows > 0);
$check_stmt->close();

// Step 5: Insert payment record
$sql = "INSERT INTO payments 
(order_id, user_id, amount, payment_method, payment_status, transaction_id, payment_date, ewallet_type, ewallet_id, payment_token)
VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?)";
$insert_payment = $conn->prepare($sql);
if (!$insert_payment) die("❌ SQL Prepare Failed: " . $conn->error);

$insert_payment->bind_param(
    "iidssssss",
    $order_id,
    $user_id,
    $amount,
    $payment_method,
    $payment_status_var,
    $transaction_id,
    $wallet_type,
    $ewallet_id,
    $payment_token
);

if (!$insert_payment->execute()) die("❌ Insert Failed: " . $insert_payment->error);
$insert_payment->close();

// Step 6: Generate QR URL
$base_url = "http://192.168.0.171/BHEINIS/bheinis-customers";
$qr_data = "$base_url/payment_confirm.php?token=$payment_token";
$qr_url = "https://api.qrserver.com/v1/create-qr-code/?data=" . urlencode($qr_data) . "&size=200x200";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($wallet_display) ?> Payment</title>
<style>
body { font-family: Arial; background:#f5f6fa; display:flex; justify-content:center; align-items:center; height:100vh; }
.qr-container { background:white; border-radius:20px; padding:40px; text-align:center; width:350px; box-shadow:0 0 10px rgba(0,0,0,0.2); }
.qr-container img { width:200px; height:200px; margin:20px 0; }
.btn { background:#4CAF50;color:white;border:none;padding:12px 25px;border-radius:8px;font-size:16px;cursor:pointer;transition:0.3s; }
.btn:hover { background:#43a047; }
.success { color:green; font-weight:bold; }
#waiting { color:#555; font-size:15px; margin-top:10px; animation: blink 1.2s infinite; }
@keyframes blink { 50% { opacity:0.5; } }
</style>
</head>
<body>
<div class="qr-container">
    <h2><?= htmlspecialchars($wallet_display) ?> Payment</h2>
    <p><strong>Order ID:</strong> <?= $order_id ?></p>
    <p><strong>Amount:</strong> RM <?= number_format($amount, 2) ?></p>
    <img src="<?= $qr_url ?>" alt="QR Code">
    <p>Scan this QR code to confirm payment.</p>
    <p class="success">✅ Payment record created (Pending)</p>
    <p id="waiting">⏳ Waiting for payment confirmation...</p>

    <form action="payment_confirm.php" method="get">
        <input type="hidden" name="token" value="<?= htmlspecialchars($payment_token) ?>">
        <button type="submit" class="btn">📱 I Have Scanned & Confirm Payment</button>
    </form>
</div>

<script>
const token = "<?= $payment_token ?>";
setInterval(() => {
    fetch(`check_payment_status.php?token=${token}`)
        .then(res => res.json())
        .then(data => {
            if(data.status === "Paid") window.location.href = `payment_success.php?token=${token}`;
        }).catch(err => console.error(err));
}, 10000);
</script>
</body>
</html>
