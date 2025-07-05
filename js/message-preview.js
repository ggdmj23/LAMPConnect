// message-preview.js
// ------------------
// Controls the "Read More" modal for user-submitted messages on the dashboard

document.addEventListener("DOMContentLoaded", () => {
  // === Modal Elements ===
  const modal = document.getElementById("preview-modal");
  const closeBtn = document.getElementById("close-preview");

  const idField = document.getElementById("preview-id");
  const nameField = document.getElementById("preview-name");
  const emailField = document.getElementById("preview-email");
  const dateField = document.getElementById("preview-date");
  const messageField = document.getElementById("preview-message");
  const favIcon = document.getElementById("favorite-indicator");

  // === Defensive Check: Abort if any required element is missing ===
  if (
    !modal ||
    !closeBtn ||
    !idField ||
    !nameField ||
    !emailField ||
    !dateField ||
    !messageField ||
    !favIcon
  ) {
    console.warn("⚠️ Preview modal: Some required elements are missing.");
    return;
  }

  // === Handle click on each "Read More" button ===
  document.querySelectorAll(".read-more-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      // Populate modal fields from button's data attributes
      idField.textContent = btn.dataset.id || "—";
      nameField.textContent = btn.dataset.name || "—";
      emailField.textContent = btn.dataset.email || "—";
      dateField.textContent = btn.dataset.date || "—";
      messageField.textContent = btn.dataset.message || "—";
      favIcon.textContent = btn.dataset.favorite === "1" ? "⭐" : "☆";

      modal.classList.remove("hidden");
    });
  });

  // === Handle close button click ===
  closeBtn.addEventListener("click", () => {
    modal.classList.add("hidden");
  });

  // === Optional: Close modal if clicked outside modal-content ===
  modal.addEventListener("click", (e) => {
    if (e.target === modal) {
      modal.classList.add("hidden");
    }
  });

  // === Optional: ESC key closes modal ===
  window.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && !modal.classList.contains("hidden")) {
      modal.classList.add("hidden");
    }
  });
});
