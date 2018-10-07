<?php
require('../database_login_info.php');
// Create connection to MySQL database
$conn = mysqli_connect($servername, $username, $password, $database);

// Throw error if connection failed
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>