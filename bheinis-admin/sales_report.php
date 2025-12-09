<?php
include '../db.php';


// Get the report type from the button menu, default to monthly
$type = $_GET['type'] ?? 'monthly';

// Prepare arrays for chart/table
$labels = [];
$totals = [];

if ($type == 'daily') {
    // Daily sales
    $query = "
        SELECT DATE(order_date) AS label, COUNT(id) AS total_orders
        FROM orders
        WHERE payment_status = 'Paid'
        GROUP BY label
        ORDER BY label ASC
    ";
} elseif ($type == 'weekly') {
    // Weekly sales
    $query = "
        SELECT YEAR(order_date) AS year, WEEK(order_date, 1) AS week, COUNT(id) AS total_orders
        FROM orders
        WHERE payment_status = 'Paid'
        GROUP BY year, week
        ORDER BY year ASC, week ASC
    ";
} else {
    // Monthly sales
    $query = "
        SELECT DATE_FORMAT(order_date, '%Y-%m') AS label, COUNT(id) AS total_orders
        FROM orders
        WHERE payment_status = 'Paid'
        GROUP BY label
        ORDER BY label ASC
    ";
}

$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($type == 'weekly') {
            $labels[] = "Week {$row['week']} ({$row['year']})";
        } else {
            $labels[] = $row['label'];
        }
        $totals[] = $row['total_orders'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Report - BHEINIS</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: "Segoe UI", sans-serif; background: #f4f7fa; color: #333; margin:0; }
        header { background: linear-gradient(135deg, #4e73df, #1cc88a); padding: 20px; color: white; position: relative; text-align:center; }
        .back-btn { position: absolute; left: 20px; top: 20px; text-decoration:none; color:white; background: rgba(0,0,0,0.2); padding:8px 14px; border-radius:6px; }
        .back-btn:hover { background: rgba(0,0,0,0.35); }
        main { max-width: 950px; margin: 30px auto; padding: 20px; background:white; border-radius:12px; box-shadow:0 6px 15px rgba(0,0,0,0.1);}
        .chart-container { margin:20px 0; padding:20px; background:#f9fbfd; border:1px solid #eaeaea; border-radius:10px; }
        canvas { width: 100% !important; height: 400px !important; }
        table { width:100%; border-collapse:collapse; margin-top:15px;}
        th, td { padding:14px; text-align:center; border-bottom:1px solid #eaeaea;}
        th { background:#f1f3f6; color:#555; text-transform:uppercase;}
        tr:hover { background:#f9fbfd;}
        .button-menu { text-align:center; margin:20px 0; }
        .report-btn {
            display:inline-block;
            text-decoration:none;
            color:#4e73df;
            background:#f1f3f6;
            padding:10px 20px;
            margin:0 10px;
            border-radius:8px;
            font-weight:600;
            transition: all 0.3s ease;
            box-shadow:0 2px 6px rgba(0,0,0,0.1);
        }
        .report-btn:hover {
            background:#4e73df;
            color:white;
            transform: translateY(-2px);
            box-shadow:0 4px 12px rgba(0,0,0,0.2);
        }
        .report-btn.active {
            background:#4e73df;
            color:white;
            box-shadow:0 4px 12px rgba(0,0,0,0.2);
        }
        .table-title { margin-top: 30px; margin-bottom: 15px; font-size: 18px; font-weight:600; border-left:5px solid #4e73df; padding-left:10px; color:#444; }
    </style>
</head>
<body>

<header>
    <a href="reports.php" class="back-btn">← Back to Reports</a>
    <h2>Sales Report</h2>
</header>

<main>

    <!-- Button Menu -->
    <div class="button-menu">
        <a href="sales_report.php?type=daily" class="report-btn <?= $type=='daily'?'active':'' ?>">📅 Daily</a>
        <a href="sales_report.php?type=weekly" class="report-btn <?= $type=='weekly'?'active':'' ?>">📊 Weekly</a>
        <a href="sales_report.php?type=monthly" class="report-btn <?= $type=='monthly'?'active':'' ?>">📈 Monthly</a>
    </div>

    <!-- Chart -->
    <div class="chart-container">
        <canvas id="salesChart"></canvas>
    </div>

    <!-- Table -->
    <div class="table-title">📊 <?= ucfirst($type) ?> Sales Data</div>
    <table>
        <tr>
            <th><?= ucfirst($type=='weekly'?'Week':($type=='daily'?'Date':'Month')) ?></th>
            <th>Total Orders</th>
        </tr>
        <?php
        if (!empty($labels)) {
            for ($i=0; $i<count($labels); $i++) {
                echo "<tr><td>{$labels[$i]}</td><td>{$totals[$i]}</td></tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No sales data found</td></tr>";
        }
        ?>
    </table>

</main>

<script>
const ctx = document.getElementById('salesChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: 'Total Orders',
            data: <?php echo json_encode($totals); ?>,
            borderColor: '#4e73df',
            backgroundColor: 'rgba(78,115,223,0.2)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#1cc88a',
            pointRadius: 6
        }]
    },
    options: { responsive:true }
});
</script>

</body>
</html>
