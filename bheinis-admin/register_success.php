<?php
session_start();
if (!isset($_SESSION['qrCodeUrl']) || !isset($_SESSION['secret'])) {
    header("Location: register_admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Registered - BHEINIS</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Admin Registered Successfully!</h2>
        <p>Scan this QR code with your <b>Google Authenticator</b> app:</p>
        <img src="<?php echo $_SESSION['qrCodeUrl']; ?>" alt="QR Code"><br><br>
        <p><b>Secret Key (backup):</b> <?php echo $_SESSION['secret']; ?></p>
        <a href="login.php" class="btn btn-edit">Go to Login</a>
    </div>
</body>
</html>
