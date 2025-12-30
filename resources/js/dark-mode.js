/**
 * Dark Mode Toggle
 * Handles switching between light and dark mode
 */

const themeToggle = document.getElementById('theme-toggle');
const sunIcon = document.getElementById('theme-toggle-sun-icon');
const moonIcon = document.getElementById('theme-toggle-moon-icon');
const htmlElement = document.getElementById('html-element') || document.documentElement;

// Toggle dark mode
function toggleDarkMode() {
    if (htmlElement.classList.contains('dark')) {
        // Switch to light mode
        htmlElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
        updateIcons();
    } else {
        // Switch to dark mode
        htmlElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
        updateIcons();
    }
}

// Update icons visibility
function updateIcons() {
    if (htmlElement.classList.contains('dark')) {
        sunIcon.classList.remove('hidden');
        moonIcon.classList.add('hidden');
    } else {
        sunIcon.classList.add('hidden');
        moonIcon.classList.remove('hidden');
    }
}

// Add click event listener
if (themeToggle) {
    themeToggle.addEventListener('click', toggleDarkMode);
    // Initialize icons on page load
    updateIcons();
}
