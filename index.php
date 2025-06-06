<?php
    include 'config.php'; //include the config file
    //Handle form submission for adding task
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_task'])){
        $task_name = trim($_POST['task_name']);
        $description = trim($_POST['description']);

        //Basic form validation
        if(empty($task_name)){
            $message = "Task name cannot be empty"; //bug dem here
            header("Location: index.php?message=". urlencode($message));
            exit();
        }

        //Prepare insert Statement
        $sql ="INSERT INTO tasks (task_name, description) VALUES (?,?)";

        if($stmt = mysqli_prepare($conn, $sql)){
            //bind parameters to prepared stmt
            mysqli_stmt_bind_param($stmt, "ss", $param_task_name, $param_description);// bug dem here "ss"

            //set parameter
            $param_task_name = $task_name;
            $param_description = $description;

            //Attempt to execute prepared statement
            if(mysqli_stmt_execute($stmt)){
                $message = "Task added successfully";
                header("Location: index.php?message=". urlencode($message));
                exit();
            }else{
                $message = "Task could not be added". mysqli_error($conn);
                header("Location: index.php?message=". urlencode($message));
                exit();
            }

            //close statement
            mysqli_stmt_close($stmt);
        }else{
            $message = "Could not prepare statement". mysqli_error($conn);
            header("Location: index.php?message=". urlencode($message));
            exit();
        }
    };
    //SQL query to select all tasks
    $sql = "SELECT id, task_name, description, created_at FROM tasks ORDER BY created_at DESC";
    //store selected tasks in $results
    $results = mysqli_query($conn, $sql);// bug dem here
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .action-links a { margin-right: 10px; text-decoration: none; color: blue; }
        .action-links a:hover { text-decoration: underline; }
        .add-form { margin-bottom: 30px; padding: 15px; border: 1px solid #eee; background: #f9f9f9; }
        .add-form input[type="text"], .add-form textarea { width: 98%; padding: 8px; margin-bottom: 10px; }
        .add-form input[type="submit"] { padding: 10px 15px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        .message { background-color: #dff0d8; color: #3c763d; border: 1px solid #d6e9c6; padding: 10px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Task Manager</h1>

    <?php
    //Display message if any
    if(isset($_GET['message'])){
        echo '<div class = "message">'. htmlspecialchars($_GET['message']) . '</div>';
    }
    ?>

    <div class="add-form">
        <h2>Add New Task</h2>
        <form action="index.php" method="POST">
            <label for="task_name">Task Name:</label><br>
            <input type="text" id="task_name" name="task_name" required><br><br>
            <label for="description">Description (Optional):</label><br>
            <textarea id="description" name="description" rows="3"></textarea><br><br>
            <input type="submit" name="add_task" value="Add Task">
        </form>
    </div>

    <h2>Current Tasks</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Task Name</th>
                    <th>Description</th>
                    <th>created_at</th>
                    <th>Actions</th>
                </tr>
            </thead>
        <!-- </table> bug dem here-->
        <tbody>
            <?php
            if(mysqli_num_rows($results) > 0){
                //fetch output from rows in db
                while($row = mysqli_fetch_assoc($results)){
                    echo "<tr>";
                    echo "<td>". htmlspecialchars($row["id"]). "</td>";
                    echo "<td>". htmlspecialchars($row["task_name"]). "</td>";
                    echo "<td>". htmlspecialchars($row["description"]). "</td>";
                    echo "<td>". $row["created_at"]. "</td>";
                    echo '<td class="action_links">';
                    echo '<a href="edit.php?id=' . $row["id"] . '">Edit</a>';
                    //echo "<br>";
                    echo '<a href="delete.php?id=' . $row["id"] . '" onclick="return confirm(\'Are you sure you want to delete this task?\')">Delete</a>';
                    echo '</td>';
                    echo "</tr>";
                }
            }else{
                echo "<tr><td colspan= '5'>Task not found.</td></tr>";
            }
            ?>
        </tbody>
        </table>
</body>
</html>

<?php 
    //close connection
    mysqli_close($conn);
?>