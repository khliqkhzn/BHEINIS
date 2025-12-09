<?php
include("session.php");
include("../db.php");

// Define low stock threshold
$lowStockThreshold = 10;
$lowStockQuery = "SELECT COUNT(*) AS low_count FROM products WHERE stock < $lowStockThreshold";
$lowStockResult = $conn->query($lowStockQuery);
$lowStockCount = 0;
if ($lowStockResult && $row = $lowStockResult->fetch_assoc()) {
    $lowStockCount = $row['low_count'];
}

// Show only products in the "Scarf" category (assuming category_id = 4)
$sql = "SELECT p.*, c.category_name AS category 
        FROM products p 
        JOIN category c ON p.category_id = c.category_id 
        WHERE p.category_id = 4";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Scarf Products - BHEINIS</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        body { font-family: "Segoe UI", sans-serif; background: #f4f7fa; margin: 0; color: #333; }
        header { background: linear-gradient(135deg,#f6c23e,#e74a3b); color: white; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; }
        h2 { margin: 0; }
        .container { max-width: 1000px; margin: 40px auto; background: #fff; border-radius: 16px; padding: 30px; box-shadow: 0 6px 18px rgba(0,0,0,0.1); }
        .back-link { display: inline-block; margin-bottom: 20px; text-decoration: none; color: #007bff; font-weight: bold; }
        .btn { padding: 8px 14px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: bold; }
        .btn-add { background: #1cc88a; color: white; }
        .btn-edit { background: #4e73df; color: white; }
        .btn-delete { background: #e74a3b; color: white; }
        .btn:hover { opacity: 0.9; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { text-align: center; padding: 10px; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fc; }
        tr:hover { background: #f1f5f9; }
        img { border-radius: 6px; }
        footer { text-align: center; padding: 15px; font-size: 14px; color: #777; }
        .color-badge { display:inline-block; width:14px; height:14px; border-radius:50%; border:1px solid #888; margin-right:4px; vertical-align:middle; }
    </style>
</head>
<body>

<header>
    <h2>🧣 Scarf Products</h2>
</header>

<div class="container">
    <a href="dashboard.php" class="back-link">← Back to Dashboard</a>

    <h1>Scarf Products</h1>

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
                <th>Colors</th>
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
                            <?php
                            if (!empty($row['colors'])) {
                                $colors = explode(',', $row['colors']);
                                foreach ($colors as $c) {
                                    $c = trim($c);
                                    if (!empty($c)) {
                                        // Display color badge even if the color text is not a standard CSS color
                                        echo '<span class="color-badge" title="'.htmlspecialchars($c).'" style="background:'.htmlspecialchars($c).';"></span>';
                                    }
                                }
                            } else {
                                echo '<em>—</em>';
                            }
                            ?>
                        </td>
                        <td>
                            <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                            <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7">No products found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<footer>
    © 2025 BHEINIS Admin Panel. All Rights Reserved.
</footer>

</body>
</html>
