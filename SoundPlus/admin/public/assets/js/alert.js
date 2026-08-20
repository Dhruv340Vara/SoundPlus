


function showCustomAlert() {
    const alertBox = document.getElementById("custom-alert");
    alertBox.style.display = "flex";
}

function redirectToForgotPassword() {
    const alertBox = document.getElementById("custom-alert");
    alertBox.style.display = "none";
    window.location.href = "forgot_password.php"; // Replace with the actual forgot password page URL.
}



// Function to display the alert
function showAlert(type, message) {
    const alertContainer = document.getElementById('alert-container');
    
    // Create the alert box element
    const alertBox = document.createElement('div');
    alertBox.classList.add('alert-box', type, 'show-alert');
    alertBox.innerHTML = `
        <span>${message}</span>
        <button class="close-btn">&times;</button>
    `;
    
    // Append the alert box to the container
    alertContainer.appendChild(alertBox);
    
    // Close the alert box when clicking the close button
    alertBox.querySelector('.close-btn').onclick = function() {
        alertBox.classList.remove('show-alert');
        setTimeout(() => alertBox.remove(), 500); // Remove after fade-out
    }
    
    // Auto-remove the alert after 5 seconds
    setTimeout(() => {
        alertBox.classList.remove('show-alert');
        setTimeout(() => alertBox.remove(), 500);
    }, 5000);
}

// Example usage: Show a success alert
showAlert('success', 'Login successful! Redirecting...');

// Example usage: Show an error alert
showAlert('error', 'Invalid username or password.');

