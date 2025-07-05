// scroll-preserve.js
// ------------------
// Saves and restores vertical scroll position when a favorite button is clicked

document.addEventListener('DOMContentLoaded', () => {

  // === Save scroll position before triggering page reload ===
  document.querySelectorAll('.fav-toggle-btn').forEach((btn) => {
    btn.addEventListener('click', () => {
      localStorage.setItem('scrollY', window.scrollY.toString());
    });
  });

  // === Restore scroll position after page reload ===
  const savedScrollY = localStorage.getItem('scrollY');

  if (savedScrollY !== null) {
    // Use requestAnimationFrame to ensure DOM is ready before scrolling
    window.requestAnimationFrame(() => {
      window.scrollTo(0, parseInt(savedScrollY, 10));
      localStorage.removeItem('scrollY'); // Clean up
    });
  }
});
