<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'sadali';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM gallery");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel="stylesheet" href="style.css"> <!-- Your CSS file -->
    <script src="script.js"></script> <!-- Your JavaScript file -->
    <style>
        .logout-btn {
            width: 100%;
            padding: 10px;
            background-color: #f44336; /* Red color */
            color: white;
            border: none;
            cursor: pointer;
            margin-top: auto; /* Push to bottom */
        }

        .logout-btn:hover {
            background-color: #d32f2f; /* Darker red on hover */
        }

    </style>
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <h2>Admin Dashboard</h2>
            <ul>
                <li><a href="../HOME/home.html">Home</a></li>
                <li><a href="gallery.PHP">Maintain Gallery</a></li>
                <li><a href="../ADD ADMIN LOGING MAINTAIN/add_admin.php">Add Admins</a></li>
                <li><a href="../BOOKING ACCEPT REJECT/display_bookings.php">Bookings</a></li>
                <!-- Add other links as needed -->
            </ul>
            <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button> <!-- Logout button -->
        </div>
        <div class="main-content">
            <h3>Image Upload</h3>
            <div class="form-container">
                <form id="galleryForm" action="uploadImage.php" method="POST" enctype="multipart/form-data">
                    <label for="category">Select Category:</label>
                    <select name="category" id="category" required>
                        <option value="">- Select Category -</option>
                        <option value="wildlife">Wildlife</option>
                        <option value="landscape">Landscape</option>
                        <option value="wedding">Wedding</option>
                    </select>
                    <input type="file" name="image" required>
                    <button type="submit" class="upload-btn">Upload</button>
                </form>
            </div>

            <div class="gallery-list">
                <h3>Current Images</h3>
                <table>
                    <tr>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Operation</th>
                    </tr>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><img src="<?php echo $row["image_path"]; ?>" width="50"></td>
                        <td><?php echo $row["category"]; ?></td>
                        <td>
                            <input type="file" class="choose-image-btn" onchange="editImage(this, <?php echo $row["id"]; ?>)">
                            <button class="update" onclick="editImage(this, <?php echo $row["id"]; ?>)">Update</button>
                            <button class="delete" onclick="deleteImage(this, <?php echo $row["id"]; ?>)">Delete</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
    </div>
    
</body>
</html>

<?php $conn->close(); ?>
