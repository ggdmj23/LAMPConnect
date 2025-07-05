document.addEventListener('DOMContentLoaded', () => {
  const links = document.querySelectorAll('.nav-link');
  const underline = document.querySelector('.nav-underline::after') || document.querySelector('.nav-underline');

  const active = document.querySelector('.nav-link.active');
  if (active && underline) {
    const rect = active.getBoundingClientRect();
    const navRect = active.parentElement.getBoundingClientRect();
    underline.style.left = `${rect.left - navRect.left}px`;
    underline.style.width = `${rect.width}px`;
  }
});
