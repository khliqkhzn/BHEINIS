<?php
session_start();
include '../db.php'; 
require_once 'PHPGangsta/GoogleAuthenticator.php';

// ---------------------------
// 🔐 LOGIN ATTEMPT SETTINGS
// ---------------------------
$BLOCK_MINUTES = 30;
$MAX_ATTEMPTS = 3;

// Function to check if user is blocked
function isBlocked($conn, $email, $BLOCK_MINUTES, $MAX_ATTEMPTS) {
    $stmt = $conn->prepare("SELECT attempts, last_attempt FROM login_attempts WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if ($row['attempts'] >= $MAX_ATTEMPTS) {
            $last_attempt_time = strtotime($row['last_attempt']);
            $now = time();
            if ($now - $last_attempt_time < ($BLOCK_MINUTES * 60)) {
                return $row['last_attempt']; // return last attempt time for countdown
            } else {
                // Reset attempts after block period
                $reset = $conn->prepare("UPDATE login_attempts SET attempts = 0 WHERE email = ?");
                $reset->bind_param("s", $email);
                $reset->execute();
            }
        }
    }
    return false;
}

// Function to increase failed attempts
function addAttempt($conn, $email) {
    $stmt = $conn->prepare("INSERT INTO login_attempts (email, attempts, last_attempt)
                            VALUES (?, 1, NOW())
                            ON DUPLICATE KEY UPDATE attempts = attempts + 1, last_attempt = NOW()");
    $stmt->bind_param("s", $email);
    $stmt->execute();
}

// Function to reset attempts after successful login
function resetAttempts($conn, $email) {
    $stmt = $conn->prepare("UPDATE login_attempts SET attempts = 0 WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
}

// ---------------------------
// Fetch skip_days for User
// ---------------------------
$skip_sql = "SELECT skip_days FROM otp_skip_settings WHERE role = 'user' LIMIT 1";
$skip_result = $conn->query($skip_sql);
$skip_days = ($skip_result && $skip_result->num_rows > 0) ? $skip_result->fetch_assoc()['skip_days'] : 0;

// ---------------------------
// Auto-login using remember me cookie
// ---------------------------
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    $stmt = $conn->prepare("SELECT id, remember_token, email FROM users");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($user = $result->fetch_assoc()) {
        if (password_verify($token, $user['remember_token'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];

            // Log activity (Auto Login)
            $activity_type = "Auto Login";
            $activity_details = "User logged in using remember me cookie";
            $log = $conn->prepare("INSERT INTO customer_activity (user_id, activity_type, activity_details) VALUES (?, ?, ?)");
            $log->bind_param("iss", $user['id'], $activity_type, $activity_details);
            $log->execute();

            header("Location: home.php");
            exit;
        }
    }
}

// ---------------------------
// Handle POST login
// ---------------------------
$blocked_until = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Check if blocked
    $blocked_time = isBlocked($conn, $email, $BLOCK_MINUTES, $MAX_ATTEMPTS);
    if ($blocked_time) {
        $_SESSION['error'] = "Too many failed attempts. Please wait $BLOCK_MINUTES minutes.";
        $_SESSION['blocked_until'] = strtotime($blocked_time) + ($BLOCK_MINUTES * 60);
        header("Location: login.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT id, password, totp_secret FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $hashed_password, $totp_secret);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            resetAttempts($conn, $email);

            // Check trusted browser
            if (isset($_COOKIE['trusted_browser'])) {
                $browser_token = $_COOKIE['trusted_browser'];
                $check_stmt = $conn->prepare("SELECT expires_at FROM trusted_browsers WHERE user_id = ? AND browser_token = ?");
                $check_stmt->bind_param("is", $user_id, $browser_token);
                $check_stmt->execute();
                $result = $check_stmt->get_result();

                if ($row = $result->fetch_assoc()) {
                    if (strtotime($row['expires_at']) > time()) {
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['email'] = $email;

                        $activity_type = "Login";
                        $activity_details = "User logged in using trusted browser (skip OTP)";
                        $log = $conn->prepare("INSERT INTO customer_activity (user_id, activity_type, activity_details) VALUES (?, ?, ?)");
                        $log->bind_param("iss", $user_id, $activity_type, $activity_details);
                        $log->execute();

                        header("Location: home.php");
                        exit;
                    }
                }
            }

            // Otherwise require OTP
            $_SESSION['temp_user'] = $user_id;
            $_SESSION['temp_email'] = $email;
            $_SESSION['totp_secret'] = $totp_secret;
            $_SESSION['skip_days'] = $skip_days;
            $_SESSION['skip_otp_selected'] = isset($_POST['skip_otp']) ? 1 : 0;

            header('Location: verify_totp.php');
            exit;

        } else {
            addAttempt($conn, $email);
            $_SESSION['error'] = "Incorrect password.";
        }
    } else {
        $_SESSION['error'] = "No user found with that email.";
    }

    $stmt->close();
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>BHEINIS - Login</title>
<link rel="stylesheet" href="assets2/style2.css" />
<style>
/* Wrapper for checkbox + text */
.remember-container {
  margin: 12px 0 18px 0;
  font-size: 14px;
  color: #333;
  text-align: left;
  font-family: 'Montserrat', sans-serif;
}
.remember-container label {
  display: inline-flex;
  align-items: center;
  cursor: pointer;
}
.remember-container input[type="checkbox"] {
  margin-right: 1px;
  transform: scale(1.1);
  cursor: pointer;
}
.remember-container .note {
  display: block;
  font-size: 12px;
  color: #777;
  margin: 4px 0 0 24px;
  line-height: 1.4;
}
.password-container {
  position: relative;
  width: 100%;
}
.password-container input {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 14px;
}
.password-container .toggle-password {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  font-size: 18px;
  user-select: none;
}
#countdown {
  color: red;
  font-weight: bold;
  margin-bottom: 12px;
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
      <a href="login.php">User Login</a>
      <span style="margin:0 5px;">|</span>
      <a href="../bheinis-admin/login.php">Admin Login</a>
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

<!-- Login Form Section -->
<section class="login-section">
  <div class="logo-center">
    <img src="assets2/logo.png" alt="BHEINIS Logo" class="login-logo">
  </div>

  <h2>Login</h2>

  <?php if (isset($_SESSION['error'])): ?>
    <p style="color:red;"> <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?> </p>
  <?php endif; ?>

  <?php if (isset($_SESSION['blocked_until'])): 
        $blocked_time = $_SESSION['blocked_until'];
        unset($_SESSION['blocked_until']);
  ?>
    <div id="countdown"></div>
    <script>
      let countDownDate = <?php echo $blocked_time * 1000; ?>;
      let x = setInterval(function() {
        let now = new Date().getTime();
        let distance = countDownDate - now;
        if (distance < 0) {
          clearInterval(x);
          document.getElementById("countdown").innerHTML = "You can now login.";
        } else {
          let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          let seconds = Math.floor((distance % (1000 * 60)) / 1000);
          document.getElementById("countdown").innerHTML = "You can login again in " + minutes + "m " + seconds + "s";
        }
      }, 1000);
    </script>
  <?php endif; ?>

  <form method="POST" action="login.php" class="login-form">
    <input type="email" name="email" placeholder="Email" required /><br />

    <div class="password-container">
      <input type="password" id="password" name="password" placeholder="Password" required />
      <span class="toggle-password" onclick="togglePassword('password', this)">👁️</span>
    </div>

    <!-- Skip OTP -->
    <div class="remember-container">
      <label style="font-weight:600;">
        <input type="checkbox" name="skip_otp" value="1">
        <span>Remember this device (skip OTP)</span>
      </label>
      <?php if ($skip_days > 0): ?>
        <p class="note">If selected, OTP will be skipped for <strong><?php echo $skip_days; ?> days</strong> on this browser.</p>
      <?php endif; ?>
    </div>

    <button type="submit">Login</button>

    <p><a href="forgot_password.php" style="font-size:14px; color:#007bff; text-decoration:none;">Forgot Password?</a></p>
  </form>

  <p>Don't have an account? <a href="register.php">Register here</a>.</p>
</section>

<!-- Footer -->
<footer class="footer">
  <div class="footer-bottom">
    <p>&copy; 2025 BHEINIS.</p>
  </div>
</footer>

<script>
function togglePassword(id, el) {
  const input = document.getElementById(id);
  if (input.type === "password") {
    input.type = "text";
    el.textContent = "👁️";
  } else {
    input.type = "password";
    el.textContent = "🙈";
  }
}
</script>
</body>
</html>
