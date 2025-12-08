<?php
session_start();
include 'db.php';

// Get category from URL parameter, default to 'Women'
$categoryName = isset($_GET['cat']) ? ucfirst(strtolower($_GET['cat'])) : 'Women';

// Sanitize input
$categoryNameSafe = htmlspecialchars($categoryName);

// Fetch category ID
$catResult = $conn->query("SELECT category_id FROM category WHERE category_name = '$categoryName' LIMIT 1");
if ($catResult && $catResult->num_rows > 0) {
    $catRow = $catResult->fetch_assoc();
    $categoryId = $catRow['category_id'];
} else {
    die("Category '$categoryName' not found.");
}

// Fetch products for the selected category
$sql = "SELECT * FROM products WHERE category_id = $categoryId ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= $categoryNameSafe ?> - BHEINIS</title>
  <link rel="stylesheet" href="assets2/style2.css" />
</head>
<body>

<!-- Top Header -->
<div class="top-header">
  <div class="logo-search-container">
    <a href="home.php" class="logo-link">
      <img src="assets2/logo.png" alt="BHEINIS Logo" class="logo-img">
    </a>

    <!-- ✅ Search Form with Hidden Category -->
    <form action="search.php" method="GET" class="search-form">
      <input type="hidden" name="category" value="<?= strtolower($categoryNameSafe) ?>">
      <input type="text" name="q" placeholder="Search products..." required />
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
  <a href="category.php?cat=Women" class="<?= $categoryName == 'Women' ? 'active' : '' ?>">WOMENS</a>
  <a href="category.php?cat=Men" class="<?= $categoryName == 'Men' ? 'active' : '' ?>">MENS</a>
  <a href="category.php?cat=Kids" class="<?= $categoryName == 'Kids' ? 'active' : '' ?>">KIDS</a>
  <a href="category.php?cat=Scarf" class="<?= $categoryName == 'Scarf' ? 'active' : '' ?>">SCARF</a>
</nav>

<!-- Products Section -->
<section class="products-section">
  <h1><?= $categoryNameSafe ?>’s Collection</h1>

  <div class="products-grid">
    <?php
    if ($result && $result->num_rows > 0) {
      while ($product = $result->fetch_assoc()) {
        $image = !empty($product['image']) ? "../uploads/" . htmlspecialchars($product['image']) : "assets2/no-image.png";
        echo '<div class="product-card">';
        echo '<a href="product_detail.php?id=' . $product['id'] . '">';
        echo '<img src="' . $image . '" alt="' . htmlspecialchars($product['name']) . '" />';
        echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
        echo '<p>RM ' . number_format($product['price'], 2) . '</p>';
        echo '</a></div>';
      }
    } else {
      echo '<p>No products found in ' . $categoryNameSafe . ' category.</p>';
    }
    ?>
  </div>
</section>

<!-- Footer -->
<footer class="footer">
  <div class="footer-bottom">
    <p>&copy; 2025 BHEINIS.</p>
  </div>
</footer>

</body>
</html>
