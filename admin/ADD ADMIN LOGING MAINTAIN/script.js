// Function to edit admin
function editAdmin(id) {
    fetch('edit_admin.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            if (data.id) {
                document.getElementById('id').value = data.id;
                document.getElementById('username').value = data.username;
                document.getElementById('email').value = data.email;
                document.getElementById('password').value = data.password;
            } else {
                alert("Admin not found");
            }
        })
        .catch(error => console.log("Error fetching admin data: ", error));
}

// Function to delete admin
function deleteAdmin(button, id) {
    if (confirm("Are you sure you want to delete this admin?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_admin.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                if (xhr.responseText.trim() === "success") {
                    var row = button.parentNode.parentNode;
                    row.parentNode.removeChild(row);  // Remove the row from the table
                } else {
                    alert("Error deleting admin.");
                }
            }
        };
        xhr.send("id=" + id);
    }
}
