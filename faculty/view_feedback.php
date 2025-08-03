<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'faculty') {
    header('Location: ../login.php');
    exit;
}

$faculty_id = $_SESSION['user_id'];
$query = "SELECT * FROM evaluations WHERE faculty_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<h1>Faculty Feedback</h1>";
while ($feedback = $result->fetch_assoc()) {
    echo "Rating: " . $feedback['rating'] . "<br>";
    echo "Comments: " . $feedback['comments'] . "<br><hr>";
}
?>
<a href="../logout.php">Logout</a>
