<?php
session_start();
include '../db.php'; 

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['order_id'])) {
    die("❌ Invalid access. No order selected.");
}

$order_id = intval($_GET['order_id']);
$user_id = $_SESSION['user_id'];

// ✅ Verify that the order belongs to this user
$sql_order = "SELECT id, order_date, status, total_amount 
              FROM orders 
              WHERE id = ? AND user_id = ? LIMIT 1";
$stmt = $conn->prepare($sql_order);
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows === 0) {
    die("⚠️ Order not found or access denied.");
}
$order = $order_result->fetch_assoc();

// ✅ Fetch ordered items
$sql_items = "SELECT od.product_id, od.quantity, od.price, p.name, p.image
              FROM order_details od
              JOIN products p ON od.product_id = p.id
              WHERE od.order_id = ?";
$stmt_items = $conn->prepare($sql_items);
$stmt_items->bind_param("i", $order_id);
$stmt_items->execute();
$items_result = $stmt_items->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order #<?php echo $order_id; ?> - BHEINIS</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            padding: 20px;
        }
        .order-container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #444;
        }
        .order-info {
            margin-bottom: 20px;
            padding: 15px;
            background: #f1f1f1;
            border-radius: 8px;
        }
        .order-info p {
            margin: 6px 0;
            font-size: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table th, table td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background: #343a40;
            color: #fff;
        }
        tr:hover {
            background: #f9f9f9;
        }
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
        }
        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 8px 16px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }
        .btn-back:hover {
            background: #0056b3;
        }
        .total {
            text-align: right;
            font-weight: bold;
            font-size: 16px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="order-container">
        <h2>🛒 Order #<?php echo $order_id; ?></h2>

        <div class="order-info">
            <p><b>Date:</b> <?php echo date("d M Y", strtotime($order['order_date'])); ?></p>
            <p><b>Status:</b> <?php echo ucfirst($order['status']); ?></p>
            <p><b>Total:</b> RM <?php echo number_format($order['total_amount'], 2); ?></p>
        </div>

        <table>
            <tr>
                <th>Product</th>
                <th>Image</th>
                <th>Price (RM)</th>
                <th>Quantity</th>
                <th>Subtotal (RM)</th>
            </tr>
            <?php while ($item = $items_result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($item['name']); ?></td>
                <td><img src="uploads/<?php echo $item['image']; ?>" class="product-img"></td>
                <td><?php echo number_format($item['price'], 2); ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td><?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
            </tr>
            <?php } ?>
        </table>

        <p class="total">Grand Total: RM <?php echo number_format($order['total_amount'], 2); ?></p>

        <a href="my_orders.php" class="btn-back">⬅ Back to My Orders</a>
    </div>
</body>
</html>
