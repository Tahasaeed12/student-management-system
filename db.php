<?php
$host = "127.0.0.1";
$user = "root";
$pass = ""; 
$db_name = "student_management";
$port = 3307; 

// Yeh woh $conn variable hai jo missing bata raha hai
$conn = new mysqli($host, $user, $pass, $db_name, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>