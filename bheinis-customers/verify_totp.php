<?php
session_start();
include '../db.php'; 
require_once 'PHPGangsta/GoogleAuthenticator.php';

if (!isset($_SESSION['temp_user']) || !isset($_SESSION['totp_secret'])) {
    header("Location: login.php");
    exit;
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $code = trim($_POST['totp']);
    $ga = new PHPGangsta_GoogleAuthenticator();

    $secret = $_SESSION['totp_secret'];

    if ($ga->verifyCode($secret, $code, 2)) {
        // ✅ Verification success
        $_SESSION['user_id'] = $_SESSION['temp_user'];
        $_SESSION['email'] = $_SESSION['temp_email'];

        // ✅ Log activity after OTP
        $activity_type = "Login";
        $activity_details = "User logged in after OTP verification";
        $log = $conn->prepare("INSERT INTO customer_activity (user_id, activity_type, activity_details) VALUES (?, ?, ?)");
        $log->bind_param("iss", $_SESSION['user_id'], $activity_type, $activity_details);
        $log->execute();

        // ✅ Handle skip OTP using trusted browser
        if (isset($_SESSION['skip_otp_selected']) && $_SESSION['skip_otp_selected'] == 1) {
            $skip_days = $_SESSION['skip_days'];
            $user_id = $_SESSION['temp_user'];

            // Generate secure browser token
            $browser_token = bin2hex(random_bytes(32));
            $expires_at = date('Y-m-d H:i:s', strtotime("+$skip_days days"));

            // Store in DB
            $stmt = $conn->prepare("INSERT INTO trusted_browsers (user_id, browser_token, expires_at) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $user_id, $browser_token, $expires_at);
            $stmt->execute();

            // Set cookie (HTTP only, Secure)
            setcookie("trusted_browser", $browser_token, time() + (86400 * $skip_days), "/", "", true, true);
        }

        // ✅ Clear temp sessions
        unset($_SESSION['temp_user'], $_SESSION['temp_email'], $_SESSION['totp_secret'], $_SESSION['skip_days'], $_SESSION['skip_otp_selected']);

        header("Location: home.php");
        exit;
    } else {
        $error = "Invalid authentication code!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>BHEINIS - Verify Code</title>
  <link rel="stylesheet" href="assets2/style2.css" />
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

<!-- Navigation Bar -->
<nav class="main-nav">
  <a href="women.php">WOMENS</a>
  <a href="men.php">MENS</a>
  <a href="kids.php">KIDS</a>
  <a href="scarf.php">SCARF</a>
</nav>

<!-- Reuse same design -->
<section class="login-section">
  <div class="logo-center">
    <img src="assets2/logo.png" alt="BHEINIS Logo" class="login-logo">
  </div>
  <h2>Two-Factor Authentication</h2>
  <p>Please enter the 6-digit code from your Google Authenticator app.</p>

  <?php if (!empty($error)): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
  <?php endif; ?>

  <form method="POST" class="login-form">
    <input type="text" name="totp" placeholder="123456" maxlength="6" required /><br />
    <button type="submit">Verify</button>
  </form>
</section>

<!-- Footer -->
<footer class="footer">
  <div class="footer-bottom">
    <p>&copy; 2025 BHEINIS.</p>
  </div>
</footer>
</body>
</html>
