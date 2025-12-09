<?php
session_start();
include("../db.php");
require_once 'PHPGangsta/GoogleAuthenticator.php';

// ✅ Ensure admin has just logged in but not yet verified OTP
if (!isset($_SESSION['pending_admin']) || !isset($_SESSION['pending_username'])) {
    header("Location: login.php");
    exit;
}

$ga = new PHPGangsta_GoogleAuthenticator();
$admin_id = $_SESSION['pending_admin'];

// ✅ Fetch admin email and secret
$sql = "SELECT email, totp_secret FROM admins WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

$email = $admin['email'];
$secret = $admin['totp_secret'];
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $otp = trim($_POST['otp']);

    if ($ga->verifyCode($secret, $otp, 2)) {

        // ✅ Handle skip OTP using trusted browser (same as users)
        if (isset($_SESSION['skip_otp_selected']) && $_SESSION['skip_otp_selected'] == 1) {
            $skip_days = $_SESSION['skip_days'] ?? 7;
            $browser_token = bin2hex(random_bytes(32));
            $expiry_date = date('Y-m-d H:i:s', strtotime("+$skip_days days"));

            // ✅ Store trusted browser token
            $stmt = $conn->prepare("
                INSERT INTO trusted_browsers_admin (admin_id, browser_token, expiry_date, created_at)
                VALUES (?, ?, ?, NOW())
            ");
            if (!$stmt) {
                die("❌ SQL prepare failed: " . $conn->error);
            }
            $stmt->bind_param("iss", $admin_id, $browser_token, $expiry_date);
            if (!$stmt->execute()) {
                die("❌ SQL execute failed: " . $stmt->error);
            }

            // ✅ Save token in secure cookie
            setcookie(
                "trusted_browser_admin",
                $browser_token,
                time() + (86400 * $skip_days), // cookie expiry
                "/",       // path
                "",        // domain
                true,      // secure (HTTPS only)
                true       // httpOnly
            );
        }

        // ✅ Session after successful verification
        $_SESSION['admin_id'] = $admin_id;
        $_SESSION['admin_username'] = $_SESSION['pending_username'];
        $_SESSION['admin_email'] = $email;
        $_SESSION['otp_verified'] = true;

        // ✅ Clear temp sessions
        unset($_SESSION['pending_admin'], $_SESSION['pending_username'], $_SESSION['totp_secret'], $_SESSION['skip_days'], $_SESSION['skip_otp_selected']);

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid OTP. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OTP Verification - BHEINIS Admin</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="login-container">
    <img src="assets/logo.png" style="width: 150px; margin-bottom: 20px;">
    <h2>Two-Factor Authentication</h2>
    <p>Enter the 6-digit code from your Google Authenticator app.</p>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="otp" placeholder="Enter OTP" maxlength="6" required><br/>
        <button type="submit" class="btn btn-edit">Verify</button>
    </form>
</div>
</body>
</html>
