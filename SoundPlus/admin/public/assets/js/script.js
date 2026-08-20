// Select DOM elements for theme toggle
const themeToggle = document.getElementById('theme-toggle');
const sunIcon = document.getElementById('sun-icon');
const moonIcon = document.getElementById('moon-icon');
const body = document.body;
const header = document.querySelector('header'); // Update to select <header> tag
const sidebar = document.getElementById('sidebar');

// Function to apply the theme
function applyTheme(isDarkTheme) {
  if (isDarkTheme) {
    body.classList.add('dark-theme');
    header.classList.add('dark-theme');
    sidebar.classList.add('dark-theme');
    sunIcon.style.display = 'block';
    moonIcon.style.display = 'none';
  } else {
    body.classList.remove('dark-theme');
    header.classList.remove('dark-theme');
    sidebar.classList.remove('dark-theme');
    sunIcon.style.display = 'none';
    moonIcon.style.display = 'block';
  }
}

// On page load, check the saved theme in localStorage
const savedTheme = localStorage.getItem('theme');
if (savedTheme) {
  applyTheme(savedTheme === 'dark');
}

// Add click event listener for theme toggle
themeToggle.addEventListener('click', () => {
  // Determine the current theme
  const isDarkTheme = body.classList.contains('dark-theme');

  // Toggle the theme
  applyTheme(!isDarkTheme);

  // Save the updated theme in localStorage
  localStorage.setItem('theme', !isDarkTheme ? 'dark' : 'light');
});

document.addEventListener("DOMContentLoaded", function () {
  const sidebarToggle = document.getElementById('sidebar-toggle');
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebar-overlay');

  // Open Sidebar
  sidebarToggle.addEventListener('click', () => {
      sidebar.classList.add('active');
      overlay.classList.add('active');
  });

  // Close Sidebar when Clicking Outside
  overlay.addEventListener('click', () => {
      sidebar.classList.remove('active');
      overlay.classList.remove('active');
  });
});

 //music language select
 document.getElementById('music-languages-button').addEventListener('click', function () {
  const dropdown = document.getElementById('music-languages-dropdown');
  dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
 });

 document.getElementById('update-button').addEventListener('click', function () {
  const checkboxes = document.querySelectorAll('#music-languages-dropdown input[type="checkbox"]');
  const selectedLanguages = [];
   checkboxes.forEach(checkbox => {
      if (checkbox.checked) {
          selectedLanguages.push(checkbox.value);
      }
  });
  console.log('Selected Languages:', selectedLanguages);
 });



function toggleMenu() {
  const dropdownMenu = document.getElementById("dropdownMenu");
  dropdownMenu.style.display =
    dropdownMenu.style.display === "block" ? "none" : "block";
}



// Optional: Close dropdown if clicked outside
window.addEventListener("click", function (e) {
  const dropdownMenu = document.getElementById("dropdownMenu");
  const profileIcon = document.querySelector(".profile-icon");

  if (!profileIcon.contains(e.target) && !dropdownMenu.contains(e.target)) {
    dropdownMenu.style.display = "none";
  }
});


