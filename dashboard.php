<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle new task submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task'])) {
    $task = $_POST['task'];
    $stmt = $pdo->prepare("INSERT INTO tasks (user_id, task, status) VALUES (?, ?, 'pending')");
    $stmt->execute([$user_id, $task]);
}

// Fetch all tasks for the logged-in user
$tasks = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY id DESC");
$tasks->execute([$user_id]);
$tasks = $tasks->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        h3 {
            margin-top: 20px;
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        a {
            color: #007bff;
            text-decoration: none;
            margin-left: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        .completed {
            text-decoration: line-through;
            color: gray;
        }

        .logout {
            margin-top: 20px;
            display: block;
            color: #007bff;
            text-decoration: none;
        }

        .logout:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Task Management Dashboard</h2>

        <!-- Form to Add New Task -->
        <form method="POST">
            <div class="form-group">
                <input type="text" name="task" placeholder="New Task" required>
            </div>
            <button type="submit">Add Task</button>
        </form>

        <!-- Display User Tasks -->
        <h3>Your Tasks</h3>
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li class="<?php echo $task['status'] === 'done' ? 'completed' : ''; ?>">
                    <?php echo htmlspecialchars($task['task']); ?>
                    <div>
                        <a href="update_task.php?id=<?php echo $task['id']; ?>">Edit</a>
                        <?php if ($task['status'] !== 'done'): ?>
                            <a href="complete_task.php?id=<?php echo $task['id']; ?>">Complete</a>
                        <?php endif; ?>
                        <a href="delete_task.php?id=<?php echo $task['id']; ?>">Delete</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Logout -->
        <a class="logout" href="logout.php">Logout</a>
    </div>
</body>
</html>
