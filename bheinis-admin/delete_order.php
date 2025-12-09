<?php
session_start();
include("session.php");
include("../db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

if (isset($_GET['id'])) {
    $order_id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();

    header("Location: orders.php?msg=deleted");
    exit;
} else {
    header("Location: orders.php");
    exit;
}
