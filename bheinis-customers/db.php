<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "bheinis";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
$servername = "localhost";  // Your database server
$username = "root";         // Your database username
$password = "";             // Your database password (empty if no password)
$dbname = "bheinis";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>