<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'sadali';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $image = $_FILES["image"];
        $imagePath = 'uploads/' . basename($image["name"]);

        if (move_uploaded_file($image["tmp_name"], $imagePath)) {
            $stmt = $conn->prepare("SELECT image_path FROM gallery WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->bind_result($oldImagePath);
            $stmt->fetch();
            $stmt->close();

            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $stmt = $conn->prepare("UPDATE gallery SET image_path = ? WHERE id = ?");
            $stmt->bind_param("si", $imagePath, $id);

            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "error";
            }

            $stmt->close();
        } else {
            echo "error";
        }
    }
}
$conn->close();
?>
