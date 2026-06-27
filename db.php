<?php
// 1. Database Configuration Details
$host = "localhost";
$username = "root";       // Default MySQL username
$password = "";           // Put your MySQL Workbench root password inside the quotes if you have one
$dbname = "MallManagementDB";

// 2. Establish Connection to MySQL
$conn = new mysqli($host, $username, $password, $dbname);

// 3. Check Connection for Errors
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>