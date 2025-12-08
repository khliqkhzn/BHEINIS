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
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - BHEINIS</title>
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
        .dashboard-grid {
            display:grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap:20px;
            padding:30px;
        }
        .dashboard-card {
            background:white;
            padding:20px;
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
        .logout-card {
            background:#f8d7da;
            color:#721c24;
        }
        .notification {
            position:relative;
            cursor:pointer;
        }
        .notification .badge {
            position:absolute;
            top:-8px;
            right:-8px;
            background:red;
            color:white;
            border-radius:50%;
            padding:4px 8px;
            font-size:12px;
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
    <h2>👑 Admin Dashboard</h2>
    <div class="notification" onclick="window.location='inventory_report.php'">
        🔔
        <?php if ($lowStockCount > 0): ?>
            <span class="badge"><?php echo $lowStockCount; ?></span>
        <?php endif; ?>
    </div>
</header>

<?php if ($lowStockCount > 0): ?>
    <div class="alert-box" id="lowStockAlert">
        <span>⚠️ <?php echo $lowStockCount; ?> product(s) are low on stock! Please <a href="inventory_report.php">restock here</a>.</span>
        <button onclick="document.getElementById('lowStockAlert').style.display='none'">✖</button>
    </div>
<?php endif; ?>

<div class="dashboard-grid">
    <a href="skip_otp_setting.php" class="dashboard-card">
        <h3>Skip OTP Setting</h3>
        <p>Set period of time skip OTP for both users.</p>
    </a>

    <a href="categories.php" class="dashboard-card">
        <h3>Manage Products</h3>
        <p>Add, edit, or remove clothing products.</p>
    </a>

    <a href="orders.php" class="dashboard-card">
        <h3>Manage Orders</h3>
        <p>Track and update customer orders.</p>
    </a>

    <a href="reports.php" class="dashboard-card">
        <h3>View Reports</h3>
        <p>Sales and inventory statistics.</p>
    </a>

    <a href="support.php" class="dashboard-card">
        <h3>Customer Support</h3>
        <p>View and resolve customer issues.</p>
    </a>

    <a href="logout.php" class="dashboard-card logout-card">
        <h3>Logout</h3>
        <p>Sign out from the admin system.</p>
    </a>
</div>

</body>
<footer>
    © 2025 BHEINIS Admin Panel. All Rights Reserved.
</footer>

</html>
