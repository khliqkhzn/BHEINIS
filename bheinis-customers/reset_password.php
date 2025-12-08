<?php
session_start();
require 'db.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if token exists and not expired
    $stmt = $conn->prepare("SELECT id, password, reset_expires FROM users WHERE reset_token=? LIMIT 1");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $old_password_hash, $reset_expires);
    $stmt->fetch();

    if ($stmt->num_rows === 1 && strtotime($reset_expires) > time()) {

        // Handle form submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);

            // ✅ Validation rules
            $errors = [];

            if ($password !== $confirm_password) {
                $errors[] = "Passwords do not match.";
            }
            if (strlen($password) < 8) {
                $errors[] = "Password must be at least 8 characters.";
            }
            if (!preg_match("/[A-Z]/", $password)) {
                $errors[] = "Password must include at least 1 uppercase letter.";
            }
            if (!preg_match("/[a-z]/", $password)) {
                $errors[] = "Password must include at least 1 lowercase letter.";
            }
            if (!preg_match("/[0-9]/", $password)) {
                $errors[] = "Password must include at least 1 number.";
            }
            if (!preg_match("/[!@#$%^&*]/", $password)) {
                $errors[] = "Password must include at least 1 special character (!@#$%^&*).";
            }

            // ✅ Check if new password is same as old
            if (password_verify($password, $old_password_hash)) {
                $errors[] = "New password cannot be the same as your previous password.";
            }

            if (!empty($errors)) {
                $_SESSION['error'] = implode("<br>", $errors);
            } else {
                $new_password_hash = password_hash($password, PASSWORD_BCRYPT);

                // Update password & clear reset token
                $update = $conn->prepare("UPDATE users SET password=?, reset_token=NULL, reset_expires=NULL WHERE id=?");
                $update->bind_param("si", $new_password_hash, $user_id);
                $update->execute();

                $_SESSION['success'] = "✅ Password reset successful. Please login with your new password.";
                header("Location: login.php");
                exit;
            }
        }

    } else {
        $_SESSION['error'] = "Invalid or expired reset link.";
        header("Location: forgot_password.php");
        exit;
    }
} else {
    $_SESSION['error'] = "No reset token provided.";
    header("Location: forgot_password.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>BHEINIS - Reset Password</title>
<link rel="stylesheet" href="assets2/style2.css" />
<style>
.login-form input[type="password"], 
.login-form input[type="text"] {
  width: 100%;
  padding: 12px;
  margin: 10px 0;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 14px;
  outline: none;
}
.login-form button.reset-btn {
  width: 100%;
  padding: 14px;
  background-color: #000;
  color: #fff;
  font-weight: bold;
  font-size: 15px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: 0.3s ease;
}
.login-form button.reset-btn:hover { background-color: #333; }

.password-container { position: relative; width: 100%; }
.password-container input {
  width: 100%; padding: 12px; border: 1px solid #ccc; border-radius:6px; font-size:14px;
}
.password-container .toggle-password {
  position: absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; font-size:18px; user-select:none;
}
.password-requirements {
  font-size:13px; color:#555; margin-bottom:10px;
}
</style>
</head>
<body>

<!-- Header -->
<div class="top-header">
  <div class="logo-search-container">
    <a href="home.php" class="logo-link"><img src="assets2/logo.png" alt="BHEINIS Logo" class="logo-img"></a>
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

<section class="login-section">
  <div class="logo-center"><img src="assets2/logo.png" alt="BHEINIS Logo" class="login-logo"></div>
  <h2>Reset Password</h2>

  <?php if (isset($_SESSION['error'])): ?>
    <p style="color:red;"> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?> </p>
  <?php endif; ?>
  <?php if (isset($_SESSION['success'])): ?>
    <p style="color:green;"> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?> </p>
  <?php endif; ?>

  <form method="POST" action="" class="login-form">
    <div class="password-requirements">
      Password must be at least 8 characters, include uppercase, lowercase, number, and special character.<br>
      You cannot reuse your old password.
    </div>
    <div class="password-container">
      <input type="password" id="password" name="password" placeholder="Enter new password" required />
      <span class="toggle-password" onclick="togglePassword('password', this)">👁️</span>
    </div>
    <div class="password-container">
      <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required />
      <span class="toggle-password" onclick="togglePassword('confirm_password', this)">👁️</span>
    </div>
    <button type="submit" class="reset-btn">Reset Password</button>
  </form>
  <p><a href="login.php">Back to Login</a></p>
</section>

<footer class="footer">
  <div class="footer-bottom">
    <p>&copy; 2025 BHEINIS.</p>
  </div>
</footer>

<script>
function togglePassword(id, el) {
  const input = document.getElementById(id);
  input.type = input.type === "password" ? "text" : "password";
  el.textContent = input.type === "password" ? "👁️" : "🙈";
}
</script>
</body>
</html>
