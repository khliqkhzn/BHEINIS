<?php
session_start();
include("../db.php");

// Destroy all session data
$_SESSION = [];
session_destroy();

// 🔒 Block auto-login ONLY once after logout (3 seconds)
setcookie("logout_flag", "1", time() + 3, "/");

// ❌ DO NOT delete trusted_browser_admin cookie
// ❌ DO NOT delete token from DB
// (so OTP skip still works after login)

header("Location: login.php");
exit;
?>
