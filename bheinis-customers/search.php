<?php
include 'db.php';
session_start();

$keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
$categoryName = isset($_GET['category']) ? strtolower(trim($_GET['category'])) : '';

if (empty($keyword)) {
    die("❌ Please enter a search keyword.");
}

$searchTerm = "%" . $keyword . "%";

// ✅ If category is selected, filter by it
if (!empty($categoryName)) {
    $stmt = $conn->prepare("
        SELECT p.* 
        FROM products p
        JOIN category c ON p.category_id = c.category_id
        WHERE LOWER(c.category_name) = ? 
        AND p.name LIKE ?
        ORDER BY p.id DESC
    ");
    $stmt->bind_param("ss", $categoryName, $searchTerm);
} else {
    // ✅ If no category chosen, search across all categories
    $stmt = $conn->prepare("
        SELECT * FROM products 
        WHERE name LIKE ?
        ORDER BY id DESC
    ");
    $stmt->bind_param("s", $searchTerm);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Search Results - BHEINIS</title>
  <link rel="stylesheet" href="assets2/style2.css" />
</head>
<body>

<!-- Top Header -->
<div class="top-header">
  <div class="logo-search-container">
    <a href="home.php" class="logo-link"><img src="assets2/logo.png" class="logo-img" alt="Logo"></a>
    <form action="search.php" method="GET" class="search-form">
      <input type="text" name="q" value="<?= htmlspecialchars($keyword) ?>" required placeholder="Search products...">
      <button type="submit">Search</button>
    </form>
  </div>
</div>

<!-- Navigation -->
<nav class="main-nav">
  <a href="women.php" <?= $categoryName == 'women' ? 'class="active"' : '' ?>>WOMENS</a>
  <a href="men.php" <?= $categoryName == 'men' ? 'class="active"' : '' ?>>MENS</a>
  <a href="kids.php" <?= $categoryName == 'kids' ? 'class="active"' : '' ?>>KIDS</a>
  <a href="scarf.php" <?= $categoryName == 'scarf' ? 'class="active"' : '' ?>>SCARF</a>
</nav>

<!-- Search Results -->
<section class="products-section">
  <h1 class="section-title">
    Search Results <?= !empty($categoryName) ? 'in ' . ucfirst($categoryName) . ' Category' : '' ?>
  </h1>

  <div class="products-grid">
    <?php
    if ($result->num_rows > 0) {
      while ($product = $result->fetch_assoc()) {
        $image = !empty($product['image']) ? "../uploads/" . htmlspecialchars($product['image']) : "assets2/no-image.png";
        echo '<a href="product_detail.php?id=' . $product['id'] . '" class="product-card">';
        echo '<img src="' . $image . '" alt="' . htmlspecialchars($product['name']) . '" />';
        echo '<div class="product-info">';
        echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
        echo '<p>RM ' . number_format($product['price'], 2) . '</p>';
        echo '</div></a>';
      }
    } else {
      echo '<p class="no-products-msg">No products found for "' . htmlspecialchars($keyword) . '".</p>';
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

<?php $conn->close(); ?>
