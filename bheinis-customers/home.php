<?php 
include 'db.php'; 
session_start(); 

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
?>
<!DOCTYPE html>
<html lang="en">
<head> 
  <meta charset="UTF-8" />
  <title>BHEINIS - Everyday Charm</title>
  <link rel="stylesheet" href="assets2/style2.css" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Montserrat:wght@400;500&display=swap" rel="stylesheet" />
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

<!-- Navigation Bar -->
<nav class="main-nav">
  <a href="women.php">WOMENS</a>
  <a href="men.php">MENS</a>
  <a href="kids.php">KIDS</a>
  <a href="scarf.php">SCARF</a>
</nav>

<!-- Hero Section -->
<section class="hero">
  <!-- Background layers -->
  <div class="hero-bg bg1"></div>
  <div class="hero-bg bg2"></div>
  <div class="hero-bg bg3"></div>

  <div class="hero-text">
    <p class="hero-subtitle">BHEINIS PRESENTS</p>
    <h1 class="hero-title">Where Style Meets Confidence</h1>
    <p class="hero-tagline">Where charm meets ease.</p>
    <a href="all_products.php" class="hero-btn">SHOP ALL</a>
  </div>
</section>

<!-- Footer -->
<footer class="footer">
  <div class="footer-bottom">
    <p>&copy; 2025 BHEINIS.</p>
  </div>
</footer>

<!-- ✅ Background Slideshow Script -->
<script>
const hero = document.querySelector('.hero');
const images = [
  "../uploads/background/busanaheini4.jpg",
  "../uploads/background/busanaheini7.jpg",
  "../uploads/background/busanaheini6.jpg"
];
let current = 0;

setInterval(() => {
  current = (current + 1) % images.length;
  hero.style.backgroundImage = `url('${images[current]}')`;
}, 3000);
</script>

</body>
</html>
