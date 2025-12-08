<?php
// header.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BHEINIS Admin Panel</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fafafa;
            margin: 0;
            padding: 0;
        }

        .admin-header {
            background-color: #222;
            color: #fff;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 4px solid #f9b208;
        }

        .admin-header h2 {
            margin: 0;
            font-size: 22px;
        }

        .btn-dashboard, .btn-logout {
            background: #f9b208;
            color: #222;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            margin-left: 10px;
            font-weight: bold;
        }

        .btn-dashboard:hover, .btn-logout:hover {
            background: #ffcc00;
        }

        .admin-content {
            padding: 30px;
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="header-left">
            <h2>BHEINIS Admin Panel</h2>
        </div>
        <div class="header-right">
            <a href="dashboard.php" class="btn-dashboard">🏠 Dashboard</a>
            <a href="logout.php" class="btn-logout" onclick="return confirm('Logout from admin panel?');">🚪 Logout</a>
        </div>
    </header>
    <main class="admin-content">
