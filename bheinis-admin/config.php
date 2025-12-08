<?php
$servername = "localhost";  // Your database server
$username = "bheinis_user";         // Your database username
$password = "amir@00Lutfi";             // Your database password (empty if no password)
$dbname = "bheinis";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
