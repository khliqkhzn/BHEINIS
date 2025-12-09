<?php
session_start();
include '../db.php'; 

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

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

// Fetch user info
$stmt = $conn->prepare("SELECT name, email, phone, address_line1, address_line2, city, state, postal_code, password FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $address1 = trim($_POST['address1']);
    $address2 = trim($_POST['address2']);
    $city     = trim($_POST['city']);
    $state    = trim($_POST['state']);
    $postal   = trim($_POST['postal_code']);
    $password = $_POST['password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($name) || empty($email)) {
        $error = "Name and Email are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // If user tries to change password
        if (!empty($new_password) || !empty($confirm_password)) {
            if (strlen($new_password) < 8 ||
                !preg_match('/[A-Z]/', $new_password) ||
                !preg_match('/[a-z]/', $new_password) ||
                !preg_match('/[0-9]/', $new_password) ||
                !preg_match('/[\W]/', $new_password)) {
                $error = "Password must be at least 8 characters and include uppercase, lowercase, number, and special character.";
            } elseif ($new_password !== $confirm_password) {
                $error = "New password and confirm password do not match.";
            } elseif (!password_verify($password, $user['password'])) {
                $error = "Current password is incorrect.";
            } elseif (password_verify($new_password, $user['password'])) {
                $error = "New password cannot be the same as your old password.";
            } else {
                // Hash new password
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            }
        }

        if (!$error) {
            if (!empty($hashed_new_password)) {
                $stmt_update = $conn->prepare("UPDATE users SET name=?, email=?, phone=?, address_line1=?, address_line2=?, city=?, state=?, postal_code=?, password=? WHERE id=?");
                $stmt_update->bind_param("sssssssssi", $name, $email, $phone, $address1, $address2, $city, $state, $postal, $hashed_new_password, $user_id);
            } else {
                $stmt_update = $conn->prepare("UPDATE users SET name=?, email=?, phone=?, address_line1=?, address_line2=?, city=?, state=?, postal_code=? WHERE id=?");
                $stmt_update->bind_param("ssssssssi", $name, $email, $phone, $address1, $address2, $city, $state, $postal, $user_id);
            }

            if ($stmt_update->execute()) {
                $success = !empty($hashed_new_password)
                    ? "Account and password updated successfully."
                    : "Account information updated successfully.";

                // Reload user info
                $user['name'] = $name;
                $user['email'] = $email;
                $user['phone'] = $phone;
                $user['address_line1'] = $address1;
                $user['address_line2'] = $address2;
                $user['city'] = $city;
                $user['state'] = $state;
                $user['postal_code'] = $postal;
            } else {
                $error = "Failed to update account: " . $stmt_update->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>My Account | BHEINIS</title>
  <link rel="stylesheet" href="assets2/style2.css" />
  <style>
    .account-wrapper {
      max-width: 1100px;
      margin: 40px auto;
      display: flex;
      gap: 30px;
      font-family: 'Montserrat', sans-serif;
    }
    .account-box {
      flex: 1;
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 6px 16px rgba(0,0,0,0.08);
    }
    .account-box h3 {
      margin-bottom: 18px;
      font-size: 22px;
      color: #333;
    }
    .form-group { margin-bottom: 15px; }
    .form-group label {
      display: block;
      font-weight: 500;
      margin-bottom: 6px;
      color: #333;
    }
    .form-group input, .form-group select {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }
    .button-container { text-align: center; margin-top: 20px; }
    .button-container button {
      padding: 12px 30px;
      background: #111;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
    }
    .button-container button:hover { background: #444; }
    .error-msg { color: red; text-align: center; margin-bottom: 10px; }
    .success-msg { color: green; text-align: center; margin-bottom: 10px; }
    .password-container { position: relative; }
    .password-container input { width: 100%; padding-right: 40px; }
    .toggle-password {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 18px;
      color: #666;
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

<div class="account-wrapper">
  <!-- Left Column: Account Info -->
  <div class="account-box">
    <h3>Account Information</h3>
    <?php if ($error): ?><p class="error-msg"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>
    <?php if ($success): ?><p class="success-msg"><?php echo htmlspecialchars($success); ?></p><?php endif; ?>

    <form method="POST" action="account.php">
      <div class="form-group"><label>Name</label><input type="text" name="name" required value="<?php echo htmlspecialchars($user['name']); ?>"></div>
      <div class="form-group"><label>Email</label><input type="email" name="email" required value="<?php echo htmlspecialchars($user['email']); ?>"></div>
      <div class="form-group"><label>Phone</label><input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"></div>
      <div class="form-group"><label>Address Line 1</label><input type="text" name="address1" required value="<?php echo htmlspecialchars($user['address_line1']); ?>"></div>
      <div class="form-group"><label>Address Line 2</label><input type="text" name="address2" value="<?php echo htmlspecialchars($user['address_line2']); ?>"></div>
      <div class="form-group"><label>City</label><input type="text" name="city" value="<?php echo htmlspecialchars($user['city']); ?>"></div>
      <div class="form-group"><label>State</label>
        <select name="state" required>
          <option value="">-- Select State --</option>
          <?php
          $states = ["Johor","Kedah","Kelantan","Melaka","Negeri Sembilan","Pahang","Penang","Perak","Perlis","Sabah","Sarawak","Selangor","Terengganu","Kuala Lumpur","Putrajaya","Labuan"];
          foreach ($states as $s) {
              $selected = ($user['state'] ?? '') === $s ? 'selected' : '';
              echo "<option value=\"$s\" $selected>$s</option>";
          }
          ?>
        </select>
      </div>
      <div class="form-group"><label>Postal Code</label><input type="text" name="postal_code" value="<?php echo htmlspecialchars($user['postal_code']); ?>"></div>
  </div>

  <!-- Right Column: Password Change -->
  <div class="account-box">
    <h3>Change Password</h3>
    <div class="form-group password-container">
      <label>Current Password</label>
      <input type="password" id="password" name="password" placeholder="Enter current password">
      <span class="toggle-password" onclick="togglePassword('password', this)">👁️</span>
    </div>
    <div class="form-group password-container">
      <label>New Password</label>
      <input type="password" id="new_password" name="new_password" placeholder="New password">
      <span class="toggle-password" onclick="togglePassword('new_password', this)">👁️</span>
      <small style="color:#555">Password must include uppercase, lowercase, number, and special character.</small>
    </div>
    <div class="form-group password-container">
      <label>Confirm Password</label>
      <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password">
      <span class="toggle-password" onclick="togglePassword('confirm_password', this)">👁️</span>
    </div>
    <div class="button-container">
      <button type="submit">Save Changes</button>
    </div>
    </form>
  </div>
</div>

 <!-- ✅ Footer -->
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
    icon.textContent = "🙈";
  } else {
    field.type = "password";
    icon.textContent = "👁️";
  }
}
</script>

</body>
</html>
