// const container = document.getElementById("container");
// const signUpBtn = document.getElementById("signUp");
// const signInBtn = document.getElementById("signIn");

// // Button click events (desktop overlay)
// signUpBtn.addEventListener("click", () => {
//   container.classList.add("right-panel-active");
//   window.location.hash = "#signup";
// });

// signInBtn.addEventListener("click", () => {
//   container.classList.remove("right-panel-active");
//   window.location.hash = "#login";
// });

// // Mobile switch links
// document.getElementById("mobileToLogin").addEventListener("click", () => {
//   container.classList.remove("right-panel-active");
// });

// document.getElementById("mobileToSignup").addEventListener("click", () => {
//   container.classList.add("right-panel-active");
// });

// // Show correct section on page load based on URL hash
// window.addEventListener("load", () => {
//   if (window.location.hash === "#signup") {
//     container.classList.add("right-panel-active");
//   } else {
//     container.classList.remove("right-panel-active"); // default is login
//   }
// });

// // Optional: Handle hash changes dynamically
// window.addEventListener("hashchange", () => {
//   if (window.location.hash === "#signup") {
//     container.classList.add("right-panel-active");
//   } else {
//     container.classList.remove("right-panel-active");
//   }
// });

// Get DOM elements
const container = document.getElementById('container');
const loginForm = document.querySelector('.sign-in-container');
const signupForm = document.querySelector('.sign-up-container');
const mobileToLogin = document.getElementById('mobileToLogin');
const mobileToSignup = document.getElementById('mobileToSignup');

// Toggle for mobile views
function toggleForms(targetForm) {
  if (window.innerWidth <= 768) { // Mobile view
    loginForm.classList.remove('active');
    signupForm.classList.remove('active');
    targetForm.classList.add('active');
  }
}

// Event listeners
mobileToSignup.addEventListener('click', (e) => {
  e.preventDefault();
  toggleForms(signupForm);
});

mobileToLogin.addEventListener('click', (e) => {
  e.preventDefault();
  toggleForms(loginForm);
});

// Reset for desktop view
window.addEventListener('resize', () => {
  if (window.innerWidth > 768) { // Desktop view
    loginForm.classList.add('active');
    signupForm.classList.add('active');
  }
});

// Initialize the correct display
if (window.innerWidth > 768) { // Desktop view
  loginForm.classList.add('active');
  signupForm.classList.add('active');
} else { // Mobile view
  loginForm.classList.add('active'); // Show login by default
}