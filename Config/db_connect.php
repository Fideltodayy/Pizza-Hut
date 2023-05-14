<?php
    //MySQLi or PDO to connect to the database
    $conn = mysqli_connect("localhost:3307", "fidel", "fidel123456" ,"pizza-hut");

    //check if connection is made
    if (!$conn) {
        echo "Connection error: " . mysqli_connect_error();
    }
?>