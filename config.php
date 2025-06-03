<?php
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'dev_user');
    define('DB_PASSWORD', 'Benjamin4$');
    define('DB_NAME', 'task_db');


    //db connection
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    //CHECK CONNECTION
    if($conn === false){
        die("Error:". mysqli_connect_error());
    }
?>