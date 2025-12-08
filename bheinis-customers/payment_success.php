<?php
session_start();
include 'db.php';

// Step 1: Get token or order_id
$token = $_GET['token'] ?? '';
$order_id = $_GET['order_id'] ?? '';

if (!$token && !$order_id) {
    die("❌ Invalid access. No token or order ID.");
}

// Step 2: Fetch order details
if ($token) {
    // Fetch via payment token (eWallet)
    $stmt = $conn->prepare("
        SELECT p.order_id, o.customer_name, o.email, o.order_date, o.status, o.payment_status,
               o.shipment_status, o.delivery_status, o.total_amount
        FROM payments p
        JOIN orders o ON p.order_id = o.id
        WHERE p.payment_token = ? LIMIT 1
    ");
    $stmt->bind_param("s", $token);
} else {
    // Fetch via order_id (Card)
    $stmt = $conn->prepare("
        SELECT customer_name, email, order_date, status, payment_status,
               shipment_status, delivery_status, total_amount, id AS order_id
        FROM orders
        WHERE id = ? LIMIT 1
    ");
    $stmt->bind_param("i", $order_id);
}

$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();

if (!$order) die("❌ Order not found.");

// Step 3: Get order items
$order_id = $order['order_id'] ?? $order['order_id'];
$stmt_items = $conn->prepare("
    SELECT oi.id AS order_item_id, oi.product_id, oi.quantity, oi.price, p.name
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$stmt_items->bind_param("i", $order_id);
$stmt_items->execute();
$result_items = $stmt_items->get_result();
$items = [];
while ($row = $result_items->fetch_assoc()) {
    $items[] = $row;
}
$stmt_items->close();

// Step 4: Mark payment as Paid if token exists and not yet updated
$already_paid = false;
if ($token) {
    $stmt_check = $conn->prepare("SELECT payment_status FROM payments WHERE payment_token=? LIMIT 1");
    $stmt_check->bind_param("s", $token);
    $stmt_check->execute();
    $payment = $stmt_check->get_result()->fetch_assoc();
    $stmt_check->close();

    if ($payment && $payment['payment_status'] === 'Paid') {
        $already_paid = true;
    } elseif ($payment) {
        // Update payment status
        $stmt_update = $conn->prepare("UPDATE payments SET payment_status='Paid', payment_date=NOW() WHERE payment_token=?");
        $stmt_update->bind_param("s", $token);
        $stmt_update->execute();
        $stmt_update->close();

        // Update order status
        $stmt_update_order = $conn->prepare("UPDATE orders SET payment_status='Paid', order_status='Processing' WHERE id=?");
        $stmt_update_order->bind_param("i", $order_id);
        $stmt_update_order->execute();
        $stmt_update_order->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payment Success - BHEINIS</title>
<link rel="stylesheet" href="assets2/style2.css">
<link rel="stylesheet" href="assets2/cart.css">
<style>
body {
    font-family: 'Arial', sans-serif;
    background: #f6f6f6;
    margin: 0;
    padding: 0;
    color: #333;
}
.top-header, .main-nav { box-shadow: 0 4px 12px rgba(0,0,0,0.05); }

.receipt-container {
    max-width: 900px;
    margin: 50px auto;
    background: linear-gradient(145deg, #ffffff, #fff1f3);
    padding: 40px 50px;
    border-radius: 25px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}
.receipt-container:hover { box-shadow: 0 20px 50px rgba(0,0,0,0.15); }

h1 {
    text-align: center;
    color: #ff4d6d;
    font-size: 36px;
    letter-spacing: 1px;
    margin-bottom: 10px;
}
p.subtitle {
    text-align: center;
    font-size: 16px;
    color: #555;
    margin-bottom: 35px;
}

.order-summary, .order-info, .items-table {
    margin-bottom: 30px;
    padding: 25px 30px;
    border-radius: 18px;
    background: #fff;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}
.order-summary:hover, .order-info:hover, .items-table:hover { box-shadow: 0 10px 25px rgba(0,0,0,0.08); }

.order-summary h2, .order-info h2, .items-table h2 {
    font-size: 22px;
    color: #ff4d6d;
    border-bottom: 2px solid #ff4d6d;
    padding-bottom: 8px;
    margin-bottom: 18px;
}

.order-summary p, .order-info p { font-size: 15px; margin: 8px 0; }

table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 15px;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}
table th, table td { padding: 15px 10px; text-align: center; font-size: 15px; }
table th { background: linear-gradient(90deg, #ff4d6d, #ff758f); color: #fff; }
table tr:nth-child(even) { background: #ffe6eb; }
table tr:nth-child(odd) { background: #fff0f4; }

.total {
    text-align: right;
    font-size: 22px;
    margin-top: 25px;
    font-weight: bold;
    color: #000;
}

.btn-container { text-align: center; margin-top: 35px; }
.btn {
    display: inline-block;
    background: linear-gradient(90deg, #ff4d6d, #ff758f);
    color: #fff;
    padding: 12px 25px;
    text-decoration: none;
    border-radius: 15px;
    margin: 8px;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
}
.btn:hover {
    background: linear-gradient(90deg, #ff758f, #ff4d6d);
    transform: translateY(-3px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.2);
}

@media screen and (max-width: 768px) {
    .receipt-container { padding: 25px 20px; }
    table th, table td { font-size: 13px; padding: 10px; }
}
</style>
</head>
<body>

<!-- Top Header -->
<div class="top-header">
  <div class="logo-search-container">
    <a href="home.php" class="logo-link">
      <img src="assets2/logo.png" alt="BHEINIS Logo" class="logo-img" />
    </a>
    <form action="search.php" method="GET" class="search-form">
      <input type="text" name="q" placeholder="Search products..." />
      <button type="submit">Search</button>
    </form>
  </div>
  <div class="right">
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="logout.php">Logout</a>
      <a href="account.php">Account</a>
      <a href="my_orders.php">My Orders</a>
      <a href="cart.php">Cart</a>
    <?php else: ?>
      <a href="login.php">Login</a>
    <?php endif; ?>
  </div>
</div>

<!-- Navigation Bar -->
<nav class="main-nav">
  <a href="women.php">WOMENS</a>
  <a href="men.php">MENS</a>
  <a href="kids.php">KIDS</a>
  <a href="scarf.php">SCARF</a>
</nav>

<!-- Receipt Section -->
<div class="receipt-container">
  <h1>✅ Payment Successful</h1>
  <p class="subtitle">Thank you for your order! Review your order summary and receipt below.</p>

  <!-- Order Summary -->
  <div class="order-summary">
    <h2>Order Summary</h2>
    <p><strong>Order ID:</strong> <?= htmlspecialchars($order_id) ?></p>
    <p><strong>Date:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
    <p><strong>Total Amount:</strong> RM <?= number_format($order['total_amount'], 2) ?></p>
    <p><strong>Delivery Method:</strong> <?= htmlspecialchars($order['delivery_status']) ?></p>
    <p><strong>Shipment Status:</strong> <?= htmlspecialchars($order['shipment_status']) ?></p>
  </div>

  <!-- Customer Info -->
  <div class="order-info">
    <h2>Customer Details</h2>
    <p><strong>Name:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
    <p><strong>Payment:</strong> <?= htmlspecialchars($order['payment_status']) ?></p>
  </div>

  <!-- Items Table -->
  <div class="items-table">
    <h2>Items Ordered</h2>
    <table>
      <tr>
        <th>Product</th>
        <th>Price (RM)</th>
        <th>Quantity</th>
        <th>Subtotal (RM)</th>
      </tr>
      <?php foreach ($items as $item): ?>
        <tr>
          <td><?= htmlspecialchars($item['name']) ?></td>
          <td><?= number_format($item['price'], 2) ?></td>
          <td><?= htmlspecialchars($item['quantity']) ?></td>
          <td><?= number_format($item['price'] * $item['quantity'], 2) ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>

  <!-- Total -->
  <p class="total">TOTAL: RM <?= number_format($order['total_amount'], 2) ?></p>

  <!-- Buttons -->
  <div class="btn-container">
    <a href="home.php" class="btn">🛍️ Continue Shopping</a>
    <a href="my_orders.php" class="btn">📦 View My Orders</a>
    <a href="#" class="btn" onclick="printReceipt(); return false;">🖨️ Print Receipt</a>
  </div>
</div>

<!-- Footer -->
<footer class="footer">
  <div class="footer-bottom">
    <p>&copy; 2025 BHEINIS.</p>
  </div>
</footer>

<!-- Print Receipt Script -->
<script>
function printReceipt() {
    var receiptContent = document.querySelector('.receipt-container').innerHTML;
    var originalContent = document.body.innerHTML;

    document.body.innerHTML = receiptContent;
    window.print();
    document.body.innerHTML = originalContent;
    location.reload();
}
</script>
</body>
</html>
