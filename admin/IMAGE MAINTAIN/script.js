function editImage(input, id) {
    // Logic for editing an image
    // You can implement this based on your specific needs
}

function deleteImage(button, id) {
    if (confirm("Are you sure you want to delete this image?")) {
        // AJAX call to deleteImage.php with the image ID
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "deleteImage.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            if (xhr.status === 200) {
                alert("Image deleted successfully.");
                location.reload(); // Reload the page to update the gallery
            } else {
                alert("Error deleting image.");
            }
        };
        xhr.send("id=" + id);
    }
}
