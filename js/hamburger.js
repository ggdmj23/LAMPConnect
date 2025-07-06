// hamburger.js
document.addEventListener("DOMContentLoaded", () => {
  const hamburger = document.querySelector(".hamburger");
  const nav = document.querySelector(".nav");
  const icon = hamburger.querySelector("i");

  hamburger.addEventListener("click", () => {
    nav.classList.toggle("show");
    hamburger.classList.toggle("open");

    // Toggle icon class
    if (hamburger.classList.contains("open")) {
      icon.classList.remove("fa-bars");
      icon.classList.add("fa-times");
    } else {
      icon.classList.remove("fa-times");
      icon.classList.add("fa-bars");
    }
  });
});
