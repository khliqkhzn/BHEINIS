<?php 
include '../db.php'; 
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


// Set category to 'Men'
$categoryName = 'Men';

// ✅ Log activity: user visited Men category
if (isset($_SESSION['user_id'])) {
    $activity_type = "View Category";
    $activity_details = "Visited Men category page";
    $log = $conn->prepare("INSERT INTO customer_activity (user_id, activity_type, activity_details) VALUES (?, ?, ?)");
    $log->bind_param("iss", $_SESSION['user_id'], $activity_type, $activity_details);
    $log->execute();
}

// Fetch category ID
$catResult = $conn->query("SELECT category_id FROM category WHERE category_name = '$categoryName' LIMIT 1");
if ($catResult && $catResult->num_rows > 0) {
    $catRow = $catResult->fetch_assoc();
    $categoryId = $catRow['category_id'];
} else {
    die("Category '$categoryName' not found.");
}

// Default filters
$where = "WHERE category_id = $categoryId";
$minPrice = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
$maxPrice = isset($_GET['max_price']) ? floatval($_GET['max_price']) : 9999;
$availability = isset($_GET['availability']) ? $_GET['availability'] : [];

if ($minPrice || $maxPrice < 9999) {
    $where .= " AND price BETWEEN $minPrice AND $maxPrice";
}

if (!empty($availability)) {
    if (in_array("in_stock", $availability)) {
        $where .= " AND stock > 0";
    } elseif (in_array("out_of_stock", $availability)) {
        $where .= " AND stock = 0";
    }
}

// Fetch products with filters
$sql = "SELECT * FROM products $where ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Men's Collection - BHEINIS</title>
  <link rel="stylesheet" href="assets2/style2.css" />
  <style>
    <?php include 'style-filters.css'; ?>
  </style>
</head>
<body>

<!-- Top Header -->
<div class="top-header">
  <div class="logo-search-container">
    <a href="home.php" class="logo-link">
      <img src="assets2/logo.png" alt="BHEINIS Logo" class="logo-img">
    <style>
    /* === Sidebar Filter Styling === */
    .filter-section {
      width: 250px;
      padding: 20px;
      border-right: 1px solid #ddd;
      background-color: #ffe6f2; /* 💖 Soft pink background */
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
      background: #b30059; /* Deep pink button */
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

    .section-title {
      color: #b30059;
      font-weight: bold;
      margin-bottom: 10px;
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
    text-align: center; /* ✅ Centers name + price horizontally */
    padding: 10px 0;
    }


    .product-info h3 {
      font-size: 15px;
      margin: 8px 0 4px 0;
      text-align: center; /* Add this */
    }

    .product-info p {
      color: #b30059;
      font-weight: bold;
      text-align: center; /* Add this */
    }

  </style>
    </a>

    <!-- ✅ Search Form for Men Category -->
    <form action="search.php" method="GET" class="search-form">
      <input type="hidden" name="category" value="men">
      <input type="text" name="q" placeholder="Search Men's Products..." required />
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
  <a href="men.php" class="active">MENS</a>
  <a href="kids.php">KIDS</a>
  <a href="scarf.php">SCARF</a>
</nav>

<!-- Main Content -->
<div class="content-container">
  <!-- 🔹 Filter Sidebar -->
  <form method="GET" class="filter-section">
    <div class="filters-title">FILTERS</div>
    <hr>

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
        echo '</div></a>';
      }
    } else {
      echo '<p class="no-products-msg">No products found in Men category.</p>';
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
