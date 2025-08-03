<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Hash the password for security
    $role = 'student';  // Student role

    $query = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $password, $role);
    $stmt->execute();

    echo "<p class='success-msg'>Student added successfully!</p>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
        }

        h1, h2 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        label {
            margin: 10px 0 5px;
            color: #555;
        }

        input[type="text"], input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            font-size: 16px;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        button:hover {
            background-color: #218838;
        }

        .student-list {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .student-item {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        .student-item:last-child {
            border-bottom: none;
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

        .success-msg {
            color: #28a745;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Manage Students</h1>
    
    <form method="POST" action="manage_students.php">
        <label for="username">Student Username: </label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Add Student</button>
    </form>

    <hr>

    <h2>Student List</h2>

    <div class="student-list">
        <?php
        $query = "SELECT * FROM users WHERE role = 'student'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($student = $result->fetch_assoc()) {
                echo "<div class='student-item'>";
                echo "ID: " . $student['id'] . " - Username: " . $student['username'];
                echo "</div>";
            }
        } else {
            echo "<p>No students found.</p>";
        }
        ?>
    </div>

    <a href="dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>
