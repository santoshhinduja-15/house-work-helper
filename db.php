<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "house_help";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>