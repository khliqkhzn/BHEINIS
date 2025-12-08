<?php
include 'db.php';
session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

$product_id = intval($_GET['id']);

// Fetch product details
$sql = "SELECT p.*, c.category_name FROM products p 
        JOIN category c ON p.category_id = c.category_id 
        WHERE p.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Product not found.");
}

$product = $result->fetch_assoc();

// Fetch sizes
$sizeSql = "SELECT size, quantity FROM product_sizes WHERE product_id = ?";
$sizeStmt = $conn->prepare($sizeSql);
$sizeStmt->bind_param("i", $product_id);
$sizeStmt->execute();
$sizeResult = $sizeStmt->get_result();

$sizes = [];
while ($row = $sizeResult->fetch_assoc()) {
    if ((int)$row['quantity'] > 0) {
        $sizes[] = [
            'size' => htmlspecialchars($row['size']),
            'qty' => (int)$row['quantity']
        ];
    }
}

// Fetch feedback (including admin reply)
$feedbackSql = "SELECT f.rating, f.comment, f.feedback_date, f.admin_reply, u.name 
                FROM feedback f
                JOIN users u ON f.user_id = u.id
                WHERE f.product_id = ?
                ORDER BY f.feedback_date DESC";
$feedbackStmt = $conn->prepare($feedbackSql);
$feedbackStmt->bind_param("i", $product_id);
$feedbackStmt->execute();
$feedbackResult = $feedbackStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= htmlspecialchars($product['name']) ?> - BHEINIS</title>
  <link rel="stylesheet" href="assets2/style2.css" />
  <link rel="stylesheet" href="assets2/product_detail.css" />
  <style>
    .feedback-section {
      margin-top: 30px;
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .feedback-item {
      background: #f9f9f9;
      border-radius: 10px;
      padding: 15px 20px;
      margin-bottom: 15px;
      border: 1px solid #e0e0e0;
    }

    .feedback-item .stars {
      color: #ffb400;
      font-size: 14px;
      margin-left: 8px;
    }

    .admin-reply-box {
      background: #e3f2fd;
      border-left: 4px solid #1976d2;
      padding: 10px 15px;
      margin-top: 10px;
      border-radius: 6px;
      font-size: 14px;
    }

    .login-msg {
      margin-top: 20px;
      text-align: center;
    }

    .feedback-form {
      margin-top: 30px;
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .feedback-form textarea {
      width: 100%;
      border-radius: 8px;
      border: 1px solid #ccc;
      padding: 10px;
      font-size: 14px;
    }

    .feedback-form select, .feedback-form button {
      padding: 10px;
      border-radius: 8px;
      border: 1px solid #ccc;
      margin-top: 10px;
      cursor: pointer;
    }

    .feedback-form button {
      background: #222;
      color: #fff;
      border: none;
      transition: 0.3s;
    }

    .feedback-form button:hover {
      background: #444;
    }

    /* Color selection */
    .color-select-group label {
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      margin-right: 14px;
      margin-bottom: 8px;
    }

    .color-radio { display:none; }

    .color-swatch {
      display:inline-block;
      width:22px;
      height:22px;
      border-radius:50%;
      border:2px solid #ccc;
      transition: 0.2s;
    }

    .color-label-text {
      font-size: 13px;
      margin-left: 6px;
    }

    /* When selected */
    .color-selected .color-swatch {
      border-color: #000;
      transform: scale(1.2);
    }

    .color-selected .color-label-text {
      font-weight: bold;
    }

    /* Add to Cart button */
    .btn-add {
        background-color: #222;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 12px;
        transition: 0.3s;
    }
    .btn-add:hover { background-color: #17a673; }
  </style>
</head>
<body>

<!-- Header -->
<header class="top-header">
  <div class="logo-search-container">
    <a href="home.php" class="logo-link">
      <img src="assets2/logo.png" alt="BHEINIS Logo" class="logo-img">
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
</header>

<!-- Navigation -->
<nav class="main-nav">
  <a href="women.php">WOMENS</a>
  <a href="men.php">MENS</a>
  <a href="kids.php">KIDS</a>
  <a href="scarf.php">SCARF</a>
</nav>

<!-- Product Page -->
<div class="product-page-container">
  <div class="product-details-card">
    <div class="product-image">
      <img src="<?= !empty($product['image']) ? '../uploads/' . htmlspecialchars($product['image']) : 'assets2/no-image.png' ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width:100%; max-width:420px;" />
    </div>
    <div class="product-info">
      <h1><?= htmlspecialchars($product['name']) ?></h1>
      <p class="category"><strong>Category:</strong> <?= htmlspecialchars($product['category_name']) ?></p>
      <p class="price"><strong>Price:</strong> RM <?= number_format($product['price'], 2) ?></p>

      <?php if (!empty($sizes)): ?>
        <form action="add_to_cart.php" method="GET" onsubmit="return checkSizeSelected();">
          <input type="hidden" name="id" value="<?= $product['id'] ?>">

          <div class="size-selection">
            <strong>Select Size:</strong>
            <div class="size-options">
              <?php foreach ($sizes as $index => $s): ?>
                <input type="radio" id="size<?= $index ?>" name="size" value="<?= $s['size'] ?>">
                <label for="size<?= $index ?>"><?= $s['size'] ?> (<?= $s['qty'] ?>)</label>
              <?php endforeach; ?>
            </div>
          </div>

          <?php if (!empty($product['colors']) && strtolower($product['category_name']) === 'scarf'): ?>
          <div style="margin-top:12px;">
            <label style="font-weight:bold;">Choose Color:</label>
            <div class="color-select-group" style="margin:8px 0;">
                <?php foreach (explode(",", $product['colors']) as $c):
                    $colorName = trim($c);
                    $safeColor = htmlspecialchars($colorName);
                ?>
                    <label class="color-label">
                        <input class="color-radio" type="radio" name="color" value="<?= $safeColor ?>" required>
                        <span class="color-swatch" style="background:<?= $safeColor ?>;"></span>
                        <span class="color-label-text"><?= $safeColor ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
          </div>
          <?php endif; ?>

          <button type="submit" class="btn-add">🛒 Add to Cart</button>
        </form>
      <?php else: ?>
        <p class="out-of-stock">No sizes available.</p>
      <?php endif; ?>

      <div class="description">
        <h3>Description</h3>
        <div class="desc-box">
          <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Customer Feedback Section -->
  <div class="feedback-section box">
    <h3>Customer Feedback</h3>

    <?php if ($feedbackResult->num_rows > 0): ?>
      <?php while ($fb = $feedbackResult->fetch_assoc()): ?>
        <div class="feedback-item">
          <strong><?= htmlspecialchars($fb['name']) ?></strong>
          <span class="stars">
            <?php for ($i = 1; $i <= 5; $i++): ?>
              <?= $i <= $fb['rating'] ? "★" : "☆" ?>
            <?php endfor; ?>
          </span>
          <?php if (!empty($fb['comment'])): ?>
            <p><?= nl2br(htmlspecialchars($fb['comment'])) ?></p>
          <?php endif; ?>
          <small><?= date("F j, Y", strtotime($fb['feedback_date'])) ?></small>

          <?php if (!empty($fb['admin_reply'])): ?>
            <div class="admin-reply-box">
              <strong>Admin Reply:</strong>
              <p><?= nl2br(htmlspecialchars($fb['admin_reply'])) ?></p>
            </div>
          <?php endif; ?>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No feedback yet. Be the first to review this product!</p>
    <?php endif; ?>
  </div>

  <!-- Feedback Form -->
  <?php if (isset($_SESSION['user_id'])) { ?>
    <div class="feedback-form box">
        <h3>Leave Your Feedback</h3>
        <form action="submit_feedback.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

            <label for="rating">Rating:</label>
            <select name="rating" id="rating" required>
                <option value="5">⭐⭐⭐⭐⭐</option>
                <option value="4">⭐⭐⭐⭐</option>
                <option value="3">⭐⭐⭐</option>
                <option value="2">⭐⭐</option>
                <option value="1">⭐</option>
            </select>

            <label for="comments">Your Review:</label>
            <textarea name="comments" id="comments" rows="4" required></textarea>

            <button type="submit">Submit Feedback</button>
        </form>
    </div>
  <?php } else { ?>
    <p class='login-msg'>Please <a href='login.php'>login</a> to leave feedback.</p>
  <?php } ?>
</div>

<!-- Footer -->
<footer class="footer">
  <div class="footer-bottom">
    <p>&copy; 2025 BHEINIS. All rights reserved.</p>
  </div>
</footer>

<script>
function checkSizeSelected() {
  const selected = document.querySelector('input[name="size"]:checked');
  if (!selected) {
    alert("Please select a size.");
    return false;
  }
  // Color radio is required, HTML will enforce
  return true;
}

// Highlight selected color
document.querySelectorAll('.color-radio').forEach(radio => {
    radio.addEventListener('change', function () {
        document.querySelectorAll('.color-label').forEach(label => {
            label.classList.remove('color-selected');
        });
        this.closest('.color-label').classList.add('color-selected');
    });
});
</script>

</body>
</html>
