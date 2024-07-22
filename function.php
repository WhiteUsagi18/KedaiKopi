<?php
//db config
$dbHost = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "kedaikopi";

//connect to db
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>