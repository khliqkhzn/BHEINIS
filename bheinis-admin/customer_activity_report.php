<?php 
session_start();
include '../db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// ===============================
// 🕒 1. Display current activities
// ===============================
$sql = "SELECT ca.activity_id, u.name, u.email, ca.activity_type, ca.activity_details, ca.activity_time,
        DATEDIFF(NOW(), ca.activity_time) AS data_age
        FROM customer_activity ca
        JOIN users u ON ca.user_id = u.id
        ORDER BY ca.activity_time DESC";
$result = $conn->query($sql);

// ===============================
// 📦 2. Archive last month’s records and send email
// ===============================
$start_date = date("Y-m-01", strtotime("-1 month"));
$end_date = date("Y-m-t", strtotime("-1 month"));

$old_records_sql = "SELECT * FROM customer_activity 
                    WHERE activity_time BETWEEN '$start_date' AND '$end_date'";
$old_result = $conn->query($old_records_sql);

if ($old_result && $old_result->num_rows > 0) {
    $email_body = "📅 Customer Activity Report for $start_date to $end_date\n\n";
    $count = 0;

    while($r = $old_result->fetch_assoc()) {
        // Insert into archive
        $stmt = $conn->prepare("INSERT INTO customer_activity_archive (activity_id, user_id, activity_type, activity_details, activity_time)
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $r['activity_id'], $r['user_id'], $r['activity_type'], $r['activity_details'], $r['activity_time']);
        $stmt->execute();
        $stmt->close();

        // Build email content
        $email_body .= "ID: {$r['activity_id']}\n";
        $email_body .= "User ID: {$r['user_id']}\n";
        $email_body .= "Type: {$r['activity_type']}\n";
        $email_body .= "Details: {$r['activity_details']}\n";
        $email_body .= "Time: {$r['activity_time']}\n";
        $email_body .= "-------------------------------------------\n";
        $count++;
    }

    // Send email using Gmail SMTP
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nrkhaliqkha@gmail.com'; // 🔹 your Gmail
        $mail->Password = 'eqig zflv teob wxvz';   // 🔹 your Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('suhainisuliman.ss@gmail.com', 'BHEINIS System');
        $mail->addAddress('suhainisuliman.ss@gmail.com'); // 🔹 admin email

        $mail->isHTML(false);
        $mail->Subject = "Monthly Archived Customer Activity ($start_date to $end_date)";
        $mail->Body = $email_body;

        $mail->send();
        echo "<script>alert('✅ Monthly report successfully emailed to admin.');</script>";
    } catch (Exception $e) {
        echo "<script>alert('❌ Email failed: {$mail->ErrorInfo}');</script>";
    }

    // Delete only after emailing
    $conn->query("DELETE FROM customer_activity 
                  WHERE activity_time BETWEEN '$start_date' AND '$end_date'");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Activity Log</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f4f7fa;
            color: #333;
        }

        header {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            padding: 20px;
            color: white;
            position: relative;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        header h2 {
            margin-bottom: 10px;
            font-size: 28px;
            letter-spacing: 1px;
            text-align: center;
        }

        .back-btn {
            position: absolute;
            left: 20px;
            top: 20px;
            text-decoration: none;
            color: white;
            background: rgba(0,0,0,0.2);
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 14px;
            transition: 0.3s;
        }

        .back-btn:hover {
            background: rgba(0,0,0,0.35);
        }

        nav {
            margin-top: 10px;
            text-align: center;
        }

        nav a {
            text-decoration: none;
            color: white;
            margin: 0 15px;
            padding: 8px 14px;
            border-radius: 6px;
            transition: background 0.3s ease;
            font-weight: 500;
        }

        nav a:hover,
        nav a.active {
            background: rgba(255,255,255,0.2);
        }

        main {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="date"] {
            padding: 8px;
            margin: 0 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            padding: 8px 14px;
            background-color: #4e73df;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2e59d9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #eaeaea;
        }

        th {
            background: #f1f3f6;
            font-size: 15px;
            font-weight: 600;
            text-transform: uppercase;
            color: #555;
        }

        tr:hover {
            background: #f9fbfd;
        }

        td {
            font-size: 14px;
            color: #444;
        }

        .message {
            text-align: center;
            margin: 10px 0;
            color: #1cc88a;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            table {
                font-size: 12px;
            }
            th, td {
                padding: 10px;
            }
            header h2 {
                font-size: 22px;
            }
            .back-btn {
                font-size: 12px;
                padding: 6px 10px;
            }
        }
    </style>
</head>
<body>
    <header>
        <a href="reports.php" class="back-btn">← Back to Report</a>
        <h2>Customer Activity Report</h2>
        <nav>
            <a href="customer_activity_report.php" class="active">Table View</a>
            <a href="customer_activity_charts.php">Graphical View</a>
        </nav>
    </header>

    <main>
        <form method="get">
            <label>Start Date:</label>
            <input type="date" name="start_date" required value="<?= htmlspecialchars($start_date) ?>">
            <label>End Date:</label>
            <input type="date" name="end_date" required value="<?= htmlspecialchars($end_date) ?>">
            <button type="submit">Archive & Email</button>
        </form>

        <?php if (!empty($message)): ?>
            <div class="message"><?= $message; ?></div>
        <?php endif; ?>

        <table>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Email</th>
                <th>Activity Type</th>
                <th>Details</th>
                <th>Time</th>
                <th>Data Age (Days)</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['activity_id']; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['email']; ?></td>
                <td><?= $row['activity_type']; ?></td>
                <td><?= $row['activity_details']; ?></td>
                <td><?= $row['activity_time']; ?></td>
                <td><?= $row['data_age']; ?> days</td>
            </tr>
            <?php endwhile; ?>
        </table>
    </main>
</body>
</html>
