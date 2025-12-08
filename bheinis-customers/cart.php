<?php 
include 'db.php'; 
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

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Get cart
$stmt = $conn->prepare("SELECT id FROM cart WHERE user_id = ? AND status = 'open' LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();

$items = [];
$total = 0;

if ($res->num_rows > 0) {
    $cart_id = $res->fetch_assoc()['id'];

    $sql = "SELECT ci.id AS cart_item_id, p.id AS product_id, p.name, p.image, p.price, ci.size, ci.quantity,
                   IFNULL(ci.color,'') AS color
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.id
            WHERE ci.cart_id = ?";
    $stmt2 = $conn->prepare($sql);
    $stmt2->bind_param("i", $cart_id);
    $stmt2->execute();
    $resultItems = $stmt2->get_result();

    while ($row = $resultItems->fetch_assoc()) {
        $row['subtotal'] = $row['price'] * $row['quantity'];
        $total += $row['subtotal'];
        $items[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Your Cart - BHEINIS</title>
  <link rel="stylesheet" href="assets2/style2.css" />
  <link rel="stylesheet" href="assets2/cart.css" />
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

<section class="cart-section">
  <h1>Your Shopping Cart</h1>

  <?php if (empty($items)): ?>
    <p class="no-products-msg">🛒 Your cart is currently empty.</p>
  <?php else: ?>
    <table class="cart-table">
      <thead>
        <tr>
          <th>Product</th>
          <th>Name</th>
          <th>Size</th>
          <th>Color</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $item): ?>
          <tr>
            <td><img src="<?= !empty($item['image']) ? "../uploads/{$item['image']}" : "assets2/no-image.png" ?>" class="cart-img" /></td>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><?= htmlspecialchars($item['size']) ?></td>
            <td>
              <?php if (!empty($item['color'])): ?>
                <span style="display:inline-block; width:16px; height:16px; border-radius:50%; background:<?= htmlspecialchars($item['color']) ?>; border:1px solid #888; vertical-align:middle;"></span>
                <span style="margin-left:6px;"><?= htmlspecialchars($item['color']) ?></span>
              <?php else: ?>
                -
              <?php endif; ?>
            </td>
            <td>RM <?= number_format($item['price'], 2) ?></td>
            <td>
              <div class="quantity-control">
                <a href="update_cart.php?id=<?= $item['cart_item_id'] ?>&action=decrease"
                   class="qty-btn"
                   onclick="return confirmDecrease(<?= $item['quantity'] ?>);">−</a>
                <span><?= $item['quantity'] ?></span>
                <a href="update_cart.php?id=<?= $item['cart_item_id'] ?>&action=increase" class="qty-btn">+</a>
              </div>
            </td>
            <td>RM <?= number_format($item['subtotal'], 2) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="cart-total">
      <h2>Total: RM <?= number_format($total, 2) ?></h2>
      <a href="payment.php" class="checkout-btn">Checkout</a>
    </div>
  <?php endif; ?>
</section>

<footer class="footer">
  <div class="footer-bottom">
    <p>&copy; 2025 BHEINIS.</p>
  </div>
</footer>

<script>
function confirmDecrease(quantity) {
  if (quantity <= 1) {
    return confirm("Are you sure you want to remove this item from your cart?");
  }
  return true;
}
</script>

</body>
</html>
