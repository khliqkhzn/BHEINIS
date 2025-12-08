<?php
session_start();
include 'db.php';

// ✅ Log activity: user visited All Products page
if (isset($_SESSION['user_id'])) {
    $activity_type = "View Category";
    $activity_details = "Visited All Products page";
    $log = $conn->prepare("INSERT INTO customer_activity (user_id, activity_type, activity_details) VALUES (?, ?, ?)");
    $log->bind_param("iss", $_SESSION['user_id'], $activity_type, $activity_details);
    $log->execute();
}

// === Default filters ===
$where = "WHERE 1"; // Show all categories
$minPrice = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
$maxPrice = isset($_GET['max_price']) ? floatval($_GET['max_price']) : 9999;
$availability = isset($_GET['availability']) ? $_GET['availability'] : [];
$categoryFilter = isset($_GET['category_filter']) ? $_GET['category_filter'] : 'all';

// Filter by category (if selected)
if ($categoryFilter !== 'all') {
    $where .= " AND category_id = (SELECT category_id FROM category WHERE category_name = '$categoryFilter' LIMIT 1)";
}

// Price filter
if ($minPrice || $maxPrice < 9999) {
    $where .= " AND price BETWEEN $minPrice AND $maxPrice";
}

// Availability filter
if (!empty($availability)) {
    if (in_array("in_stock", $availability)) {
        $where .= " AND stock > 0";
    } elseif (in_array("out_of_stock", $availability)) {
        $where .= " AND stock = 0";
    }
}

// === Fetch all products with filters ===
$sql = "SELECT p.*, c.category_name 
        FROM products p 
        JOIN category c ON p.category_id = c.category_id 
        $where 
        ORDER BY p.id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>All Products - BHEINIS</title>
  <link rel="stylesheet" href="assets2/style2.css" />
  <style>
    /* === Sidebar Filter Styling === */
    .filter-section {
      width: 250px;
      padding: 20px;
      border-right: 1px solid #ddd;
      background-color: #ffe6f2;
      border-radius: 10px;
    }

    .filters-title {
      font-weight: bold;
      font-size: 16px;
      margin-bottom: 15px;
    }

    .filter-group {
      margin-bottom: 25px;
    }

    .filter-group h4 {
      font-size: 15px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .filter-group label {
      display: block;
      font-size: 14px;
      margin: 5px 0;
    }

    .price-inputs {
      display: flex;
      justify-content: space-between;
      margin-top: 10px;
    }

    .price-inputs input {
      width: 45%;
      padding: 5px;
      text-align: center;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .range-slider {
      width: 100%;
    }

    .content-container {
      display: flex;
      gap: 20px;
      padding: 30px;
      background-color: #fff;
    }

    .products-grid {
      flex: 1;
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 20px;
    }

    .filter-btn {
      background: #b30059;
      color: #fff;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 10px;
      width: 100%;
    }

    .filter-btn:hover {
      background: #8a0047;
    }

    .product-card {
      border: 1px solid #eee;
      border-radius: 10px;
      overflow: hidden;
      background: #fff;
      transition: all 0.3s;
      text-decoration: none;
      color: #000;
    }

    .product-card:hover {
      transform: scale(1.03);
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .product-info {
      text-align: center;
      padding: 10px 0;
    }

    .product-info h3 {
      font-size: 15px;
      margin: 8px 0 4px 0;
    }

    .product-info p {
      color: #b30059;
      font-weight: bold;
    }

    .category-tag {
      display: inline-block;
      background: #f5f5f5;
      color: #555;
      font-size: 12px;
      padding: 2px 8px;
      border-radius: 5px;
      margin-top: 4px;
    }
  </style>
</head>
<body>

<!-- Top Header -->
<div class="top-header">
  <div class="logo-search-container">
    <a href="home.php" class="logo-link">
      <img src="assets2/logo.png" alt="BHEINIS Logo" class="logo-img">
    </a>

    <form action="search.php" method="GET" class="search-form">
      <input type="text" name="q" placeholder="Search All Products..." required />
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

<!-- Main Content -->
<div class="content-container">

  <!-- 🔹 Filter Sidebar -->
  <form method="GET" class="filter-section">
    <div class="filters-title">FILTERS</div>
    <hr>

    <!-- Category Filter -->
    <div class="filter-group">
      <h4>Category</h4>
      <select name="category_filter">
        <option value="all" <?= ($categoryFilter === 'all') ? 'selected' : '' ?>>All</option>
        <option value="Women" <?= ($categoryFilter === 'Women') ? 'selected' : '' ?>>Women</option>
        <option value="Men" <?= ($categoryFilter === 'Men') ? 'selected' : '' ?>>Men</option>
        <option value="Kids" <?= ($categoryFilter === 'Kids') ? 'selected' : '' ?>>Kids</option>
        <option value="Scarf" <?= ($categoryFilter === 'Scarf') ? 'selected' : '' ?>>Scarf</option>
      </select>
    </div>

    <!-- Availability Filter -->
    <div class="filter-group">
      <h4>Availability</h4>
      <label><input type="checkbox" name="availability[]" value="in_stock" <?php if(in_array("in_stock", $availability)) echo 'checked'; ?>> In Stock</label>
      <label><input type="checkbox" name="availability[]" value="out_of_stock" <?php if(in_array("out_of_stock", $availability)) echo 'checked'; ?>> Out of Stock</label>
    </div>

    <!-- Price Filter -->
    <div class="filter-group">
      <h4>Price</h4>
      <input type="range" min="0" max="500" value="<?php echo $maxPrice; ?>" class="range-slider" id="priceRange" name="max_price" oninput="updatePrice()">
      <div class="price-inputs">
        <input type="number" name="min_price" id="minPrice" value="<?php echo $minPrice; ?>" min="0" max="500">
        <input type="number" name="max_price" id="maxPrice" value="<?php echo $maxPrice; ?>" min="0" max="500">
      </div>
    </div>

    <button type="submit" class="filter-btn">Apply Filter</button>
  </form>

  <!-- 🔹 Products Grid -->
  <div class="products-grid">
    <?php
    if ($result && $result->num_rows > 0) {
      while ($product = $result->fetch_assoc()) {
        $image = !empty($product['image']) ? "../uploads/" . htmlspecialchars($product['image']) : "assets2/no-image.png";
        echo '<a href="product_detail.php?id=' . $product['id'] . '" class="product-card">';
        echo '<img src="' . $image . '" alt="' . htmlspecialchars($product['name']) . '" />';
        echo '<div class="product-info">';
        echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
        echo '<p>RM ' . number_format($product['price'], 2) . '</p>';
        echo '<span class="category-tag">' . htmlspecialchars($product['category_name']) . '</span>';
        echo '</div></a>';
      }
    } else {
      echo '<p class="no-products-msg">No products found.</p>';
    }
    ?>
  </div>
</div>

<!-- Footer -->
<footer class="footer">
  <div class="footer-bottom">
    <p>&copy; 2025 BHEINIS.</p>
  </div>
</footer>

<script>
function updatePrice() {
  const range = document.getElementById('priceRange');
  const maxPrice = document.getElementById('maxPrice');
  maxPrice.value = range.value;
}
</script>

</body>
</html>
