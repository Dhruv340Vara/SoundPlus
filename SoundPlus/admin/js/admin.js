// Admin Panel JavaScript

document.addEventListener("DOMContentLoaded", function () {

    // Handle success and error alerts
    const alertSuccess = document.querySelector(".alert.success");
    const alertError = document.querySelector(".alert.error");

    if (alertSuccess) {
        setTimeout(function () {
            alertSuccess.style.display = "none";
        }, 5000); // Hide alert after 5 seconds
    }

    if (alertError) {
        setTimeout(function () {
            alertError.style.display = "none";
        }, 5000); // Hide alert after 5 seconds
    }

    // Form Validation: Add Song Form
    const addSongForm = document.getElementById("addSongForm");
    if (addSongForm) {
        addSongForm.addEventListener("submit", function (e) {
            const title = document.getElementById("title").value;
            const artist = document.getElementById("artist").value;
            const genre = document.getElementById("genre").value;
            const file = document.getElementById("file").value;

            if (!title || !artist || !genre || !file) {
                e.preventDefault();
                alert("All fields are required!");
            }
        });
    }

    // Confirm before deleting
    const deleteButtons = document.querySelectorAll(".delete-btn");
    deleteButtons.forEach(function (button) {
        button.addEventListener("click", function (e) {
            if (!confirm("Are you sure you want to delete this item?")) {
                e.preventDefault();
            }
        });
    });

});
