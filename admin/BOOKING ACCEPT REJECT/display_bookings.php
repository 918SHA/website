<?php
// Database connection
$servername = "localhost"; // Update with your server name
$username = "root";        // Update with your database username
$password = "";            // Update with your database password
$dbname = "sadali"; // Update with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch data
$sql = "SELECT * FROM booking";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking List</title>
    <link rel="stylesheet" href="style.css">
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
            <li><a href="../IMAGE MAINTAIN/gallery.PHP">Maintain Gallery</a></li>
            <li><a href="../ADD ADMIN LOGING MAINTAIN/add_admin.php">Add Admins</a></li>
            <li><a href="display_bookings.php">Bookings</a></li>
        </ul>
        <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button> <!-- Logout button -->
    </div>
    <div class="main-content">
    <h3>Booking List</h3>
    <div class="admin-list">
        <table>
        
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Event Type</th>
                    <th>Event Date</th>
                    <th>Location</th>
                    <th>Message</th>
                    <th>Created At</th>
                    <th>Operation</th>
                </tr>
            
                <?php
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["phone"] . "</td>";
                        echo "<td>" . $row["event_type"] . "</td>";
                        echo "<td>" . $row["event_date"] . "</td>";
                        echo "<td>" . $row["location"] . "</td>";
                        echo "<td>" . $row["message"] . "</td>";
                        echo "<td>" . $row["created_at"] . "</td>";
                        echo "<td>
                                <button class='update' onclick='editAdmin(" . $row["id"] . ")'>Accept</button>
                                <button class='delete' onclick='deleteAdmin(this, " . $row["id"] . ")'>Reject</button>
                               </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No bookings found</td></tr>";
                }
                ?>
        
        </table>
    </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
