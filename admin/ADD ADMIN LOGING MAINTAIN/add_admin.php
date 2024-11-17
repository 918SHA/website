<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
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
            <li><a href="add_admin.php">Add Admins</a></li>
            <li><a href="../BOOKING ACCEPT REJECT/display_bookings.php">Bookings</a></li>
        </ul>
        <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button> <!-- Logout button -->
    </div>
    <div class="main-content">
        <h3>Add Admins</h3>
        <div class="form-container">
            <form id="adminForm" method="POST" action="add_admin.php">
                <input type="hidden" id="id" name="id">
                <label for="username">User Name:</label>
                <input type="text" id="username" name="username" required><br>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>
                <div class="btn">
                    <button class="add-btn" type="submit" name="add">Add</button>
                    <button class="add-btn" type="reset">Reset</button>
                </div>
            </form>
        </div>
        <div class="admin-list">
             <table>
                <tr>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Operations</th>
                </tr>
                <?php
                include 'db.php';

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    if (isset($_POST['id']) && !empty($_POST['id'])) {
                        // Update existing admin
                        $id = $_POST['id'];
                        $sql = "UPDATE users SET username='$username', email='$email', password='$password' WHERE id='$id'";
                    } else {
                        // Insert new admin
                        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
                    }

                    if ($conn->query($sql) === TRUE) {
                        header("Location: add_admin.php");
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }

                $result = $conn->query("SELECT * FROM users");
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['password'] . "</td>";
                        echo "<td>
                                <button class='update' onclick='editAdmin(" . $row["id"] . ")'>Update</button>
                                <button class='delete' onclick='deleteAdmin(this, " . $row["id"] . ")'>Delete</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No admins found</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>
