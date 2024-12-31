<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "usser";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data


// Prepare SQL query
$stmt = $conn->prepare("INSERT INTO users (email, password, face_data) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $email, $password, $face_data);

// Execute query and check for success


$stmt->close();
$conn->close();
?>
