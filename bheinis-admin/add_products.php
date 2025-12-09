<?php
include("session.php");
include("../db.php");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category_id = intval($_POST['category_id']);

    // ✅ Handle image upload (JPG and PNG only)
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../uploads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $image = basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $image;

        // ✅ Allowed MIME types
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        $fileType = mime_content_type($_FILES["image"]["tmp_name"]);

        if (!in_array($fileType, $allowedTypes)) {
            echo "<script>
                    alert('❌ Only JPG and PNG image formats are allowed.');
                    window.history.back();
                  </script>";
            exit;
        }

        // ✅ Double-check file extension
        $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
            echo "<script>
                    alert('❌ Invalid file extension. Only JPG and PNG are allowed.');
                    window.history.back();
                  </script>";
            exit;
        }

        // ✅ Move uploaded file
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "<script>
                    alert('❌ Failed to upload image. Please try again.');
                    window.history.back();
                  </script>";
            exit;
        }
    }

// Accept colors as any text (comma-separated)
$colors = isset($_POST['colors']) ? trim($_POST['colors']) : '';
$colors = !empty($colors) ? $colors : null; // allow empty if none provided


    // Insert product into DB
    $sql = "INSERT INTO products (name, description, price, stock, image, category_id)
            VALUES ('$name', '$description', '$price', '$stock', '$image', '$category_id')";

    if (mysqli_query($conn, $sql)) {
        $product_id = mysqli_insert_id($conn);

        // Insert size & quantity
        if (!empty($_POST['size_qty'])) {
            foreach ($_POST['size_qty'] as $size => $qty) {
                $qty = intval($qty);
                if ($qty > 0) {
                    $safe_size = mysqli_real_escape_string($conn, $size);
                    mysqli_query($conn, "INSERT INTO product_sizes (product_id, size, quantity) 
                                         VALUES ('$product_id', '$safe_size', '$qty')");
                }
            }
        }

        echo "<script>
                alert('✅ Product added successfully.');
                window.location.href = 'categories.php';
              </script>";
        exit;
    } else {
        echo "❌ Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product - BHEINIS</title>
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
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        nav {
            text-align: center;
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
            padding: 10px;
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
            background: #1cc88a;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
            cursor: pointer;
        }
        .btn-submit:hover {
            background: #17a673;
        }
        #size-container {
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
    <h2>➕ Add New Product</h2>
</header>

<div class="container">
    <a href="categories.php" style="text-decoration:none;color:#007bff;font-weight:bold;">← Back to Product List</a>

    <h1>Add New Product</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <label>Product Name:</label>
        <input type="text" name="name" required>

        <label>Description:</label>
        <textarea name="description" rows="4" required></textarea>

        <label>Price (RM):</label>
        <input type="number" name="price" step="0.01" required>

        <label>Availability:</label>
        <select name="stock" required>
            <option value="">-- Select Availability --</option>
            <option value="1">Available</option>
            <option value="0">Not Available</option>
        </select>

        <label>Category:</label>
        <select name="category_id" required>
            <option value="">-- Select Category --</option>
            <?php
            $catResult = mysqli_query($conn, "SELECT * FROM category");
            while ($cat = mysqli_fetch_assoc($catResult)) {
                echo "<option value='{$cat['category_id']}'>{$cat['category_name']}</option>";
            }
            ?>
        </select>

        <div id="size-container"></div>

        <!-- COLOR SECTION FOR SCARF ONLY -->
        <div id="color-section" style="display:none;">
            <label>Colours (comma separated):</label>
            <input type="text" name="colors" placeholder="e.g., Blue, Dark Brown, Nude">
        </div>

        <label>Product Image:</label>
        <input type="file" name="image" accept=".jpg,.jpeg,.png">

        <button type="submit" class="btn-submit">Add Product</button>
    </form>
</div>

<footer>
    © 2025 BHEINIS Admin Panel. All Rights Reserved.
</footer>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const categorySelect = document.querySelector('select[name="category_id"]');
    const colorSection = document.getElementById('color-section');

    function toggleColorSection() {
        const selectedName = categorySelect.options[categorySelect.selectedIndex].text.toLowerCase();
        
        if (selectedName.includes("scarf")) {
            colorSection.style.display = "block";
        } else {
            colorSection.style.display = "none";
        }
    }

    toggleColorSection(); 
    categorySelect.addEventListener("change", toggleColorSection);
});
</script>


</body>
</html>
