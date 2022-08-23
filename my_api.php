<?php
    header("Access-Control-Allow-Origin: *");
    // Connect to database
    $mysqli = new mysqli("localhost","root"," ","db_2066031");
    if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }

    include('data_import.php');
    // Execute SQL query
    $sql = "SELECT * FROM weather ORDER BY weather_when DESC limit 1";

    $result = $mysqli -> query($sql);

    // Get data, convert to JSON and print
    $row = $result -> fetch_assoc();
    echo json_encode($row);
    
    // Free result set and close connection
    $result -> free_result();
    $mysqli -> close();
?>