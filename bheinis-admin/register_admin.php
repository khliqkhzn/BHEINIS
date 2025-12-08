<?php
session_start();
include("config.php");

// Include Google Authenticator library
require_once 'PHPGangsta/GoogleAuthenticator.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $username =$_POST['username'];
    $password = $_POST['password'];

    // Prevent empty username or password
if (empty($username) || empty($password) || empty($email)) {
    $error = "All fields are required!";
} else {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $gAuth = new PHPGangsta_GoogleAuthenticator();
    $secret = $gAuth->createSecret();

    // Simpan dalam DB (username + email + password + secret)
    $stmt = $conn->prepare("INSERT INTO admins (username, email, password_hash, totp_secret) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $secret);

    if ($stmt->execute()) {
        // Generate QR code bind dengan email
        $_SESSION['qrCodeUrl'] = $gAuth->getQRCodeGoogleUrl("BHEINIS-Admin:" . $email, $secret, "BHEINIS");
        $_SESSION['secret'] = $secret;
        header("Location: register_success.php");
        exit();
    } else {
        $error = "Error: Could not register admin!";
    }
        $stmt->close();
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration - BHEINIS</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="login-container">
        <img src="assets/logo.png" alt="BHEINIS Logo" style="width: 150px; margin-bottom: 20px;">
        <h2>Register Admin</h2>
        <form method="post">
            <input type="email" name="email" placeholder="Email" required><br/>
            <input type="text" name="username" placeholder="Username" required><br/>
            <input type="password" name="password" placeholder="Password" required><br/>
            <button type="submit" class="btn btn-edit">Register</button>
        </form>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    </div>
</body>
</html>
