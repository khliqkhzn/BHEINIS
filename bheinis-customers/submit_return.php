<?php
session_start();
include '../db.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id']);
    $email = $_SESSION['email'] ?? '';

    if (!empty($_POST['return_products']) && is_array($_POST['return_products'])) {
        foreach ($_POST['return_products'] as $product_id => $data) {
            if (!isset($data['selected'])) continue;

            $quantity = intval($data['quantity'] ?? 1);
            $reason = trim($data['reason'] ?? '');
            $imagePath = null;

            // Handle image upload
            if (!empty($_FILES['return_products']['name'][$product_id]['image'])) {
                $targetDir = "uploads/returns/";
                if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

                $fileTmp = $_FILES['return_products']['tmp_name'][$product_id]['image'];
                $fileName = time() . "_" . basename($_FILES['return_products']['name'][$product_id]['image']);
                $targetFile = $targetDir . $fileName;

                if (move_uploaded_file($fileTmp, $targetFile)) {
                    $imagePath = $targetFile;
                }
            }

            // Insert return request
            $stmt = $conn->prepare("
                INSERT INTO returns (order_id, product_id, quantity, reason, image, email, status, request_date)
                VALUES (?, ?, ?, ?, ?, ?, 'Pending', NOW())
            ");
            $stmt->bind_param("iiisss", $order_id, $product_id, $quantity, $reason, $imagePath, $email);
            $stmt->execute();
        }

        echo "<script>
            alert('✅ Return request submitted successfully!');
            window.location.href='my_return.php';
        </script>";
        exit;

    } else {
        echo "<script>
            alert('❌ No products selected for return.');
            window.history.back();
        </script>";
        exit;
    }
} else {
    echo "<script>
        alert('❌ Invalid request.');
        window.history.back();
    </script>";
    exit;
}
?>
