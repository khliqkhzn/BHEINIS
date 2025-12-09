<?php 
session_start();
include '../db.php'; 
require_once 'PHPGangsta/GoogleAuthenticator.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    // Basic validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: register.php");
        exit;
    }

    // OWASP password requirement check
    if (strlen($password) < 8 ||
        !preg_match('/[A-Z]/', $password) ||
        !preg_match('/[a-z]/', $password) ||
        !preg_match('/[0-9]/', $password) ||
        !preg_match('/[\W]/', $password)) {
        $_SESSION['error'] = "Password must meet the criteria!";
        header("Location: register.php");
        exit;
    }

    if ($password !== $confirm) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: register.php");
        exit;
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Email already registered.";
        $stmt->close();
        header("Location: register.php");
        exit;
    }
    $stmt->close();

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Generate TOTP secret
    $ga = new PHPGangsta_GoogleAuthenticator();
    $secret = $ga->createSecret();

    // Insert user with TOTP secret
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, totp_secret) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed (Insert): " . $conn->error);
    }
    $stmt->bind_param("ssss", $name, $email, $hashed_password, $secret);

    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
        $stmt->close();

        // redirect to show_qr page
        header("Location: show_qr.php?user_id=" . $user_id);
        exit;
    } else {
        $_SESSION['error'] = "Registration failed: " . $stmt->error;
        $stmt->close();
        header("Location: register.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register | BHEINIS</title>
  <link rel="stylesheet" href="assets2/style2.css" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Montserrat:wght@400;500&display=swap" rel="stylesheet" />

  <style>
    .password-container {
      position: relative;
      width: 100%;
    }
    .password-container input {
      width: 100%;
      padding-right: 40px;
    }
    .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 18px;
      color: #666;
      user-select: none;
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
</div>

<!-- Navigation Bar -->
<nav class="main-nav">
  <a href="women.php">WOMENS</a>
  <a href="men.php">MENS</a>
  <a href="kids.php">KIDS</a>
  <a href="scarf.php">SCARF</a>
</nav>

<!-- Register Form Section -->
<section class="register-section">
  <h2>Register</h2>

  <?php if (isset($_SESSION['error'])): ?>
    <p class="error-message"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
  <?php endif; ?>

  <form method="POST" action="register.php" autocomplete="off" class="register-form">
    <input type="text" name="name" placeholder="Full Name" required /><br />
    <input type="email" name="email" placeholder="Email" required /><br />

    <!-- Password -->
    <div class="password-container">
      <input type="password" id="password" name="password" placeholder="Password" required />
      <span class="toggle-password" onclick="togglePassword('password', this)">👁️</span>
    </div><br />

    <div class="password-note">
      ** Password must be at least 8 characters and include:<br>
      &bull; uppercase letter<br>
      &bull; lowercase letter<br>
      &bull; number<br>
      &bull; special character
    </div>

    <!-- Confirm Password -->
    <div class="password-container">
      <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required />
      <span class="toggle-password" onclick="togglePassword('confirm_password', this)">👁️</span>
    </div><br />

    <button type="submit">Register</button>
  </form>

  <p>Already have an account? <a href="login.php">Login here</a>.</p>
</section>

<!-- Footer -->
<footer class="footer">
  <div class="footer-bottom">
    <p>&copy; 2025 BHEINIS.</p>
  </div>
</footer>

<script>
  function togglePassword(fieldId, icon) {
    const field = document.getElementById(fieldId);
    if (field.type === "password") {
      field.type = "text";
      icon.textContent = "👁️"; // mata buka
    } else {
      field.type = "password";
      icon.textContent = "🙈"; // mata tutup
    }
  }
</script>

</body>
</html>
