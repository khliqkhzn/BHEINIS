<?php 
include '../db.php'; 
session_start(); 

// ---------------------------------------------
// ✅ SESSION MANAGEMENT (1 MINUTE TIMEOUT)
// ---------------------------------------------
$timeout_duration = 60; // 1 minute

// If user is logged in, check timeout
if (isset($_SESSION['user_id'])) {

    if (isset($_SESSION['last_activity'])) {
        // Check inactivity time
        if ((time() - $_SESSION['last_activity']) > $timeout_duration) {

            // Destroy the old session
            session_unset();
            session_destroy();

            // Start a new session for safety
            session_start();
            session_regenerate_id(true);

            // Redirect user to login with timeout notice
            header("Location: login.php?timeout=1");
            exit;
        }
    }

    // Update last activity timestamp
    $_SESSION['last_activity'] = time();
}

// ✅ Redirect if not logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['email'];

// ✅ Query orders by email
$sql = "SELECT id, customer_name, order_date, status, payment_status, shipment_status, delivery_status, delivery_date, total_amount 
        FROM orders 
        WHERE email = ? 
        ORDER BY order_date DESC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL error: " . $conn->error);
}
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

// ✅ Collect orders and return info
$orders = [];
$hasAnyReturn = false;
if ($result->num_rows > 0):
    while ($row = $result->fetch_assoc()):
        $checkReturn = $conn->prepare("SELECT id, status FROM returns WHERE order_id = ? LIMIT 1");
        $checkReturn->bind_param("i", $row['id']);
        $checkReturn->execute();
        $returnResult = $checkReturn->get_result();
        $hasReturn = $returnResult->num_rows > 0;
        if ($hasReturn) $hasAnyReturn = true;
        $returnStatus = $hasReturn ? $returnResult->fetch_assoc()['status'] : '';

        // ✅ NEW LOGIC: Allow return ONLY within 7 days after delivery_date
        $eligibleForReturn = false;
        if (
            strtolower($row['delivery_status']) === 'delivered' &&
            !$hasReturn &&
            !empty($row['delivery_date'])
        ) {
            $deliveryDate = new DateTime($row['delivery_date']);
            $today = new DateTime();
            $daysPassed = $deliveryDate->diff($today)->days;

            if ($daysPassed < 7) {
                $eligibleForReturn = true;
            }
        }

        $orders[] = [
            'order' => $row,
            'hasReturn' => $hasReturn,
            'returnStatus' => $returnStatus,
            'eligibleForReturn' => $eligibleForReturn
        ];
    endwhile;
endif;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>My Orders | BHEINIS</title>
<link rel="stylesheet" href="assets2/style2.css" />
<style>
.orders-wrapper {
    max-width: 1100px; margin: 40px auto; background: #fff;
    padding: 25px; border-radius: 12px; box-shadow: 0 6px 16px rgba(0,0,0,0.08);
    font-family: 'Montserrat', sans-serif;
}
.orders-wrapper h2 { margin-bottom: 20px; font-size: 24px; color: #333; text-align: center; }
table { width: 100%; border-collapse: collapse; margin-top: 15px; }
th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: center; font-size: 14px; }
th { background: #111; color: #fff; }
tr:hover { background: #f9f9f9; }
.status { font-weight: bold; }
.paid { color: green; }
.pending { color: orange; }
.cancelled { color: red; }
.no-orders { text-align: center; color: #777; margin-top: 20px; }
.btn-return { background:#ff6600; color:#fff; padding:6px 12px; border-radius:6px; text-decoration:none; font-size:13px; cursor:pointer; }
.btn-return:hover { background:#cc5200; }

/* Modal styles */
.modal { display:none; position: fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background: rgba(0,0,0,0.6); }
.modal-content { background:#fff; margin:10% auto; padding:25px; border-radius:12px; width:50%; max-width:500px; box-shadow:0 4px 20px rgba(0,0,0,0.3); }
.modal-content h2 { text-align:center; color:#333; margin-bottom:15px; }
.modal-content p { font-size:14px; line-height:1.5; color:#555; }
.modal-content label { display:block; margin-top:10px; }
.modal-content button { background:#ff6600; color:#fff; border:none; padding:10px 16px; border-radius:8px; cursor:pointer; margin-top:15px; width:100%; font-weight:bold; }
.modal-content button:hover { background:#cc5200; }
.modal-content .cancel-btn { background:#aaa; margin-top:10px; }
.modal-content .cancel-btn:hover { background:#888; }
</style>
<script>
function showPolicy(orderId) {
    document.getElementById('policyModal').style.display = 'block';
    document.getElementById('modalOrderId').value = orderId;
}
function closePolicy() {
    document.getElementById('policyModal').style.display = 'none';
}
function proceedReturn() {
    const checkbox = document.getElementById('agree');
    const orderId = document.getElementById('modalOrderId').value;
    if (!checkbox.checked) {
        alert("⚠️ Please agree to the Return Policy to continue.");
        return false;
    }
    window.location.href = "request_return.php?order_id=" + orderId;
}
</script>
</head>
<body>

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

<nav class="main-nav">
  <a href="women.php">WOMENS</a>
  <a href="men.php">MENS</a>
  <a href="kids.php">KIDS</a>
  <a href="scarf.php">SCARF</a>
</nav>

<div class="orders-wrapper">
  <h2>My Orders</h2>
  <?php if (!empty($orders)): ?>
  <table>
    <tr>
      <th>Order ID</th>
      <th>Date</th>
      <th>Status</th>
      <th>Payment</th>
      <th>Shipment</th>
      <th>Delivery</th>
      <th>Total (RM)</th>
      <th>Action</th>
      <?php if ($hasAnyReturn): ?><th>My Return</th><?php endif; ?>
    </tr>
    <?php foreach ($orders as $data):
        $row = $data['order'];
    ?>
    <tr>
      <td>#<?= $row['id']; ?></td>
      <td><?= $row['order_date']; ?></td>
      <td class="status"><?= $row['status']; ?></td>
      <td class="<?= strtolower($row['payment_status']); ?>"><?= $row['payment_status']; ?></td>
      <td><?= !empty($row['shipment_status']) ? $row['shipment_status'] : "-"; ?></td>
      <td><?= !empty($row['delivery_status']) ? $row['delivery_status'] : "-"; ?></td>
      <td><?= number_format($row['total_amount'],2); ?></td>
      <td>
        <?php if ($data['eligibleForReturn']): ?>
          <span class="btn-return" onclick="showPolicy(<?= $row['id']; ?>)">Request Return</span>
        <?php elseif (strtolower($row['delivery_status']) === "delivered" && !$data['hasReturn']): ?>
          <span style="color:#888;font-size:13px;">Return period expired</span>
        <?php else: ?> - <?php endif; ?>
      </td>
      <?php if ($hasAnyReturn): ?>
      <td>
        <?php if ($data['hasReturn']): ?>
          <a href="my_return.php?order_id=<?= $row['id']; ?>" class="btn-return">View Return</a>
        <?php else: ?> - <?php endif; ?>
      </td>
      <?php endif; ?>
    </tr>
    <?php endforeach; ?>
  </table>
  <?php else: ?>
  <p class="no-orders">You have no orders yet.</p>
  <?php endif; ?>
</div>

<div id="policyModal" class="modal">
    <div class="modal-content">
        <h2>🧾 Return Request Policy</h2>
        <p><strong>Eligibility:</strong> Returns must be within 7 days of delivery. Items must be unused, unwashed, in original packaging. Sale/clearance items are non-returnable.</p>
        <p><strong>Refund / Exchange:</strong> Refunds processed in 7–10 working days after admin approval. Replacement/store credit may be offered.</p>
        <p><strong>Return Conditions:</strong> Proof of purchase and product images required. Admin may reject requests that don't meet policy.</p>
        <label><input type="checkbox" id="agree"> I have read and agree to the Return Policy</label>
        <input type="hidden" id="modalOrderId" value="">
        <button onclick="proceedReturn()">Proceed to Return Request</button>
        <button class="cancel-btn" onclick="closePolicy()">Cancel</button>
    </div>
</div>

<footer class="footer">
  <div class="footer-bottom">
    <p>&copy; 2025 BHEINIS.</p>
  </div>
</footer>

</body>
</html>
