<?php
include("session.php");
include("config.php");

// Define low stock threshold
$lowStockThreshold = 10;

// Query to count low-stock products
$lowStockQuery = "SELECT COUNT(*) AS low_count FROM products WHERE stock < $lowStockThreshold";
$lowStockResult = $conn->query($lowStockQuery);
$lowStockCount = 0;
if ($lowStockResult && $row = $lowStockResult->fetch_assoc()) {
    $lowStockCount = $row['low_count'];
}

// Show only products in the "Women" category (assuming category_id = 2)
$sql = "SELECT p.*, c.category_name AS category 
        FROM products p 
        JOIN category c ON p.category_id = c.category_id 
        WHERE p.category_id = 2";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Women's Products - BHEINIS</title>
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
            max-width: 1000px;
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
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .btn {
            padding: 8px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }
        .btn-add {
            background: #1cc88a;
            color: white;
        }
        .btn-add:hover {
            background: #17a673;
        }
        .btn-edit {
            background: #4e73df;
            color: white;
        }
        .btn-edit:hover {
            background: #375ac1;
        }
        .btn-delete {
            background: #e74a3b;
            color: white;
        }
        .btn-delete:hover {
            background: #c0392b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            text-align: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #f8f9fc;
        }
        tr:hover {
            background: #f1f5f9;
        }
        img {
            border-radius: 6px;
        }
        .alert-box {
            background:#fff3cd;
            border:1px solid #ffeeba;
            color:#856404;
            padding:12px 15px;
            margin:20px auto;
            width:90%;
            max-width:700px;
            border-radius:8px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }
        .alert-box button {
            background:none;
            border:none;
            font-weight:bold;
            color:#856404;
            cursor:pointer;
        }
        footer {
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>

<header>
    <h2>👗 Women's Products</h2>
</header>

<div class="container">
    <a href="dashboard.php" class="back-link">← Back to Dashboard</a>

    <h1>Women's Products</h1>

    <div class="top-bar">
        <a href="add_products.php" class="btn btn-add">+ Add New Product</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price (RM)</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php if (!empty($row['image'])): ?>
                                <img src="../uploads/<?= htmlspecialchars($row['image']) ?>" alt="Product Image" style="height: 80px;">
                            <?php else: ?>
                                <em>No image</em>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['category']) ?></td>
                        <td><?= number_format($row['price'], 2) ?></td>
                        <td><?= htmlspecialchars($row['stock']) ?></td>
                        <td>
                            <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                            <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6">No products found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<footer>
    © 2025 BHEINIS Admin Panel. All Rights Reserved.
</footer>

</body>
</html>
