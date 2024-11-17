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
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $image = $_FILES["image"];
        $category = $_POST["category"]; // Get the selected category
        $imagePath = 'uploads/' . basename($image["name"]);

        if (move_uploaded_file($image["tmp_name"], $imagePath)) {
            // Insert both image path and category into the database
            $stmt = $conn->prepare("INSERT INTO gallery (image_path, category) VALUES (?, ?)");
            $stmt->bind_param("ss", $imagePath, $category);

            if ($stmt->execute()) {
                header("Location: gallery.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error uploading file.";
        }
    }
}

$conn->close();
?>
