const container = document.getElementById("container");
const signUpBtn = document.getElementById("signUp");
const signInBtn = document.getElementById("signIn");

// Button click events (desktop overlay)
signUpBtn.addEventListener("click", () => {
  container.classList.add("right-panel-active");
  window.location.hash = "#signup";
});

signInBtn.addEventListener("click", () => {
  container.classList.remove("right-panel-active");
  window.location.hash = "#login";
});

// Mobile switch links
document.getElementById("mobileToLogin").addEventListener("click", () => {
  container.classList.remove("right-panel-active");
});

document.getElementById("mobileToSignup").addEventListener("click", () => {
  container.classList.add("right-panel-active");
});

// Show correct section on page load based on URL hash
window.addEventListener("load", () => {
  if (window.location.hash === "#signup") {
    container.classList.add("right-panel-active");
  } else {
    container.classList.remove("right-panel-active"); // default is login
  }
});

// Optional: Handle hash changes dynamically
window.addEventListener("hashchange", () => {
  if (window.location.hash === "#signup") {
    container.classList.add("right-panel-active");
  } else {
    container.classList.remove("right-panel-active");
  }
});
