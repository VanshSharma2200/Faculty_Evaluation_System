<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header('Location: ../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        /* Basic CSS Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            width: 400px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            margin: 10px 0;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #45a049;
        }

        .logout-btn {
            background-color: #f44336;
        }

        .logout-btn:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>

    <div class="container">
        <?php
        echo "<h1>Welcome to the Student Dashboard!</h1>";
        ?>
        <a href="evaluate.php">Evaluate Faculty</a><br>
        <a href="../logout.php" class="logout-btn">Logout</a>
    </div>

</body>
</html>
