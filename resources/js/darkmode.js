/**
 * Dark Mode Toggle Script
 * Handles theme switching and persistence
 */

// Function to get current theme from localStorage or system preference
function getTheme() {
    // Check if user has saved preference
    if (localStorage.theme === 'dark') {
        return 'dark';
    }
    if (localStorage.theme === 'light') {
        return 'light';
    }
    
    // If no saved preference, check system preference
    if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        return 'dark';
    }
    
    // Default to light mode
    return 'light';
}

// Function to apply theme to document
function applyTheme(theme) {
    if (theme === 'dark') {
        // Add 'dark' class to <html> element
        document.documentElement.classList.add('dark');
    } else {
        // Remove 'dark' class from <html> element
        document.documentElement.classList.remove('dark');
    }
}

// Function to toggle between light and dark
function toggleTheme() {
    const currentTheme = getTheme();
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    // Save to localStorage
    localStorage.theme = newTheme;
    
    // Apply to document
    applyTheme(newTheme);
    
    // Update toggle button icon
    updateToggleButton(newTheme);
}

// Function to update toggle button appearance
function updateToggleButton(theme) {
    const sunIcon = document.getElementById('theme-toggle-sun-icon');
    const moonIcon = document.getElementById('theme-toggle-moon-icon');
    
    if (sunIcon && moonIcon) {
        if (theme === 'dark') {
            // Show sun icon (to switch to light)
            sunIcon.classList.remove('hidden');
            moonIcon.classList.add('hidden');
        } else {
            // Show moon icon (to switch to dark)
            sunIcon.classList.add('hidden');
            moonIcon.classList.remove('hidden');
        }
    }
}

// Initialize theme on page load
document.addEventListener('DOMContentLoaded', function() {
    const theme = getTheme();
    applyTheme(theme);
    updateToggleButton(theme);
    
    // Add click event to toggle button
    const toggleButton = document.getElementById('theme-toggle');
    if (toggleButton) {
        toggleButton.addEventListener('click', toggleTheme);
    }
});

// Apply theme immediately (before DOM loads) to prevent flash
const theme = getTheme();
applyTheme(theme);