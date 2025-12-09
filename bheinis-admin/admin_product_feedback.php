<?php
session_start();
include '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// ✅ Fetch Product Feedback (adjusted to your actual table)
$feedbacks = $conn->query("
    SELECT f.feedback_id, f.user_id, f.product_id, f.rating, f.comment, f.feedback_date,
           u.name AS customer_name, p.name AS product_name, f.admin_reply
    FROM feedback f
    JOIN users u ON f.user_id = u.id
    JOIN products p ON f.product_id = p.id
    ORDER BY f.feedback_id DESC
");

// ✅ Error check for debugging
if (!$feedbacks) {
    die('SQL Error: ' . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Feedback - Admin Panel</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #1e88e5;
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        header a.back-btn {
            position: absolute;
            left: 20px;
            top: 20px;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        nav {
            margin-top: 10px;
        }

        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            padding: 6px 10px;
            border-radius: 5px;
        }

        nav a.active, nav a:hover {
            background-color: #0d47a1;
        }

        main {
            width: 90%;
            margin: 40px auto;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px 12px;
            text-align: left;
        }

        table th {
            background-color: #1e88e5;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        input[type="text"] {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            width: 80%;
        }

        button {
            background-color: #1e88e5;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background-color: #0d47a1;
        }
    </style>
</head>
<body>
<header>
    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
    <h2>Product Feedback</h2>
</header>

<main>
    <h3>Customer Product Feedback</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Product</th>
            <th>Rating</th>
            <th>Comment</th>
            <th>Date</th>
            <th>Admin Reply</th>
            <th>Action</th>
        </tr>

        <?php while ($f = $feedbacks->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($f['feedback_id']) ?></td>
            <td><?= htmlspecialchars($f['customer_name']) ?></td>
            <td><?= htmlspecialchars($f['product_name']) ?></td>
            <td><?= htmlspecialchars($f['rating']) ?>/5</td>
            <td><?= nl2br(htmlspecialchars($f['comment'])) ?></td>
            <td><?= htmlspecialchars($f['feedback_date']) ?></td>
            <td><?= nl2br(htmlspecialchars($f['admin_reply'] ?? '—')) ?></td>
            <td>
                <form action="admin_reply_feedback.php" method="POST">
                    <input type="hidden" name="feedback_id" value="<?= $f['feedback_id'] ?>">
                    <input type="text" name="admin_reply" placeholder="Type reply..." required>
                    <button type="submit">Send</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</main>
</body>
</html>
