<?php
$servername = "localhost";
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$dbname = "sadali";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO booking (name, email, phone, event_type, event_date, location, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $name, $gmail, $phone, $event_type, $event_date, $location, $message);

// Set parameters and check for missing values
$name = isset($_POST['Name']) ? $_POST['Name'] : '';
$gmail = isset($_POST['Gmail']) ? $_POST['Gmail'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$event_type = isset($_POST['cars']) ? $_POST['cars'] : '';
$event_date = isset($_POST['event_date']) ? $_POST['event_date'] : '';
$location = isset($_POST['location']) ? $_POST['location'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';

$response = [];
if ($stmt->execute()) {
    $response['status'] = 'success';
    $response['message'] = 'New record created successfully';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error: ' . $stmt->error;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
