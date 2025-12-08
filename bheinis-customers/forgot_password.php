<?php
session_start();
require 'db.php';

// ✅ Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Generate reset token
        $token = bin2hex(random_bytes(32));
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Save token
        $stmt = $conn->prepare("UPDATE users SET reset_token=?, reset_expires=? WHERE email=?");
        $stmt->bind_param("sss", $token, $expires, $email);
        $stmt->execute();

        // ✅ Send reset email using PHPMailer
        $reset_link = "http://localhost/BHEINIS/bheinis-customers/reset_password.php?token=$token";

        $mail = new PHPMailer(true);

        try {
            // SMTP settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'nrkhaliqkha@gmail.com';   // 🔹 replace with your Gmail
            $mail->Password   = 'jhxi dqku psrm febq';     // 🔹 Gmail App Password (not normal password)
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Sender & recipient
            $mail->setFrom('nrkhaliqkha@gmail.com', 'BHEINIS Support');
            $mail->addAddress($email);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = "Password Reset Request";
            $mail->Body    = "
                <h3>Hello,</h3>
                <p>You requested a password reset. Click the link below to reset your password:</p>
                <p><a href='$reset_link'>$reset_link</a></p>
                <p>This link will expire in <strong>1 hour</strong>.</p>
                <br><p>– BHEINIS Support Team</p>
            ";

            $mail->send();
            $_SESSION['success'] = "✅ Password reset link sent to your email.";
        } catch (Exception $e) {
            $_SESSION['error'] = "❌ Email could not be sent. Error: {$mail->ErrorInfo}";
        }
    } else {
        $_SESSION['error'] = "No account found with that email.";
    }

    header("Location: forgot_password.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>BHEINIS - Forgot Password</title>
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

<!-- Forgot Password Section -->
<section class="login-section">
  <div class="logo-center">
    <img src="assets2/logo.png" alt="BHEINIS Logo" class="login-logo">
  </div>
  <h2>Forgot Password</h2>

  <?php if (isset($_SESSION['error'])): ?>
    <p style="color:red;"> <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?> </p>
  <?php endif; ?>

  <?php if (isset($_SESSION['success'])): ?>
    <p style="color:green;"> <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?> </p>
  <?php endif; ?>

  <form method="POST" action="forgot_password.php" class="login-form">
    <input type="email" name="email" placeholder="Enter your email" required /><br />
    <button type="submit">Send Reset Link</button>
  </form>

  <p><a href="login.php">Back to Login</a></p>
</section>

<!-- Footer -->
<footer class="footer">
  <div class="footer-bottom">
    <p>&copy; 2025 BHEINIS.</p>
  </div>
</footer>
</body>
</html>
