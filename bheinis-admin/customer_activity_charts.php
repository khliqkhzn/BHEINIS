<?php
session_start();
include 'config.php';

// Group activity count by type
$sql = "SELECT activity_type, COUNT(*) as total FROM customer_activity GROUP BY activity_type";
$result = $conn->query($sql);

$activityTypes = [];
$activityCounts = [];
while($row = $result->fetch_assoc()) {
    $activityTypes[] = $row['activity_type'];
    $activityCounts[] = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Activity Graph</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* General Page Style */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background: linear-gradient(to right, #e3f2fd, #f9fbe7);
            color: #333;
        }

        header {
            background: #4e79a7;
            color: #fff;
            padding: 20px;
            text-align: center;
            box-shadow: 0px 2px 8px rgba(0,0,0,0.15);
        }

        header h2 {
            margin: 0;
            font-size: 28px;
        }

        nav {
            margin-top: 10px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            padding: 8px 14px;
            border-radius: 5px;
            transition: background 0.3s;
            font-weight: bold;
        }

        nav a:hover {
            background: rgba(255,255,255,0.2);
        }

         /* Back button (left corner) */
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


        nav a.active {
            background: #2e5d8a;
        }

        .chart-container {
            width: 75%;
            max-width: 900px;
            margin: 50px auto;
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.15);
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(20px);}
            to {opacity: 1; transform: translateY(0);}
        }

        canvas {
            width: 100% !important;
            height: 500px !important;
        }
    </style>
</head>
<body>
    <header>
        <h2>Customer Activity Report</h2>
        <nav>
            <a href="reports.php" class="back-btn">← Back to Report</a>
            <a href="customer_activity_report.php">Table View</a>
            <a href="customer_activity_charts.php" class="active">Graphical View</a>
        </nav>
    </header>

    <main class="chart-container">
        <canvas id="activityChart"></canvas>
    </main>

    <script>
        const ctx = document.getElementById('activityChart').getContext('2d');
        const activityChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($activityTypes); ?>,
                datasets: [{
                    label: 'Number of Activities',
                    data: <?= json_encode($activityCounts); ?>,
                    backgroundColor: [
                        '#4e79a7', '#f28e2c', '#e15759',
                        '#76b7b2', '#59a14f', '#edc949',
                        '#af7aa1', '#ff9da7'
                    ],
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: '📊 Customer Activities by Type',
                        font: { size: 20, weight: 'bold' },
                        color: '#333'
                    }
                },
                scales: {
                    x: {
                        ticks: { font: { size: 14 } }
                    },
                    y: { 
                        beginAtZero: true,
                        ticks: { font: { size: 14 } }
                    }
                }
            }
        });
    </script>
</body>
</html>
