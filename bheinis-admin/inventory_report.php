<?php
include 'config.php';

// Low stock threshold
$lowStockThreshold = 10;

// Fetch inventory data from products table
$query = "
SELECT 
    p.id AS product_id,
    p.name AS product_name,
    c.category_name,
    p.stock AS stock_quantity,
    IFNULL(SUM(oi.quantity),0) AS sold_quantity,
    p.stock - IFNULL(SUM(oi.quantity),0) AS remaining_stock
FROM products p
LEFT JOIN category c ON p.category_id = c.category_id
LEFT JOIN order_items oi ON p.id = oi.product_id
LEFT JOIN orders o ON oi.order_id = o.id AND o.payment_status='Paid'
GROUP BY p.id
ORDER BY remaining_stock ASC
";

$result = $conn->query($query);

// Data arrays
$products = [];
$remainingStock = [];
$soldQuantities = [];
$lowStockFlags = [];
$labels = [];
$lowStockProducts = []; // ✅ for notification

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $labels[] = $row['product_name'];
        $products[] = $row['product_name'];
        $remainingStock[] = $row['remaining_stock'];
        $soldQuantities[] = $row['sold_quantity'];
        $lowStockFlags[] = $row['remaining_stock'] < $lowStockThreshold ? true : false;

        if ($row['remaining_stock'] < $lowStockThreshold) {
            $lowStockProducts[] = $row['product_name'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Performance - BHEINIS</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: "Segoe UI", sans-serif; background:#f4f7fa; margin:0; color:#333; }
        header { background: linear-gradient(135deg,#4e73df,#1cc88a); padding:20px; color:white; text-align:center; position:relative; }
        .back-btn { position:absolute; left:20px; top:20px; text-decoration:none; color:white; background:rgba(0,0,0,0.2); padding:8px 14px; border-radius:6px; }
        .back-btn:hover { background:rgba(0,0,0,0.35); }
        .notification {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            padding: 12px;
            margin: 15px auto;
            max-width: 950px;
            border-radius: 8px;
            font-size: 15px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            animation: fadeIn 0.8s ease-in;
        }
        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(-10px);}
            to {opacity: 1; transform: translateY(0);}
        }
        main { max-width:950px; margin:30px auto; padding:20px; background:white; border-radius:12px; box-shadow:0 6px 15px rgba(0,0,0,0.1); }
        .chart-container { margin:20px 0; padding:20px; background:#f9fbfd; border:1px solid #eaeaea; border-radius:10px; }
        canvas { width:100% !important; height:400px !important; }
        table { width:100%; border-collapse:collapse; margin-top:15px; }
        th, td { padding:14px; text-align:center; border-bottom:1px solid #eaeaea; }
        th { background:#f1f3f6; color:#555; text-transform:uppercase; }
        tr:hover { background:#f9fbfd; }
        .table-title { margin-top:30px; margin-bottom:15px; font-size:18px; font-weight:600; border-left:5px solid #4e73df; padding-left:10px; color:#444; }
        .low-stock { background:#f8d7da !important; color:#721c24; font-weight:bold; }
    </style>
</head>
<body>

<header>
    <a href="reports.php" class="back-btn">← Back to Reports</a>
    <h2>Inventory Performance Report</h2>
</header>

<!-- ✅ Low Stock Notification -->
<?php if (!empty($lowStockProducts)): ?>
    <div class="notification">
        ⚠️ <strong>Low Stock Alert:</strong> The following products need restocking soon:<br>
        <?= implode(", ", $lowStockProducts); ?>
    </div>
<?php endif; ?>

<main>
    <!-- Chart -->
    <div class="chart-container">
        <canvas id="inventoryChart"></canvas>
    </div>

    <!-- Table -->
    <div class="table-title">📊 Inventory Data</div>
    <table>
        <tr>
            <th>Product</th>
            <th>Category</th>
            <th>Stock</th>
            <th>Sold Quantity</th>
            <th>Remaining Stock</th>
            <th>Restock?</th>
        </tr>
        <?php
        $result->data_seek(0);
        if (!empty($labels)) {
            while ($row = $result->fetch_assoc()) {
                $lowClass = $row['remaining_stock'] < $lowStockThreshold ? 'low-stock' : '';
                $restock = $row['remaining_stock'] < $lowStockThreshold ? 'Yes' : 'No';
                echo "<tr class='{$lowClass}'>
                        <td>{$row['product_name']}</td>
                        <td>{$row['category_name']}</td>
                        <td>{$row['stock_quantity']}</td>
                        <td>{$row['sold_quantity']}</td>
                        <td>{$row['remaining_stock']}</td>
                        <td>{$restock}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No inventory data found</td></tr>";
        }
        ?>
    </table>
</main>

<script>
const ctx = document.getElementById('inventoryChart').getContext('2d');

// Color for low-stock products
const backgroundColors = <?php
    $colors = [];
    foreach ($lowStockFlags as $flag) {
        $colors[] = $flag ? 'rgba(255,99,132,0.6)' : 'rgba(78,115,223,0.6)';
    }
    echo json_encode($colors);
?>;

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [
            {
                label: 'Remaining Stock',
                data: <?php echo json_encode($remainingStock); ?>,
                backgroundColor: backgroundColors
            },
            {
                label: 'Sold Quantity',
                data: <?php echo json_encode($soldQuantities); ?>,
                backgroundColor: 'rgba(28,200,138,0.6)'
            }
        ]
    },
    options: {
        responsive:true,
        plugins:{
            tooltip:{
                callbacks:{
                    label: function(context){
                        let label = context.dataset.label || '';
                        if(label) label += ': ';
                        label += context.parsed.y;
                        if(context.dataset.label === 'Remaining Stock' && context.parsed.y < <?php echo $lowStockThreshold; ?>){
                            label += ' (Low Stock!)';
                        }
                        return label;
                    }
                }
            }
        },
        scales:{ y:{ beginAtZero:true } }
    }
});
</script>

</body>
</html>
