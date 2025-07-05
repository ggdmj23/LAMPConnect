// toggle-password.js
// ------------------
// Toggles password visibility and icon state for all password fields
// with a .toggle-password button next to them.

document.addEventListener("DOMContentLoaded", () => {
  // Loop through all toggle buttons
  document.querySelectorAll(".toggle-password").forEach((toggleBtn) => {
    const passwordInput = toggleBtn.previousElementSibling; // assumes input is right before the button
    const icon = toggleBtn.querySelector("i");

    // Toggle password visibility on click
    toggleBtn.addEventListener("click", () => {
      const isHidden = passwordInput.type === "password";

      // Change input type
      passwordInput.type = isHidden ? "text" : "password";

      // Toggle eye icon (Font Awesome)
      icon.classList.toggle("fa-eye");
      icon.classList.toggle("fa-eye-slash");

      // Optional: Update button label for accessibility
      toggleBtn.setAttribute(
        "aria-label",
        isHidden ? "Hide password" : "Show password"
      );
    });
  });
});
