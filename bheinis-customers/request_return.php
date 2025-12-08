<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$order_id = $_GET['order_id'] ?? 0;

// Fetch products for this order
$stmt = $conn->prepare("
    SELECT oi.product_id, oi.quantity, p.name, p.price 
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                $fileType = mime_content_type($fileTmp);
                $ext = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                if (in_array($fileType, $allowedTypes) && in_array($ext, ['jpg','jpeg','png'])) {
                    move_uploaded_file($fileTmp, $targetFile);
                    $imagePath = $targetFile;
                }
            }

            // Insert return request
            $stmtIns = $conn->prepare("
                INSERT INTO returns (order_id, product_id, quantity, reason, image, email)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmtIns->bind_param("iiisss", $order_id, $product_id, $quantity, $reason, $imagePath, $email);
            $stmtIns->execute();
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Request Return - BHEINIS</title>
<link rel="stylesheet" href="assets2/style2.css">
<style>
body { background: #f7f7f7; font-family: 'Poppins', sans-serif; }
.return-form { max-width: 800px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
h2 { text-align: center; font-size: 22px; margin-bottom: 20px; color: #333; }
.product-box { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 10px; background: #fafafa; }
label { font-weight: 600; display: block; margin-bottom: 6px; }
input, select { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 6px; margin-bottom: 10px; }
.submit-btn { background: #000; color: #fff; border: none; padding: 12px 20px; border-radius: 8px; width: 100%; font-weight: bold; cursor: pointer; transition: 0.3s; }
.submit-btn:hover { background: #333; }
</style>
</head>
<body>
<div class="return-form">
  <h2>Request Return (Order #<?= htmlspecialchars($order_id) ?>)</h2>

  <?php if (!empty($products)): ?>
  <form action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="order_id" value="<?= $order_id ?>">

    <?php foreach ($products as $p): ?>
      <div class="product-box">
        <label>
          <input type="checkbox" name="return_products[<?= $p['product_id'] ?>][selected]" class="product-checkbox" value="1">
          <?= htmlspecialchars($p['name']) ?> — RM<?= number_format($p['price'], 2) ?> (Qty: <?= $p['quantity'] ?>)
        </label>

        <label>Quantity to return</label>
        <input type="number" name="return_products[<?= $p['product_id'] ?>][quantity]" min="1" max="<?= $p['quantity'] ?>" value="1">

        <label>Reason</label>
        <select name="return_products[<?= $p['product_id'] ?>][reason]" class="reason-select" disabled>
          <option value="">-- Select Reason --</option>
          <option value="Damaged">Damaged</option>
          <option value="Wrong Item">Wrong Item</option>
          <option value="Not as Described">Not as Described</option>
          <option value="Other">Other</option>
        </select>

        <label>Upload Image (optional)</label>
        <input type="file" name="return_products[<?= $p['product_id'] ?>][image]" class="image-upload" accept=".jpg,.jpeg,.png" disabled>
      </div>
    <?php endforeach; ?>

    <button type="submit" class="submit-btn">Submit Return Request</button>
  </form>
  <?php else: ?>
    <p>No products found for this order.</p>
  <?php endif; ?>
</div>

<script>
// Enable reason and image only if checkbox is checked
document.querySelectorAll('.product-checkbox').forEach(cb => {
    cb.addEventListener('change', function() {
        const parent = cb.closest('.product-box');
        const reason = parent.querySelector('.reason-select');
        const image = parent.querySelector('.image-upload');
        if(cb.checked){
            reason.disabled = false;
            reason.required = true;
            image.disabled = false;
        } else {
            reason.disabled = true;
            reason.required = false;
            reason.value = "";
            image.disabled = true;
            image.value = "";
        }
    });
});
</script>
</body>
</html>
