<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $faculty_id = $_POST['faculty_id'];
    $rating = $_POST['rating'];
    $comments = $_POST['comments'];
    $student_id = $_SESSION['user_id'];

    $query = "INSERT INTO evaluations (student_id, faculty_id, rating, comments) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiis", $student_id, $faculty_id, $rating, $comments);
    $stmt->execute();
    
    echo "<p class='success-msg'>Evaluation submitted successfully!</p>";
}

$query = "SELECT * FROM faculty";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Evaluation</title>
    <style>
        /* Basic CSS Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
            color: #555;
        }

        select, input[type="number"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        textarea {
            height: 100px;
            resize: none;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            margin-bottom:5px
        }

        button:hover {
            background-color: #45a049;
        }

        .success-msg {
            color: green;
            font-size: 16px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Evaluate Faculty</h2>

        <form method="POST" action="evaluate.php">
            <label for="faculty">Select Faculty:</label>
            <select name="faculty_id" required>
                <?php while ($faculty = $result->fetch_assoc()) { ?>
                    <option value="<?= $faculty['id'] ?>"><?= $faculty['name'] ?></option>
                <?php } ?>
            </select>

            <label for="rating">Rating (1-10):</label>
            <input type="number" name="rating" min="1" max="10" required>

            <label for="comments">Comments:</label>
            <textarea name="comments" placeholder="Enter your comments here"></textarea>

            <button type="submit">Submit Evaluation</button>
            <a href="dashboard.php">Back to Dashboard</a>
        </form>
    </div>

</body>
</html>
