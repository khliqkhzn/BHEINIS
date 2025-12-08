<?php
include 'db.php';
session_start();

if (isset($_POST['cart_item_id']) && isset($_POST['size'])) {
    $id = intval($_POST['cart_item_id']);
    $size = $_POST['size'];

    $sql = "UPDATE cart_items SET size = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $size, $id);
    $stmt->execute();
}

header("Location: cart.php");
exit;
