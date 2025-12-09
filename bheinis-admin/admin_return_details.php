<?php
session_start();
include '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$return_id = intval($_GET['id']);

// ✅ Fetch the selected return request
$stmt = $conn->prepare("
    SELECT 
        r.*, 
        p.name AS product_name
    FROM returns r
    JOIN products p ON r.product_id = p.id
    WHERE r.id = ?
");
$stmt->bind_param("i", $return_id);
$stmt->execute();
$result = $stmt->get_result();
$return = $result->fetch_assoc();

if (!$return) {
    die("Return request not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Return Details - BHEINIS</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        body {
            background: #f7f9fc;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background: #fff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        /* Two-column layout */
        .details-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            align-items: flex-start;
        }

        /* Left side: Info + Update Form */
        .left-side {
            flex: 1;
            min-width: 400px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .info p {
            margin: 10px 0;
            color: #444;
        }

        /* Form below the details */
        .form-section {
            margin-top: 25px;
            padding: 20px;
            border-radius: 12px;
            background: #f8f9fa;
            border: 1px solid #eee;
            text-align: center;
        }

        .form-section label {
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
        }

        select {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            width: 80%;
            margin: 10px auto 15px;
            background: #fff;
            display: block;
        }

        button {
            background: #000;
            color: #fff;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }

        button:hover {
            background: #333;
        }

        /* Right side: Image only */
        .image-box {
            flex: 1;
            min-width: 300px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .return-image {
            width: 100%;
            max-width: 320px;
            border-radius: 10px;
            object-fit: cover;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .back-link {
            display: inline-block;
            margin-bottom: 15px;
            color: #555;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        /* Responsive layout */
        @media (max-width: 768px) {
            .details-wrapper {
                flex-direction: column;
            }
            .left-side, .image-box {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <a href="admin_request_return.php" class="back-link">← Back to Return List</a>
    <h2>Return Request Details</h2>

    <div class="details-wrapper">
        <!-- LEFT SIDE: Info + Form -->
        <div class="left-side">
            <div class="info">
                <p><strong>Order ID:</strong> #<?= $return['order_id'] ?></p>
                <p><strong>Product:</strong> <?= htmlspecialchars($return['product_name']) ?></p>
                <p><strong>Quantity:</strong> <?= $return['quantity'] ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($return['email']) ?></p>
                <p><strong>Reason:</strong> <?= nl2br(htmlspecialchars($return['reason'])) ?></p>
            </div>

            <div class="form-section">
                <form action="admin_update_return.php" method="POST">
                    <input type="hidden" name="return_id" value="<?= $return['id'] ?>">
                    <label for="status">Update Status:</label>
                    <select name="status" id="status" required>
                        <option value="Pending" <?= $return['status']=='Pending'?'selected':'' ?>>Pending</option>
                        <option value="Approved" <?= $return['status']=='Approved'?'selected':'' ?>>Approved</option>
                        <option value="Rejected" <?= $return['status']=='Rejected'?'selected':'' ?>>Rejected</option>
                    </select>
                    <button type="submit">Update Status</button>
                </form>
            </div>
        </div>

        <!-- RIGHT SIDE: Image -->
        <div class="image-box">
            <?php
            $imagePath = "../bheinis-customers/" . htmlspecialchars($return['image']);
            $fullPath = __DIR__ . "/../bheinis-customers/" . $return['image'];

            if (!empty($return['image']) && file_exists($fullPath)) {
                echo '<img src="' . $imagePath . '" class="return-image" alt="Return Image">';
            } else {
                echo '<img src="assets/no-image.png" class="return-image" alt="No Image">';
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
