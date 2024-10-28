<?php
$host = 'localhost';
$db   = 'faculty_evaluation';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db,3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
