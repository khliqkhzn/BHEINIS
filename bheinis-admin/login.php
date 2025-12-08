<?php
session_start();
include("config.php");

// Fetch skip_days setting for Admin
$skip_sql = "SELECT skip_days FROM otp_skip_settings WHERE role = 'admin' LIMIT 1";
$skip_result = $conn->query($skip_sql);
$skip_days = ($skip_result && $skip_result->num_rows > 0) ? $skip_result->fetch_assoc()['skip_days'] : 7;

$error = "";

// Auto-login if trusted browser cookie exists (blocked after logout)
if (!isset($_COOKIE["logout_flag"]) && isset($_COOKIE["trusted_browser_admin"])) {
    $token = $_COOKIE["trusted_browser_admin"];

    $stmt = $conn->prepare("
        SELECT admin_id FROM trusted_browsers_admin
        WHERE browser_token = ? AND expiry_date > NOW()
    ");
    if ($stmt) {
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $row = $result->fetch_assoc()) {
            $admin_id = $row['admin_id'];
            $admin_info = $conn->query("SELECT username, email FROM admins WHERE id = $admin_id")->fetch_assoc();

            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['admin_username'] = $admin_info['username'];
            $_SESSION['admin_email'] = $admin_info['email'];
            $_SESSION['otp_verified'] = true;

            header("Location: dashboard.php");
            exit;
        }
    }
}

// Handle manual login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === '' || $password === '') {
        $error = "Please enter username and password!";
    } else {
        $sql = "SELECT id, username, email, password_hash FROM admins WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $admin = $result->fetch_assoc();

            if (password_verify($password, $admin['password_hash'])) {
                $_SESSION['pending_admin'] = $admin['id'];
                $_SESSION['pending_username'] = $admin['username'];
                $_SESSION['pending_email'] = $admin['email'];
                $_SESSION['skip_days'] = $skip_days;
                $_SESSION['skip_otp_selected'] = isset($_POST['skip_otp']) ? 1 : 0;

                header("Location: admin_verify.php");
                exit;
            } else {
                $error = "Invalid username or password!";
            }
        } else {
            $error = "Invalid username or password!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - BHEINIS</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .form-check { text-align: left; margin: 10px 0; font-size: 14px; }
        .note { font-size: 12px; color: #777; margin-left: 20px; }
        .password-wrapper { position: relative; }
        .password-wrapper input { width: 100%; padding-right: 40px; }
        .toggle-password { position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer; }
        .role-switch { margin: 15px 0; text-align: center; font-size: 14px; }
        .role-switch a { color: #007bff; text-decoration: none; margin: 0 5px; }
    </style>
</head>
<body>
<div class="login-container">
    <img src="assets/logo.png" style="width: 150px; margin-bottom: 20px;">
    <h2>Admin Login</h2>

    <!-- Role switch navigation -->
    <div class="role-switch">
        <span>Login as: </span>
        <a href="../bheinis-customers/login.php">User</a> |
        <a href="login.php">Admin</a>
    </div>

    <form method="post">
        <input type="text" name="username" placeholder="Username" required><br/>
        <div class="password-wrapper">
            <input type="password" id="password" name="password" placeholder="Password" required>
            <i class="fa-solid fa-eye-slash toggle-password" id="togglePassword"></i>
        </div>
        <div class="form-check">
            <label>
                <input type="checkbox" name="skip_otp" value="1"> Remember this device (skip OTP)
            </label>
            <p class="note">If selected, OTP will be skipped for <strong><?php echo $skip_days; ?> days</strong>.</p>
        </div>
        <button type="submit" class="btn btn-edit">Login</button>
    </form>

    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
</div>

<script>
const togglePassword = document.getElementById("togglePassword");
const passwordField = document.getElementById("password");
togglePassword.addEventListener("click", () => {
    if (passwordField.type === "password") {
        passwordField.type = "text";
        togglePassword.classList.replace("fa-eye-slash", "fa-eye");
    } else {
        passwordField.type = "password";
        togglePassword.classList.replace("fa-eye", "fa-eye-slash");
    }
});
</script>
</body>
</html>
