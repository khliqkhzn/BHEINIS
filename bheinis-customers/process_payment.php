<?php
session_start();
include '../db.php'; 

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// ✅ Collect POST data safely
$amount           = floatval($_POST['amount'] ?? 0);
$cart_id          = intval($_POST['cart_id'] ?? 0);
$payment_method   = $_POST['payment_method'] ?? '';
$delivery         = $_POST['delivery'] ?? 'ship';

// ✅ Card details
$card_name = trim($_POST['card_name'] ?? '');
$card_num  = preg_replace('/\s+/', '', $_POST['card_number'] ?? '');
$cvc       = trim($_POST['cvc'] ?? '');
$expiry    = trim($_POST['expiry'] ?? '');

// ✅ eWallet details
$ewallet_type = $_POST['ewallet_type'] ?? '';
$ewallet_id   = trim($_POST['ewallet_id'] ?? '');

// ✅ Address details
$full_name = trim($_POST['full_name'] ?? '');
$address   = trim($_POST['address'] ?? '');
$address2  = trim($_POST['address2'] ?? '');
$postcode  = trim($_POST['postcode'] ?? '');
$city      = trim($_POST['city'] ?? '');
$state     = trim($_POST['state'] ?? '');
$phone     = trim($_POST['phone'] ?? '');

// ✅ Validate payment method
if (empty($payment_method)) {
    $_SESSION['checkout_error'] = "❌ Missing payment method.";
    header("Location: payment.php");
    exit;
}

// ✅ Card validation
function is_expiry_valid_after_current($expiry_str) {
    $expiry_str = trim($expiry_str);
    if (!preg_match('/^(0[1-9]|1[0-2])[\/\-](\d{2}|\d{4})$/', $expiry_str, $m)) {
        return false;
    }
    $exp_month = intval($m[1]);
    $exp_year = intval($m[2]);
    if (strlen($m[2]) === 2) $exp_year += 2000;

    $now = new DateTime();
    $cur_month = intval($now->format('n'));
    $cur_year = intval($now->format('Y'));

    return ($exp_year > $cur_year) || ($exp_year === $cur_year && $exp_month >= $cur_month);
}

if ($payment_method === 'card') {
    if (!preg_match('/^\d{16}$/', $card_num)) {
        $_SESSION['checkout_error'] = "❌ Card number must be exactly 16 digits.";
        header("Location: payment.php");
        exit;
    }
    if (!preg_match('/^\d{3}$/', $cvc)) {
        $_SESSION['checkout_error'] = "❌ Invalid CVC (must be 3 digits).";
        header("Location: payment.php");
        exit;
    }
    if (!is_expiry_valid_after_current($expiry)) {
        $_SESSION['checkout_error'] = "❌ Invalid expiry date.";
        header("Location: payment.php");
        exit;
    }
}

if ($payment_method === 'ewallet') {
    if (empty($ewallet_type) || empty($ewallet_id)) {
        $_SESSION['checkout_error'] = "❌ Missing eWallet type or ID.";
        header("Location: payment.php");
        exit;
    }
}

// ✅ STEP 1: Get user details
$stmt_user = $conn->prepare("SELECT name, email, phone FROM users WHERE id = ?");
if ($stmt_user === false) {
    die("Prepare failed (user): " . htmlspecialchars($conn->error));
}
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$stmt_user->bind_result($db_name, $db_email, $db_phone);
$stmt_user->fetch();
$stmt_user->close();

// ✅ STEP 2: Handle delivery
if ($delivery === "pickup") {
    $final_name   = $db_name;
    $final_address = "Pickup in Store";
    $final_phone  = $db_phone;
    $delivery_status = "Pickup";
} else {
    $final_name   = $full_name;
    $final_address = trim($address . ' ' . $address2 . ', ' . $postcode . ' ' . $city . ', ' . $state);
    $final_phone  = $phone;
    $delivery_status = "Shipping";
}

// ✅ STEP 3: Create new order
$stmt_order = $conn->prepare("
    INSERT INTO orders 
    (customer_name, email, order_date, status, payment_status, shipment_status, delivery_status, total_amount) 
    VALUES (?, ?, NOW(), 'Processing', 'Paid', 'Pending', ?, ?)
");
if ($stmt_order === false) {
    die("Prepare failed (order): " . htmlspecialchars($conn->error));
}
$stmt_order->bind_param("sssd", $final_name, $db_email, $delivery_status, $amount);
$stmt_order->execute();
$order_id = $conn->insert_id;
$stmt_order->close();

// ✅ STEP 4: Insert order items
$sql_items = "
    SELECT ci.product_id, ci.quantity, p.price 
    FROM cart_items ci
    JOIN products p ON ci.product_id = p.id
    WHERE ci.cart_id = ?
";
$stmt_items = $conn->prepare($sql_items);
if ($stmt_items === false) {
    die("Prepare failed (order items): " . htmlspecialchars($conn->error));
}
$stmt_items->bind_param("i", $cart_id);
$stmt_items->execute();
$result_items = $stmt_items->get_result();

while ($row = $result_items->fetch_assoc()) {
    $stmt_insert_item = $conn->prepare("
        INSERT INTO order_items (order_id, product_id, quantity, price) 
        VALUES (?, ?, ?, ?)
    ");
    if ($stmt_insert_item === false) {
        die("Prepare failed (insert item): " . htmlspecialchars($conn->error));
    }
    $stmt_insert_item->bind_param("iiid", $order_id, $row['product_id'], $row['quantity'], $row['price']);
    $stmt_insert_item->execute();
    $stmt_insert_item->close();
}
$stmt_items->close();

// ✅ STEP 5: Insert payment record
$sql_payment = "
    INSERT INTO payments (order_id, user_id, amount, payment_method, payment_status, payment_date) 
    VALUES (?, ?, ?, ?, 'Pending', NOW())
";
$stmt_payment = $conn->prepare($sql_payment);
if ($stmt_payment === false) {
    die("Prepare failed (payment): " . htmlspecialchars($conn->error));
}
$stmt_payment->bind_param("iids", $order_id, $user_id, $amount, $payment_method);
$stmt_payment->execute();
$stmt_payment->close();

// ✅ STEP 6: Log payment activity
$activity_type = "Payment"; // Type of activity
$activity_details = "Payment completed using " . ucfirst($payment_method) . " (Order ID: $order_id)";

$log = $conn->prepare("INSERT INTO customer_activity (user_id, activity_type, activity_details, activity_time) VALUES (?, ?, ?, NOW())");
if ($log === false) {
    die("Prepare failed (activity log): " . htmlspecialchars($conn->error));
}
$log->bind_param("iss", $user_id, $activity_type, $activity_details);
$log->execute();
$log->close();


// ✅ STEP 7: Close the cart
$update_cart = $conn->prepare("UPDATE cart SET status = 'closed' WHERE id = ?");
if ($update_cart === false) {
    die("Prepare failed (update cart): " . htmlspecialchars($conn->error));
}
$update_cart->bind_param("i", $cart_id);
$update_cart->execute();
$update_cart->close();

// ✅ STEP 8: Redirect
if ($payment_method === 'ewallet') {
    header("Location: ewallet_qr.php?order_id=$order_id&amount=$amount&wallet=$ewallet_type");
    exit;
} else {
    header("Location: payment_success.php?order_id=$order_id");
    exit;
}
?>
