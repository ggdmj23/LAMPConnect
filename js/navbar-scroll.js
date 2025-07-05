/**
 * navbar-scroll.js
 * ----------------
 * Dynamically adjusts the navigation bar styling on scroll
 * to enhance UX and visual clarity.
 *
 * - Reduces blur and background opacity on scroll to make nav semi-transparent.
 * - Resets to original style when at top of the page.
 */

window.addEventListener("scroll", function () {
  const nav = document.querySelector(".nav");

  // Guard clause: Ensure nav element exists
  if (!nav) return;

  // Toggle styles based on scroll position
  if (window.scrollY > 10) {
    // Slightly transparent nav with light blur when scrolling
    nav.style.background =
      "linear-gradient(to right, rgba(15, 32, 39, 0.5), rgba(44, 62, 80, 0.5))";
    nav.style.backdropFilter = "blur(2px)";
    nav.style.webkitBackdropFilter = "blur(2px)";
  } else {
    // Default background and strong blur at top
    nav.style.background =
      "linear-gradient(to right, rgba(15, 32, 39, 0.85), rgba(44, 62, 80, 0.85))";
    nav.style.backdropFilter = "blur(4px)";
    nav.style.webkitBackdropFilter = "blur(4px)";
  }
});
