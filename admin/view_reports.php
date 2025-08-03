<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .evaluation-item {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .evaluation-item p {
            margin: 5px 0;
        }

        hr {
            border: 1px solid #ddd;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            text-decoration: none;
            text-align: center;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Evaluation Reports</h1>

    <?php
    $query = "SELECT evaluations.*, users.username AS student_name, faculty.name AS faculty_name FROM evaluations
              JOIN users ON evaluations.student_id = users.id
              JOIN faculty ON evaluations.faculty_id = faculty.id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($evaluation = $result->fetch_assoc()) {
            echo "<div class='evaluation-item'>";
            echo "<p><strong>Student:</strong> " . $evaluation['student_name'] . "</p>";
            echo "<p><strong>Faculty:</strong> " . $evaluation['faculty_name'] . "</p>";
            echo "<p><strong>Rating:</strong> " . $evaluation['rating'] . "</p>";
            echo "<p><strong>Comments:</strong> " . $evaluation['comments'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No evaluations found.</p>";
    }
    ?>

    <a href="dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>
