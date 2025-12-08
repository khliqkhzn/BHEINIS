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

// ✅ Fetch user details for autofill
$stmt_user = $conn->prepare("SELECT name, email, phone, address_line1, address_line2, state, postal_code, city FROM users WHERE id = ?");
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();

// ✅ Get open cart
$stmt = $conn->prepare("SELECT id FROM cart WHERE user_id = ? AND status = 'open' LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();

$total = 0;
$cart_id = null;

if ($res->num_rows > 0) {
    $cart_id = $res->fetch_assoc()['id'];

    $sql = "SELECT ci.id AS cart_item_id, p.id AS product_id, p.name, p.price, ci.size, ci.quantity
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.id
            WHERE ci.cart_id = ?";
    $stmt2 = $conn->prepare($sql);
    $stmt2->bind_param("i", $cart_id);
    $stmt2->execute();
    $resultItems = $stmt2->get_result();

    while ($row = $resultItems->fetch_assoc()) {
        $total += $row['price'] * $row['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment - BHEINIS</title>
  <link rel="stylesheet" href="assets2/style2.css" />
  <link rel="stylesheet" href="assets2/cart.css" />
  <style>
    body { background: #fafafa; }
    .payment-section { max-width: 1100px; margin: 40px auto; padding: 20px; }
    .payment-container { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
    .card-box { background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
    h2 { font-size: 18px; margin-bottom: 20px; letter-spacing: 2px; border-bottom: 2px solid #000; padding-bottom: 8px; }
    input, select { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; margin-bottom: 15px; font-size: 14px; background: #fdfdfd; transition: border-color 0.3s ease; }
    input:focus, select:focus { border-color: #6c63ff; outline: none; background: #fff; }
    .inline-inputs { display: flex; gap: 15px; }
    .summary-box { margin-top: 40px; text-align: right; background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
    .summary-box p { font-size: 18px; margin-bottom: 15px; }
    .checkout-btn { background: #000; color: #fff; padding: 14px 32px; border: none; border-radius: 8px; cursor: pointer; font-size: 15px; font-weight: bold; transition: background 0.3s ease; }
    .checkout-btn:hover { background: #333; }
    label { display: block; margin-bottom: 8px; font-size: 13px; font-weight: bold; }
    .delivery-options { display: flex; gap: 20px; }
    .delivery-option { flex: 1; border: 2px solid #ddd; border-radius: 8px; padding: 20px; text-align: center; font-size: 15px; cursor: pointer; transition: all 0.3s ease; background: #fafafa; }
    .delivery-option:hover { border-color: #6c63ff; background: #f5f5ff; }
    .delivery-option input { display: none; }
    .delivery-option.active { border-color: #6c63ff; background: #ecebff; font-weight: bold; }
    .address-section { margin-top: 20px; }
    .error-message { color: red; font-weight: bold; margin-bottom: 20px; text-align: center; }
    .hidden { display: none; }
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

<!-- ✅ Payment Section -->
<section class="payment-section">
  <h1 style="text-align:center; margin-bottom:30px;">Secure Payment</h1>

  <?php if(isset($_SESSION['checkout_error'])): ?>
      <p class="error-message"><?= $_SESSION['checkout_error']; unset($_SESSION['checkout_error']); ?></p>
  <?php endif; ?>

  <form action="process_payment.php" method="POST">
    <div class="payment-container">

      <!-- Delivery -->
      <div class="card-box">
        <h2>DELIVERY METHOD</h2>
        <div class="delivery-options">
          <label class="delivery-option active">
            <input type="radio" name="delivery" value="ship" checked>
            🚚 Ship to Address
          </label>
          <label class="delivery-option">
            <input type="radio" name="delivery" value="pickup">
            🏬 Pickup in Store
          </label>
        </div>

        <div class="address-section" id="addressSection">
          <h2>DELIVERY ADDRESS</h2>
          <label>Full Name</label>
          <input type="text" name="full_name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
          <label>Address Line 1</label>
          <input type="text" name="address" value="<?= htmlspecialchars($user['address_line1'] ?? '') ?>" required>
          <label>Address Line 2</label>
          <input type="text" name="address2" value="<?= htmlspecialchars($user['address_line2'] ?? '') ?>">
          <div class="inline-inputs">
            <div style="flex:1;">
              <label>Postcode</label>
              <input type="text" name="postcode" value="<?= htmlspecialchars($user['postal_code'] ?? '') ?>" required>
            </div>
            <div style="flex:1;">
              <label>City</label>
              <input type="text" name="city" value="<?= htmlspecialchars($user['city'] ?? '') ?>" required>
            </div>
            <div style="flex:1;">
              <label>State</label>
              <input type="text" name="state" value="<?= htmlspecialchars($user['state'] ?? '') ?>" required>
            </div>
          </div>
          <label>Phone Number</label>
          <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" required>
        </div>
      </div>

      <!-- Payment -->
      <div class="card-box">
        <h2>PAYMENT METHOD</h2>

        <!-- Choose Payment Type -->
        <select id="paymentMethod" name="payment_method" required>
          <option value="card" selected>💳 Credit/Debit Card</option>
          <option value="ewallet">📱 E-Wallet</option>
        </select>

        <!-- Card Payment Fields -->
        <div id="cardFields">
          <label>Name on Card</label>
          <input type="text" name="card_name">
          <label>Card Number</label>
          <input type="text" name="card_number" id="card_number" maxlength="19" placeholder="0000 0000 0000 0000">
          <div class="inline-inputs">
            <div style="flex:1;">
              <label>CVC</label>
              <input type="text" name="cvc" pattern="\d{3}" maxlength="3" placeholder="3-digit CVC">
            </div>
            <div style="flex:1;">
              <label>Expiry (MM/YY)</label>
              <input type="text" name="expiry">
            </div>
          </div>
        </div>

        <!-- E-Wallet Payment Fields -->
        <div id="ewalletFields" class="hidden">
          <label>Select E-Wallet</label>
          <select name="ewallet_type">
            <option value="">-- Select E-Wallet --</option>
            <option value="tng">Touch 'n Go</option>
            <option value="grabpay">GrabPay</option>
            <option value="shopeepay">ShopeePay</option>
            <option value="boost">Boost</option>
          </select>

          <label>E-Wallet Phone Number / ID</label>
          <input type="text" name="ewallet_id" placeholder="Enter registered e-wallet phone number or ID">
        </div>
      </div>
    </div>

    <div class="summary-box">
      <p><strong>SUBTOTAL:</strong> RM <?= number_format($total, 2) ?></p>
      <input type="hidden" name="amount" value="<?= $total ?>">
      <input type="hidden" name="cart_id" value="<?= $cart_id ?>">
      <button type="submit" class="checkout-btn">💳 PAY NOW</button>
    </div>
  </form>
</section>

<footer class="footer">
  <div class="footer-bottom">
    <p>&copy; 2025 BHEINIS.</p>
  </div>
</footer>

<script>
const cardInput = document.getElementById('card_number');
cardInput.addEventListener('input', function() {
  let value = this.value.replace(/\D/g, '');
  value = value.substring(0,16);
  this.value = value.replace(/(\d{4})/g, '$1 ').trim();
});

document.getElementById('paymentMethod').addEventListener('change', function() {
  const method = this.value;
  const cardFields = document.getElementById('cardFields');
  const ewalletFields = document.getElementById('ewalletFields');

  if (method === 'ewallet') {
    cardFields.classList.add('hidden');
    ewalletFields.classList.remove('hidden');
  } else {
    ewalletFields.classList.add('hidden');
    cardFields.classList.remove('hidden');
  }
});

// ✅ Delivery toggle
document.addEventListener("DOMContentLoaded", function() {
  const deliveryOptions = document.querySelectorAll(".delivery-option input");
  const addressSection = document.getElementById("addressSection");

  function toggleDelivery() {
    document.querySelectorAll(".delivery-option").forEach(opt => opt.classList.remove("active"));
    this.parentElement.classList.add("active");

    if (this.value === "pickup") {
      addressSection.style.display = "none";
      addressSection.querySelectorAll("input").forEach(input => {
        input.disabled = true;
        input.required = false;
      });
    } else {
      addressSection.style.display = "block";
      addressSection.querySelectorAll("input").forEach(input => {
        input.disabled = false;
        if (input.name !== "address2") input.required = true;
      });
    }
  }

  deliveryOptions.forEach(option => {
    option.addEventListener("change", toggleDelivery);
    if (option.checked) toggleDelivery.call(option);
  });
});
</script>
</body>
</html>
