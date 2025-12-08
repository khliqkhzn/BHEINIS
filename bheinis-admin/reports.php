<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reports - BHEINIS</title>
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
            text-align:center;
            padding:40px 20px;
        }
        main h1 {
            font-size:26px;
            margin-bottom:10px;
        }
        main p {
            color:#555;
            font-size:16px;
            margin-bottom:30px;
        }
        .dashboard-grid {
            display:grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap:25px;
            padding:0 40px 40px;
            max-width:1000px;
            margin:auto;
        }
        .dashboard-card {
            background:white;
            padding:25px;
            border-radius:12px;
            text-align:center;
            text-decoration:none;
            color:#333;
            box-shadow:0 6px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        .dashboard-card:hover {
            transform:translateY(-5px);
            box-shadow:0 8px 18px rgba(0,0,0,0.12);
        }
        .dashboard-card h3 {
            color:#4e73df;
            margin-bottom:8px;
        }
        footer {
            text-align:center;
            padding:15px;
            font-size:14px;
            color:#777;
        }
    </style>
</head>
<body>

<header>
    <h2>📊 Reports Dashboard</h2>
    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
</header>

<main>
    <h1>Admin Report Dashboard</h1>
    <p>Select the report you would like to view below:</p>

    <div class="dashboard-grid">
        <a href="sales_report.php" class="dashboard-card">
            <h3>💰 Sales Report</h3>
            <p>View detailed sales performance, transactions, and trends.</p>
        </a>

        <a href="customer_activity_report.php" class="dashboard-card">
            <h3>👥 Customer Activity Report</h3>
            <p>Analyze user behavior, interactions, and feedback.</p>
        </a>

        <a href="inventory_report.php" class="dashboard-card">
            <h3>📦 Inventory Performance Report</h3>
            <p>Monitor product stock levels, sales, and restocking needs.</p>
        </a>
    </div>
</main>

<footer>
    © 2025 BHEINIS Admin Panel. All Rights Reserved.
</footer>

</body>
</html>
