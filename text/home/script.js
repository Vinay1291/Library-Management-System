// Add interactivity here if needed (e.g., dark mode toggle later)
console.log("Library Management Home Page Loaded");

// Toggle hamburger menu
const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('nav-menu');

hamburger.addEventListener('click', () => {
  navMenu.classList.toggle('active');
});

const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('nav-menu');

hamburger.addEventListener('click', () => {
  navMenu.classList.toggle('active');
  hamburger.classList.toggle('active'); // for animation
});

// Hamburger
const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('nav-menu');
hamburger.addEventListener('click', () => {
  navMenu.classList.toggle('active');
  hamburger.classList.toggle('active');
});

// Dark Mode
const toggle = document.getElementById('darkModeToggle');
const body = document.body;

toggle.addEventListener('change', () => {
  body.classList.toggle('dark-mode');
});
