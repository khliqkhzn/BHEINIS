<?php
session_start();
include '../db.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$order_id = $_GET['order_id'] ?? 0;

// ✅ Fetch order, payment & user
$stmt = $conn->prepare("SELECT o.id, o.full_name, o.address, o.city, o.state, o.postcode, o.phone,
                               o.total_amount, o.order_date, o.delivery_method,
                               p.payment_method, p.payment_date
                        FROM orders o
                        JOIN payments p ON o.id = p.order_id
                        WHERE o.id = ? AND o.user_id = ?");
$stmt->bind_param("ii", $order_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$receipt = $result->fetch_assoc();

if (!$receipt) {
    die("Receipt not found.");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Receipt #<?= $receipt['id'] ?></title>
  <style>
    .receipt-box {
      width: 700px;
      margin: 50px auto;
      padding: 30px;
      border: 2px solid #000;
      border-radius: 12px;
      background: #fff;
    }
    .receipt-box h2 { text-align: center; }
    .receipt-details p { margin: 6px 0; }
    .btn-print {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background: #000;
      color: #fff;
      border-radius: 6px;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="receipt-box">
    <h2>BHEINIS Receipt</h2>
    <p><strong>Order ID:</strong> <?= $receipt['id'] ?></p>
    <p><strong>Name:</strong> <?= htmlspecialchars($receipt['full_name']) ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($receipt['address']) ?>, 
        <?= htmlspecialchars($receipt['city']) ?>, 
        <?= htmlspecialchars($receipt['state']) ?> - 
        <?= htmlspecialchars($receipt['postcode']) ?></p>
    <p><strong>Phone:</strong> <?= $receipt['phone'] ?></p>
    <hr>
    <p><strong>Total Paid:</strong> RM <?= number_format($receipt['total_amount'], 2) ?></p>
    <p><strong>Payment Method:</strong> <?= $receipt['payment_method'] ?></p>
    <p><strong>Payment Date:</strong> <?= $receipt['payment_date'] ?></p>
    <p><strong>Delivery Method:</strong> <?= ucfirst($receipt['delivery_method']) ?></p>
    <p><strong>Order Date:</strong> <?= $receipt['order_date'] ?></p>

    <a href="#" onclick="window.print()" class="btn-print">🖨️ Print Receipt</a>
  </div>
</body>
</html>
