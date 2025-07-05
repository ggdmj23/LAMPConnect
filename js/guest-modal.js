// js/guest-modal.js

document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("guestModal");
  const closeBtn = document.getElementById("closeGuestModal");

  if (!modal || !closeBtn) {
    console.warn("Guest modal or close button not found.");
    return;
  }

  // Show the modal on load
  modal.classList.remove("hidden");

  // Close on close button click
  closeBtn.addEventListener("click", () => {
    closeModal();
  });

  // Close on ESC key
  window.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      closeModal();
    }
  });

  // Close when clicking outside the modal content
  modal.addEventListener("click", (e) => {
    if (e.target === modal) {
      closeModal();
    }
  });

  function closeModal() {
    modal.classList.add("hidden");

    // Optional: Reset modal fields marked for clearing
    modal.querySelectorAll("[data-reset]").forEach((el) => {
      el.textContent = "";
    });
  }
});
