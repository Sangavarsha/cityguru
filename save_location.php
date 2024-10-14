<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cityguru";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the user's ID from the session
$user_id = $_SESSION['user_id'];

// Retrieve latitude and longitude from POST request
if (isset($_POST['latitude']) && isset($_POST['longitude'])) {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO location (id, latitude, longitude) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE latitude=?, longitude=?");
    $stmt->bind_param("idddi", $user_id, $latitude, $longitude, $latitude, $longitude);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Location updated successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Location data not provided.";
}

// Close the database connection
$conn->close();
