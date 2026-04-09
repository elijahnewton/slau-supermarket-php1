<?php
// File: db_config.php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "supermarket_db2";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>