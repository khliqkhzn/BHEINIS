<?php
include("session.php");
include("config.php");

if (!isset($_GET['id'])) {
    die("Invalid request.");
}
$order_id = intval($_GET['id']);

// ✅ Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $payment_status = $_POST['payment_status'];
    $shipment_status = $_POST['shipment_status'];
    $delivery_status = $_POST['delivery_status'];

    // ✅ If admin sets Delivered, update delivery_date automatically
    if ($delivery_status === 'Delivered') {
        $stmt = $conn->prepare("UPDATE orders 
            SET status=?, payment_status=?, shipment_status=?, delivery_status=?, delivery_date=CURDATE()
            WHERE id=?");
        $stmt->bind_param("ssssi", $status, $payment_status, $shipment_status, $delivery_status, $order_id);
    } else {
        // ✅ If admin sets Returned, keep delivery_date (do not change)
        $stmt = $conn->prepare("UPDATE orders 
            SET status=?, payment_status=?, shipment_status=?, delivery_status=?
            WHERE id=?");
        $stmt->bind_param("ssssi", $status, $payment_status, $shipment_status, $delivery_status, $order_id);
    }

    $stmt->execute();
    $stmt->close();

    echo "<script>alert('✅ Order updated successfully!'); window.location.href='orders.php';</script>";
    exit;
}

// ✅ Fetch order
$stmt = $conn->prepare("SELECT * FROM orders WHERE id=? LIMIT 1");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Order #<?= $order_id ?> - BHEINIS</title>
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
        header h2 { margin: 0; }
        .container { max-width: 650px; margin: 60px auto; background: #fff; border-radius: 20px; padding: 40px; box-shadow: 0 6px 18px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #333; margin-bottom: 25px; }
        form label { display: block; margin: 10px 0 5px; font-weight: 600; }
        form select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box; }
        form button { width: 100%; padding: 12px; background: #4e73df; color: white; border: none; border-radius: 10px; font-size: 16px; font-weight: bold; margin-top: 20px; cursor: pointer; }
        form button:hover { background: #3758c8; }
        .nav-left { text-align: left; margin-bottom: 15px; }
        .nav-left a { text-decoration: none; color: #007bff; font-weight: bold; transition: color 0.3s; }
        .nav-left a:hover { color: #0056b3; text-decoration: underline; }
        footer { text-align: center; padding: 15px; font-size: 14px; color: #777; margin-top: 30px; }
    </style>
</head>
<body>

<header>
    <h2>🧾 View / Update Order</h2>
    <a href="dashboard.php" style="color:white; text-decoration:none; font-weight:bold;">🏠 Dashboard</a>
</header>

<div class="container">
    <div class="nav-left">
        <a href="orders.php">← Back to Orders</a>
    </div>

    <h1>Update Order #<?= $order['id'] ?></h1>

    <form method="post">
        <label>Status</label>
        <select name="status">
            <option value="Pending" <?= $order['status']=="Pending"?"selected":"" ?>>Pending</option>
            <option value="Processing" <?= $order['status']=="Processing"?"selected":"" ?>>Processing</option>
            <option value="Completed" <?= $order['status']=="Completed"?"selected":"" ?>>Completed</option>
            <option value="Cancelled" <?= $order['status']=="Cancelled"?"selected":"" ?>>Cancelled</option>
        </select>

        <label>Payment Status</label>
        <select name="payment_status">
            <option value="Pending" <?= $order['payment_status']=="Pending"?"selected":"" ?>>Pending</option>
            <option value="Paid" <?= $order['payment_status']=="Paid"?"selected":"" ?>>Paid</option>
            <option value="Failed" <?= $order['payment_status']=="Failed"?"selected":"" ?>>Failed</option>
        </select>

        <label>Shipment Status</label>
        <select name="shipment_status">
            <option value="Pending" <?= $order['shipment_status']=="Pending"?"selected":"" ?>>Pending</option>
            <option value="Processing" <?= $order['shipment_status']=="Processing"?"selected":"" ?>>Processing</option>
            <option value="Shipped" <?= $order['shipment_status']=="Shipped"?"selected":"" ?>>Shipped</option>
        </select>

        <label>Delivery Status</label>
        <select name="delivery_status">
            <option value="Not Delivered" <?= $order['delivery_status']=="Not Delivered"?"selected":"" ?>>Not Delivered</option>
            <option value="In Transit" <?= $order['delivery_status']=="In Transit"?"selected":"" ?>>In Transit</option>
            <option value="Delivered" <?= $order['delivery_status']=="Delivered"?"selected":"" ?>>Delivered</option>
            <option value="Returned" <?= $order['delivery_status']=="Returned"?"selected":"" ?>>Returned</option>
        </select>

        <button type="submit">💾 Save Changes</button>
    </form>
</div>

<footer>
    © 2025 BHEINIS Admin Panel. All Rights Reserved.
</footer>

</body>
</html>
