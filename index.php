<?php
    include "config.php";
    //SQL query to select all tasks
    $sql = "SELECT id, task_name, description, created_at FROM tasks ORDER BY created_at DESC";
    //store selected tasks in $results
    $results = mysqli_query($conn, $sql);
    
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
