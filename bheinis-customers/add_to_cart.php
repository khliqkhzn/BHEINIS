<?php
session_start();
include '../db.php'; 

// ✅ Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>
        alert('❌ Please log in to add products to your cart.');
        window.location.href = 'login.php';
    </script>";
    exit;
}

// ✅ Validate product ID
if (!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id'])) {
    die("❌ Invalid product ID.");
}

$product_id = intval($_REQUEST['id']);
$user_id = $_SESSION['user_id'];
$quantity = isset($_REQUEST['qty']) ? intval($_REQUEST['qty']) : 1;
$size = isset($_REQUEST['size']) ? trim($_REQUEST['size']) : '';

if (empty($size)) {
    die("❌ Please select a product size.");
}

// Accept color from GET or POST
$color = isset($_REQUEST['color']) && $_REQUEST['color'] !== '' ? trim($_REQUEST['color']) : null;

// ------------------------
// Step 1: Check or create cart
// ------------------------
$sql = "SELECT id FROM cart WHERE user_id = ? AND status = 'open' LIMIT 1";
$stmt = $conn->prepare($sql);
if (!$stmt) { die("Prepare failed (cart check): " . $conn->error); }
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $cart_id = $result->fetch_assoc()['id'];
} else {
    $stmt2 = $conn->prepare("INSERT INTO cart (user_id, status) VALUES (?, 'open')");
    if (!$stmt2) { die("Prepare failed (cart insert): " . $conn->error); }
    $stmt2->bind_param("i", $user_id);
    $stmt2->execute();
    $cart_id = $stmt2->insert_id;
}

// ------------------------
// Step 2: Insert or update cart_items
// ------------------------
if ($color) {
    $check_sql = "SELECT id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ? AND size = ? AND color = ?";
    $check = $conn->prepare($check_sql);
    if (!$check) { die("Prepare failed (check color): " . $conn->error); }
    $check->bind_param("iiss", $cart_id, $product_id, $size, $color);
} else {
    $check_sql = "SELECT id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ? AND size = ? AND (color IS NULL OR color = '')";
    $check = $conn->prepare($check_sql);
    if (!$check) { die("Prepare failed (check no color): " . $conn->error); }
    $check->bind_param("iis", $cart_id, $product_id, $size);
}

$check->execute();
$check_result = $check->get_result();

if ($check_result->num_rows > 0) {
    // Update quantity
    $existing = $check_result->fetch_assoc();
    $new_quantity = $existing['quantity'] + $quantity;
    $update = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
    if (!$update) { die("Prepare failed (update quantity): " . $conn->error); }
    $update->bind_param("ii", $new_quantity, $existing['id']);
    $update->execute();
} else {
    // Insert new item
    $insert = $conn->prepare("INSERT INTO cart_items (cart_id, product_id, size, quantity, color) VALUES (?, ?, ?, ?, ?)");
    if (!$insert) { die("Prepare failed (insert item): " . $conn->error); }
    $insert->bind_param("iisis", $cart_id, $product_id, $size, $quantity, $color);
    $insert->execute();
}

// ------------------------
// Step 3: Log customer activity
// ------------------------
$product_query = $conn->prepare("SELECT name FROM products WHERE id = ?");
if (!$product_query) { die("Prepare failed (product name): " . $conn->error); }
$product_query->bind_param("i", $product_id);
$product_query->execute();
$product_query->bind_result($product_name);
$product_query->fetch();
$product_query->close();

$activity_type = "Add to Cart";
$activity_details = "Added product: " . $product_name . " (Size: " . $size . ", Qty: " . $quantity . ($color ? ", Color: $color" : "") . ")";
$log = $conn->prepare("INSERT INTO customer_activity (user_id, activity_type, activity_details) VALUES (?, ?, ?)");
if (!$log) { die("Prepare failed (activity log): " . $conn->error); }
$log->bind_param("iss", $user_id, $activity_type, $activity_details);
$log->execute();

// ✅ Redirect to cart
header("Location: cart.php");
exit;
?>
