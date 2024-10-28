<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $subject = $_POST['subject'];

    $query = "INSERT INTO faculty (name, subject) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $name, $subject);
    $stmt->execute();

    echo "<p class='success-msg'>Faculty member added successfully!</p>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Faculty</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        label {
            margin: 10px 0 5px;
            color: #555;
        }

        input[type="text"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .faculty-list {
            margin-top: 20px;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .faculty-item {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        .faculty-item:last-child {
            border-bottom: none;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            text-decoration: none;
            text-align: center;
        }

        a:hover {
            background-color: #218838;
        }

        .success-msg {
            color: #28a745;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Manage Faculty</h1>

    <form method="POST" action="manage_faculty.php">
        <label for="name">Faculty Name:</label>
        <input type="text" name="name" required>

        <label for="subject">Subject:</label>
        <input type="text" name="subject" required>

        <button type="submit">Add Faculty</button>
    </form>

    <hr>

    <h2>Faculty List</h2>

    <div class="faculty-list">
        <?php
        $query = "SELECT * FROM faculty";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($faculty = $result->fetch_assoc()) {
                echo "<div class='faculty-item'>";
                echo "ID: " . $faculty['id'] . " - Name: " . $faculty['name'] . " - Subject: " . $faculty['subject'];
                echo "</div>";
            }
        } else {
            echo "<p>No faculty members found.</p>";
        }
        ?>
    </div>

    <a href="dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>
