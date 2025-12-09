<?php
include("session.php");
include("../db.php");

// ✅ Handle shipment update
if (isset($_POST['update_shipment'])) {
    $order_id = intval($_POST['order_id']);
    $shipment_status = $_POST['shipment_status'];

    $stmt = $conn->prepare("UPDATE orders SET shipment_status = ? WHERE id = ?");
    $stmt->bind_param("si", $shipment_status, $order_id);
    $stmt->execute();
    $stmt->close();

    header("Location: orders.php"); // refresh page after update
    exit;
}

// ✅ Fetch orders
$sql = "SELECT * FROM orders ORDER BY order_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Orders - BHEINIS</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background:#f4f7fa;
            margin:0;
            color:#333;
        }
        header {
            background: linear-gradient(135deg,#4e73df,#1cc88a);
            color:white;
            padding:15px 25px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }
        header h2 { margin:0; font-size:22px; }
        .back-btn {
            text-decoration:none;
            color:white;
            background:rgba(0,0,0,0.2);
            padding:8px 14px;
            border-radius:6px;
            transition:background 0.3s;
        }
        .back-btn:hover {
            background:rgba(0,0,0,0.35);
        }
        main {
            padding:30px 40px;
        }
        h1 {
            font-size:24px;
            text-align:center;
            margin-bottom:20px;
        }
        table {
            width:100%;
            border-collapse:collapse;
            background:white;
            border-radius:12px;
            box-shadow:0 6px 15px rgba(0,0,0,0.08);
            overflow:hidden;
        }
        th, td {
            padding:14px;
            text-align:center;
            border-bottom:1px solid #eaeaea;
        }
        th {
            background:#f1f3f6;
            color:#555;
            text-transform:uppercase;
            font-size:14px;
        }
        tr:hover {
            background:#f9fbfd;
        }
        .status {
            padding:5px 10px;
            border-radius:5px;
            font-weight:600;
            text-transform:capitalize;
        }
        .status.paid { background:#c8f7c5; color:#2b7a0b; }
        .status.pending { background:#fff3cd; color:#856404; }
        .status.cancelled { background:#f8d7da; color:#721c24; }
        .status.delivered { background:#d1ecf1; color:#0c5460; }
        .status.in_transit { background:#e2e3e5; color:#383d41; }
        .status.not_delivered { background:#fff3cd; color:#856404; }
        .status.returned { background:#f8d7da; color:#721c24; } /* ✅ Returned */

        .btn {
            text-decoration:none;
            padding:6px 12px;
            border-radius:6px;
            font-size:13px;
            transition:0.3s;
        }
        .btn-edit { background:#4e73df; color:white; }
        .btn-delete { background:#e74a3b; color:white; }
        .btn-edit:hover { background:#2e59d9; }
        .btn-delete:hover { background:#c0392b; }
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
    <h2>📦 Order Management</h2>
    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
</header>

<main>

    <!-- ✅ Pop-up alert for deletion -->
    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
        <script>
            alert("✅ Order deleted successfully!");
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.pathname);
            }
        </script>
    <?php endif; ?>

    <h1>Manage Customer Orders</h1>

    <table class="product-table">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Total (RM)</th>
            <th>Payment</th>
            <th>Status</th>
            <th>Shipment</th>
            <th>Delivery</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php 
                    // ✅ Generate class for delivery status dynamically
                    $deliveryClass = strtolower(str_replace(' ', '_', $row['delivery_status']));
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['customer_name']) ?></td>
                    <td><?= htmlspecialchars($row['order_date']) ?></td>
                    <td><?= number_format($row['total_amount'], 2) ?></td>

                    <td><span class="status <?= strtolower($row['payment_status']) ?>"><?= htmlspecialchars($row['payment_status']) ?></span></td>
                    <td><span class="status <?= strtolower($row['status']) ?>"><?= htmlspecialchars($row['status']) ?></span></td>
                    <td><span class="status <?= strtolower($row['shipment_status']) ?>"><?= htmlspecialchars($row['shipment_status']) ?></span></td>
                    <td><span class="status <?= $deliveryClass ?>"><?= htmlspecialchars($row['delivery_status']) ?></span></td>

                    <td>
                        <a href="view_order.php?id=<?= $row['id'] ?>" class="btn btn-edit">View</a>
                        <a href="delete_order.php?id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Delete this order?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="9">No orders found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</main>

<footer>
    © 2025 BHEINIS Admin Panel. All Rights Reserved.
</footer>

</body>
</html>
