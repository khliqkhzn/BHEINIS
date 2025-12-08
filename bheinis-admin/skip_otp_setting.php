<?php
include("session.php");
include("config.php");

$message = "";

// Low stock alert for header badge
$lowStockThreshold = 10;
$lowStockQuery = "SELECT COUNT(*) AS low_count FROM products WHERE stock < $lowStockThreshold";
$lowStockResult = $conn->query($lowStockQuery);
$lowStockCount = 0;
if ($lowStockResult && $row = $lowStockResult->fetch_assoc()) {
    $lowStockCount = $row['low_count'];
}

// Save setting when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $skip_days = intval($_POST['skip_days']);

    // Check if role already has a record
    $check_sql = "SELECT * FROM otp_skip_settings WHERE role = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update
        $sql = "UPDATE otp_skip_settings SET skip_days = ? WHERE role = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $skip_days, $role);
    } else {
        // Insert
        $sql = "INSERT INTO otp_skip_settings (role, skip_days) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $role, $skip_days);
    }

    if ($stmt->execute()) {
        $message = "✅ OTP skip period updated for <b>" . ucfirst($role) . "</b> to <b>$skip_days days</b>.";
    } else {
        $message = "❌ Error updating setting.";
    }
}

// Fetch current settings
$settings = [];
$sql = "SELECT * FROM otp_skip_settings";
$res = $conn->query($sql);
while ($row = $res->fetch_assoc()) {
    $settings[$row['role']] = $row['skip_days'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Skip OTP Settings - BHEINIS Admin</title>
  <link rel="stylesheet" href="assets/style.css">
  <style>
    body {
      font-family: "Segoe UI", sans-serif;
      background: #f4f7fa;
      margin: 0;
      color: #333;
    }
    header {
      background: linear-gradient(135deg,#4e73df,#1cc88a);
      color: white;
      padding: 15px 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .container {
      max-width: 700px;
      margin: 40px auto;
      background: #fff;
      border-radius: 16px;
      padding: 30px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }
    form {
      display: grid;
      gap: 20px;
    }
    .form-group {
      display: flex;
      flex-direction: column;
    }
    label {
      font-weight: bold;
      margin-bottom: 8px;
    }
    select {
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 15px;
    }
    button {
      padding: 12px;
      background: #2563eb;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    button:hover {
      background: #1d4ed8;
    }
    .message {
      text-align: center;
      margin-bottom: 20px;
      font-size: 15px;
    }
    .settings-box {
      margin-top: 30px;
      background: #f1f5f9;
      padding: 15px;
      border-radius: 10px;
    }
    .settings-box h3 {
      margin: 0 0 10px;
      font-size: 18px;
    }
    .role-setting {
      margin-bottom: 8px;
      font-size: 15px;
    }
    .back-link {
      display: inline-block;
      margin-bottom: 20px;
      text-decoration: none;
      color: #007bff;
      font-weight: bold;
    }
    .back-link:hover {
      text-decoration: underline;
    }
    .alert-box {
      background: #fff3cd;
      border: 1px solid #ffeeba;
      color: #856404;
      padding: 12px 15px;
      margin: 20px auto;
      width: 90%;
      max-width: 700px;
      border-radius: 8px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .alert-box button {
      background: none;
      border: none;
      font-weight: bold;
      color: #856404;
      cursor: pointer;
    }
    footer {
      text-align: center;
      padding: 15px;
      font-size: 14px;
      color: #777;
    }
  </style>
</head>
<body>

<header>
  <h2>⚙️ Skip OTP Settings</h2>
</header>

<div class="container">
  <a href="dashboard.php" class="back-link">&larr; Back to Dashboard</a>

  <?php if ($message) { echo "<div class='message'>$message</div>"; } ?>

  <form method="POST">
    <div class="form-group">
      <label for="role">Choose Role:</label>
      <select name="role" required>
        <option value="">-- Select Role --</option>
        <option value="admin">Admin</option>
        <option value="user">User</option>
      </select>
    </div>

    <div class="form-group">
      <label for="skip_days">Select Skip Period:</label>
      <select name="skip_days" required>
        <option value="">-- Select Days to skip OTP --</option>
        <option value="7">7 Days</option>
        <option value="14">14 Days</option>
        <option value="30">30 Days</option>
      </select>
    </div>

    <button type="submit">Save Setting</button>
  </form>

  <div class="settings-box">
    <h3>📌 Current Settings</h3>
    <div class="role-setting"><b>Admin:</b> <?= isset($settings['admin']) ? $settings['admin']." days" : "Not Set" ?></div>
    <div class="role-setting"><b>User:</b> <?= isset($settings['user']) ? $settings['user']." days" : "Not Set" ?></div>
  </div>
</div>

<footer>
  © 2025 BHEINIS Admin Panel. All Rights Reserved.
</footer>

</body>
</html>
