<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['email'] ?? ''; // use session email

// Fetch all return requests for this email
$sql = "SELECT r.id AS return_id, r.order_id, p.name AS product_name, 
               r.quantity, r.reason, r.image, r.status, r.request_date
        FROM returns r
        JOIN products p ON r.product_id = p.id
        WHERE r.email = ?
        ORDER BY r.request_date DESC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die('❌ SQL prepare failed: ' . $conn->error);
}

$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Return Requests - BHEINIS</title>
<link rel="stylesheet" href="assets2/style2.css">
<style>

.container {
    max-width: 1000px;
    margin: 40px auto;
    padding: 0 20px;
}
h2 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
    font-size: 28px;
    font-weight: 600;
}
.return-card {
    display: flex;
    flex-wrap: wrap;
    background: #fff;
    margin-bottom: 20px;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}
.return-card:hover {
    transform: translateY(-3px);
}
.return-image {
    flex: 0 0 100px;
    height: 100px;
    margin-right: 20px;
}
.return-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
    border: 1px solid #ddd;
}
.return-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.return-details h3 {
    margin: 0;
    font-size: 20px;
    color: #111;
}
.return-details p {
    margin: 4px 0;
    color: #555;
    font-size: 14px;
}
.status {
    font-weight: bold;
    padding: 6px 12px;
    border-radius: 10px;
    display: inline-block;
    text-align: center;
    width: 100px;
}
.status.Pending { background: #f0ad4e; color: #fff; }
.status.Approved { background: #5cb85c; color: #fff; }
.status.Rejected { background: #d9534f; color: #fff; }
.back-btn {
    display: block;
    width: 200px;
    margin: 30px auto;
    background: #000;
    color: #fff;
    text-align: center;
    padding: 12px 0;
    border-radius: 10px;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s;
}
.back-btn:hover {
    background: #333;
}
@media(max-width: 600px){
    .return-card {
        flex-direction: column;
        align-items: center;
    }
    .return-image {
        margin-bottom: 15px;
    }
    .status {
        width: auto;
    }
}
</style>
</head>
<body>

<!-- ✅ Top Header -->
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

<!-- ✅ Navigation Bar -->
<nav class="main-nav">
  <a href="women.php">WOMENS</a>
  <a href="men.php">MENS</a>
  <a href="kids.php">KIDS</a>
  <a href="scarf.php">SCARF</a>
</nav>

<div class="container">
    <h2>My Return Requests</h2>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="return-card">
                <div class="return-image">
                    <?php if ($row['image']): ?>
                        <img src="<?= htmlspecialchars($row['image']) ?>" alt="Return Image">
                    <?php else: ?>
                        <img src="assets2/no-image.png" alt="No Image">
                    <?php endif; ?>
                </div>
                <div class="return-details">
                    <h3><?= htmlspecialchars($row['product_name']) ?></h3>
                    <p><strong>Order ID:</strong> <?= htmlspecialchars($row['order_id']) ?></p>
                    <p><strong>Quantity:</strong> <?= htmlspecialchars($row['quantity']) ?></p>
                    <p><strong>Reason:</strong> <?= htmlspecialchars($row['reason']) ?></p>
                    <p><strong>Request Date:</strong> <?= htmlspecialchars($row['request_date'] ?? '-') ?></p>
                </div>
                <div class="status <?= htmlspecialchars($row['status'] ?? 'Pending') ?>">
                    <?= htmlspecialchars($row['status'] ?? 'Pending') ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center; font-size:16px;">No return requests found.</p>
    <?php endif; ?>

    <a href="my_orders.php" class="back-btn">← Back to My Orders</a>
</div>
<!-- ✅ Footer -->
<footer class="footer">
  <div class="footer-bottom">
    <p>&copy; 2025 BHEINIS.</p>
  </div>

</footer>
</body>
</html>
