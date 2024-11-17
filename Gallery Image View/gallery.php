<?php
include 'db.php'; // Include your database connection file

// Get the current page or set default to page 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$images_per_page = 12;
$offset = ($page - 1) * $images_per_page;

// Get the selected category or set to 'all' by default
$category = isset($_GET['category']) ? $_GET['category'] : 'all';

// Build the SQL query based on the selected category
if ($category === 'all') {
    $sql = "SELECT id, image_path FROM gallery LIMIT $offset, $images_per_page";
} else {
    $sql = "SELECT id, image_path FROM gallery WHERE category = ? LIMIT $offset, $images_per_page";
}

// Prepare and execute the statement
$stmt = $conn->prepare($sql);
if ($category !== 'all') {
    $stmt->bind_param("s", $category);
}
$stmt->execute();
$result = $stmt->get_result();

// Get the total number of images for pagination
$total_images_query = $category === 'all' ? "SELECT COUNT(*) FROM gallery" : "SELECT COUNT(*) FROM gallery WHERE category = ?";
$total_images_stmt = $conn->prepare($total_images_query);
if ($category !== 'all') {
    $total_images_stmt->bind_param("s", $category);
}
$total_images_stmt->execute();
$total_images_result = $total_images_stmt->get_result();
$total_images = $total_images_result->fetch_row()[0];

// Calculate total pages
$total_pages = ceil($total_images / $images_per_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .navbar {
            background-color: #006d5b;
            padding: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        .navbar ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }

        .navbar li {
            margin: 0 15px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
        }

        .navbar a.active {
            background-color: #009882;
        }
        h1 {
            background-color: #005f50;
            box-shadow: inset 0 0 10px rgba(116, 95, 80, 1);
        }

        /* Home Button Styles */
        .home-button {
            position: fixed;
            bottom: 80px;
            left: 360px;
            z-index: 1000; /* Ensure it's above other elements */
        }

        .home-button a {
            background-color: #006d5b;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .home-button a:hover {
            background-color: #009882;
        }
    </style>
</head>
<body>



<div class="gallery-container">
    <h1>Image Gallery</h1>
    <!-- Navigation Bar -->
<nav class="navbar">
    <ul>
        <li><a href="?category=all&page=1" class="<?php if ($category == 'all') echo 'active'; ?>">All</a></li>
        <li><a href="?category=landscape&page=1" class="<?php if ($category == 'landscape') echo 'active'; ?>">Landscape</a></li>
        <li><a href="?category=wildlife&page=1" class="<?php if ($category == 'wildlife') echo 'active'; ?>">Wildlife</a></li>
        <li><a href="?category=wedding&page=1" class="<?php if ($category == 'wedding') echo 'active'; ?>">Wedding</a></li>
    </ul>
</nav>
    <div class="gallery-grid">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <?php 
                    // Debugging output for image path
                    echo "<!-- Image Path: " . $row['image_path'] . " -->";
                    
                    // Check if image file exists
                    $image_path = '../admin/IMAGE MAINTAIN/' . $row['image_path'];
                    if (!file_exists($image_path)) {
                        echo "<p>Image not found: $image_path</p>";
                        continue;
                    }
                ?>
                <div class="gallery-item">
                    <img src="<?php echo $image_path; ?>" alt="Image">
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No images available.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Pagination -->
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?category=<?php echo $category; ?>&page=<?php echo $page - 1; ?>">Previous</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?category=<?php echo $category; ?>&page=<?php echo $i; ?>" class="<?php if($page == $i) echo 'active'; ?>">
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <a href="?category=<?php echo $category; ?>&page=<?php echo $page + 1; ?>">Next</a>
    <?php endif; ?>
</div>
<!-- Home Button -->
<div class="home-button">
    <a href="../index.html">Home</a> 
</div>
</body>
</html>
