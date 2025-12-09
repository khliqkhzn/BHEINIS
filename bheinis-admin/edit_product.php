<?php
include("session.php");
include("../db.php");

$id = intval($_GET['id']);

// Fetch product data
$product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id = $id"));
$category_id = $product['category_id'];
$colors = $product['colors'] ?? '';

// Fetch available sizes for this category
$sizes = [];
$sql_sizes = "SELECT sizes.size_name FROM sizes 
              JOIN category_sizes ON sizes.size_id = category_sizes.size_id
              WHERE category_sizes.category_id = $category_id";
$result_sizes = mysqli_query($conn, $sql_sizes);
while ($row = mysqli_fetch_assoc($result_sizes)) {
    $sizes[] = $row['size_name'];
}

// Fetch saved size quantities for this product
$saved_qty = [];
$res_qty = mysqli_query($conn, "SELECT size, quantity FROM product_sizes WHERE product_id = $id");
while ($row = mysqli_fetch_assoc($res_qty)) {
    $saved_qty[$row['size']] = $row['quantity'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $category_id = intval($_POST['category_id']);
    $availability = isset($_POST['stock']) ? intval($_POST['stock']) : 1;
    $colors = mysqli_real_escape_string($conn, $_POST['colors'] ?? '');

// Accept colors as any text (comma-separated)
$colors = isset($_POST['colors']) ? trim($_POST['colors']) : '';
$colors = !empty($colors) ? $colors : null; // allow empty if none provided


    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $image = basename($_FILES["image"]["name"]);
        $targetDir = "../uploads/";
        $targetFile = $targetDir . $image;

        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        $fileType = mime_content_type($_FILES["image"]["tmp_name"]);

        if (!in_array($fileType, $allowedTypes)) {
            echo "<script>alert('❌ Only JPG and PNG image formats are allowed.'); window.history.back();</script>";
            exit;
        }

        $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
            echo "<script>alert('❌ Invalid file extension. Only JPG and PNG are allowed.'); window.history.back();</script>";
            exit;
        }

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "<script>alert('❌ Failed to upload image.'); window.history.back();</script>";
            exit;
        }
    } else {
        $image = $product['image'];
    }

    // Calculate total stock from sizes
    $total_stock = 0;
    if (!empty($_POST['size_qty'])) {
        foreach ($_POST['size_qty'] as $size => $qty) {
            $total_stock += intval($qty);
        }
    }

    // Update product
    $sql = "UPDATE products SET 
                name='$name',
                description='$description',
                price='$price',
                stock='$total_stock',
                image='$image',
                category_id='$category_id',
                colors='$colors'
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        // Update sizes
        mysqli_query($conn, "DELETE FROM product_sizes WHERE product_id = $id");
        if (!empty($_POST['size_qty'])) {
            foreach ($_POST['size_qty'] as $size => $qty) {
                $safe_size = mysqli_real_escape_string($conn, $size);
                mysqli_query($conn, "INSERT INTO product_sizes (product_id, size, quantity) 
                                     VALUES ('$id', '$safe_size', '".intval($qty)."')");
            }
        }

        // Log to inventory_report
        $action = "Updated product: $name (ID: $id)";
        $timestamp = date('Y-m-d H:i:s');
        mysqli_query($conn, "INSERT INTO inventory_report (product_id, action, updated_stock, date_time) 
                             VALUES ('$id', '$action', '$total_stock', '$timestamp')");

        echo "<script>alert('✅ Product updated successfully!'); window.location.href = 'categories.php';</script>";
        exit;
    } else {
        echo "❌ Error updating product: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product - BHEINIS</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: #f4f7fa;
            margin: 0;
            color: #333;
        }
        header {
            background: linear-gradient(135deg,#4e73df,#1cc88a);
            color: white;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        h2 {
            margin: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        nav {
            text-align: left;
            margin-bottom: 15px;
        }
        nav a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        form label {
            display: block;
            margin: 12px 0 6px;
            font-weight: 600;
        }
        form input[type="text"],
        form input[type="number"],
        form textarea,
        form select {
            width: 100%;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }
        form input[type="file"] {
            margin-top: 6px;
        }
        .btn-submit {
            width: 100%;
            padding: 12px;
            background: #4e73df;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            cursor: pointer;
        }
        .btn-submit:hover {
            background: #3758c8;
        }
        .size-group {
            margin-top: 10px;
        }
        .size-group div {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        .size-group label {
            flex: 1;
        }
        .size-group input {
            width: 80px;
        }
        img {
            border-radius: 8px;
            margin-top: 10px;
        }
        footer {
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #777;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<header>
    <h2>✏️ Edit Product</h2>
</header>

<div class="container">
    <nav>
        <a href="categories.php" style="text-decoration:none;color:#007bff;font-weight:bold;">← Back to Product List</a>
    </nav>

<h1>Edit Product</h1>

<form action="" method="POST" enctype="multipart/form-data">
    <label>Product Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

    <label>Description:</label>
    <textarea name="description" rows="4" required><?= htmlspecialchars($product['description']) ?></textarea>

    <label>Price (RM):</label>
    <input type="number" name="price" step="0.01" value="<?= $product['price'] ?>" required>

    <label>Availability:</label>
    <select name="stock" required>
        <option value="1" <?= $product['stock'] > 0 ? 'selected' : '' ?>>Available</option>
        <option value="0" <?= $product['stock'] == 0 ? 'selected' : '' ?>>Not Available</option>
    </select>

    <label>Category:</label>
    <select name="category_id" required>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM category");
        while ($cat = mysqli_fetch_assoc($result)) {
            $selected = $product['category_id'] == $cat['category_id'] ? 'selected' : '';
            echo "<option value='{$cat['category_id']}' $selected>{$cat['category_name']}</option>";
        }
        ?>
    </select>

    <label>Size & Quantity:</label>
    <div class="size-group">
        <?php foreach ($sizes as $size): ?>
            <div>
                <label><?= htmlspecialchars($size) ?></label>
                <input type="number" name="size_qty[<?= htmlspecialchars($size) ?>]" 
                       value="<?= $saved_qty[$size] ?? 0 ?>" min="0">
            </div>
        <?php endforeach; ?>
    </div>

    <div id="color-section" style="display:none;">
        <label>Colors (comma separated):</label>
        <input type="text" name="colors" value="<?= htmlspecialchars($colors) ?>" placeholder="e.g., Red, Blue, Black">
    </div>

    <label>Current Image:</label><br>
    <?php if (!empty($product['image'])): ?>
        <img src="../uploads/<?= $product['image'] ?>" style="height:80px;"><br>
    <?php else: ?>
        <em>No image uploaded</em><br>
    <?php endif; ?>

    <label>Change Image:</label>
    <input type="file" name="image" accept=".jpg,.jpeg,.png">

    <button type="submit" class="btn-submit">Update Product</button>
</form>
</div>

<footer>
    © 2025 BHEINIS Admin Panel. All Rights Reserved.
</footer>

<script>
const categorySelect = document.querySelector('select[name="category_id"]');
const colorSection = document.getElementById('color-section');

function toggleColorSection() {
    const selectedText = categorySelect.options[categorySelect.selectedIndex].text.toLowerCase();
    colorSection.style.display = (selectedText === 'scarf') ? 'block' : 'none';
}

// Run on page load
toggleColorSection();

// Run when category changes
categorySelect.addEventListener('change', toggleColorSection);
</script>

</body>
</html>
