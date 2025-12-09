<?php
session_start();
include '../db.php'; 
require_once 'PHPGangsta/GoogleAuthenticator.php';

if (!isset($_GET['user_id'])) {
    die("Invalid access.");
}

$user_id = intval($_GET['user_id']);

// Fetch user info
$stmt = $conn->prepare("SELECT name, email, totp_secret FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("User not found.");
}

$user = $result->fetch_assoc();
$name = $user['name'];
$email = $user['email'];
$secret = $user['totp_secret'];

$ga = new PHPGangsta_GoogleAuthenticator();
$qrCodeUrl = $ga->getQRCodeGoogleUrl('BHEINIS', $secret, $email);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Setup Google Authenticator | BHEINIS</title>
  <link rel="stylesheet" href="assets2/style2.css" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Montserrat:wght@400;500&display=swap" rel="stylesheet" />
  <style>
    .instruction-list {
      text-align: left;
      max-width: 900px;
      margin: 20px auto;
      padding: 20px;
      background: #f9f9f9;
      border: 2px solid #ddd;
      border-radius: 4px;
      font-size: 14px;
      line-height: 1.6;
    }
    .instruction-list li {
      margin-bottom: 8px;
    }
    .qr-box {
      margin: 20px 0;
    }
  </style>
</head>
<body>

<!-- Top Header -->
<div class="top-header">
  <div class="logo-search-container">
    <a href="home.php" class="logo-link">
      <img src="assets2/logo.png" alt="BHEINIS Logo" class="logo-img">
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

<!-- QR Section -->
<section class="register-section">
  <h2>Setup Google Authenticator</h2>
  <p>Welcome, <b><?php echo htmlspecialchars($name); ?></b>! Please complete the steps below to secure your account.</p>

  <div class="instruction-list">
    <ol>
      <li>Download and install <b>Google Authenticator</b> on your phone (from Play Store or App Store).</li>
      <li>Open the app and tap the <b>“+”</b> button to add a new account.</li>
      <li>Select <b>“Scan QR Code”</b> and scan the QR code below.</li>
      <li>If you cannot scan, you can enter the secret key manually.</li>
      <li>Each time you log in, you’ll be asked for a 6-digit code from the app.</li>
    </ol>
  </div>

  <div class="qr-box">
    <p><b>Scan this QR Code with Google Authenticator:</b></p>
    <img src="<?php echo $qrCodeUrl; ?>" alt="QR Code"><br><br>
    <p>Secret Key (backup): <b><?php echo htmlspecialchars($secret); ?></b></p>
  </div>

  <p><a href="login.php">✅ Proceed to Login</a></p>
</section>

<!-- Footer -->
<footer class="footer">
  <div class="footer-bottom">
    <p>&copy; 2025 BHEINIS.</p>
  </div>
</footer>

</body>
</html>
