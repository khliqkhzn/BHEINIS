<?php
session_start();
include '../db.php'; 

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id']) || !isset($_GET['action'])) {
    die("Invalid parameters.");
}

$cart_item_id = intval($_GET['id']);
$action = $_GET['action'];

$sql = "SELECT quantity FROM cart_items WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_item_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    die("Item not found.");
}

$row = $res->fetch_assoc();
$qty = $row['quantity'];

if ($action === 'increase') {
    $qty++;
} elseif ($action === 'decrease') {
    $qty--;
    if ($qty < 1) {
        $delete = $conn->prepare("DELETE FROM cart_items WHERE id = ?");
        $delete->bind_param("i", $cart_item_id);
        $delete->execute();
        header("Location: cart.php");
        exit;
    }
}

$update = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
$update->bind_param("ii", $qty, $cart_item_id);
$update->execute();

header("Location: cart.php");
exit;
?>
