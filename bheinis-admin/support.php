<?php
include("session.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Support - BHEINIS</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: #f4f7fa;
            margin: 0;
            color: #333;
        }

        header {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            color: white;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .back-btn {
            text-decoration: none;
            color: white;
            background: rgba(0, 0, 0, 0.2);
            padding: 8px 14px;
            border-radius: 6px;
            transition: background 0.3s;
        }

        .back-btn:hover {
            background: rgba(0, 0, 0, 0.35);
        }

        main {
            text-align: center;
            padding: 40px 20px;
        }

        main h1 {
            font-size: 26px;
            margin-bottom: 10px;
        }

        main p {
            color: #555;
            font-size: 16px;
            margin-bottom: 30px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
            padding: 0 40px 40px;
            max-width: 1000px;
            margin: auto;
        }

        .dashboard-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            text-decoration: none;
            color: #333;
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 18px rgba(0,0,0,0.12);
        }

        .dashboard-card h3 {
            color: #1cc88a;
            margin-bottom: 8px;
        }

        .dashboard-card p {
            color: #555;
            font-size: 15px;
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
    <h2>💬 Customer Support Center</h2>
    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
</header>

<main>
    <h1>Manage Customer Support & Feedback</h1>
    <p>Select a section to view customer feedback, returns, or support tickets:</p>

    <div class="dashboard-grid">
        <a href="admin_product_feedback.php" class="dashboard-card">
            <h3>⭐ Customer Feedback</h3>
            <p>View and respond to customer reviews and ratings.</p>
        </a>

        <a href="admin_request_return.php" class="dashboard-card">
            <h3>🔄 Return Requests</h3>
            <p>Review and process customer return requests.</p>
        </a>
    </div>
</main>

<footer>
    © 2025 BHEINIS Admin Panel. All Rights Reserved.
</footer>

</body>
</html>
