<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sadali";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the booking ID from the query parameter
$id = intval($_GET['id']);

// Update query to set booking status as accepted
$sql = "UPDATE booking SET status='Accepted' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Booking accepted successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

// Close connection
$conn->close();
?>
