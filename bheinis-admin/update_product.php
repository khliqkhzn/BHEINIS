<?php include("session.php"); include("config.php");

$id = $_GET['id'];
$conn->query("UPDATE FROM products WHERE id=$id");
header("Location: products_women.php");
?>
