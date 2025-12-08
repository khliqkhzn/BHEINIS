<?php
session_start();
include 'config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

$sql = "
    SELECT 
        r.id AS return_id, 
        r.order_id, 
        r.product_id, 
        r.quantity, 
        r.reason, 
        r.image, 
        r.email, 
        r.status, 
        p.name AS product_name
    FROM returns r
    JOIN products p ON r.product_id = p.id
    ORDER BY r.id DESC
";
$returns = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Return Requests - Admin</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        main {
            padding: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        th, td {
            border-bottom: 1px solid #eee;
            padding: 12px 15px;
            text-align: center;
        }
        th {
            background: #f8f8f8;
            font-weight: bold;
        }
        a.details-link {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }
        a.details-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<header>
    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
    <h2>Return Requests</h2>
</header>

<main>
    <table>
        <tr>
            <th>ID</th>
            <th>Order ID</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Reason</th>
            <th>Email</th>
            <th>Status</th>
            <th>View</th>
        </tr>
        <?php if ($returns && $returns->num_rows > 0): ?>
            <?php while ($r = $returns->fetch_assoc()): ?>
                <tr>
                    <td><?= $r['return_id'] ?></td>
                    <td>#<?= $r['order_id'] ?></td>
                    <td><?= htmlspecialchars($r['product_name']) ?></td>
                    <td><?= $r['quantity'] ?></td>
                    <td><?= htmlspecialchars($r['reason']) ?></td>
                    <td><?= htmlspecialchars($r['email']) ?></td>
                    <td><strong><?= $r['status'] ?></strong></td>
                    <td>
                        <a href="admin_return_details.php?id=<?= $r['return_id'] ?>" class="details-link">View Details</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="8"><em>No return requests found.</em></td></tr>
        <?php endif; ?>
    </table>
</main>
</body>
</html>
