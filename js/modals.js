// modals.js
// ---------
// Controls the confirmation modal used for actions like:
// - Promoting/Demoting users (via GET)
// - Deleting messages (via POST form)
// - Deleting users (via POST form)

document.addEventListener("DOMContentLoaded", () => {
  // === Modal Elements ===
  const modal = document.getElementById("confirmation-modal");
  const modalMessage = document.getElementById("modal-message");
  const confirmBtn = document.getElementById("confirm-btn");
  const cancelBtn = document.getElementById("cancel-btn");
  const confirmForm = document.getElementById("confirm-form");
  const messageIdInput = document.getElementById("modal-message-id");
  const userIdInput = document.getElementById("modal-user-id");

  let actionUrl = null;
  let isFormAction = false;

  // === Handle GET-based actions (promote/demote) ===
  document.querySelectorAll(".action-link").forEach((link) => {
    // Skip delete buttons (those are handled as POST)
    if (
      link.classList.contains("delete-msg-btn") ||
      link.classList.contains("delete-user-btn")
    )
      return;

    link.addEventListener("click", (event) => {
      event.preventDefault();

      const action = link.dataset.action;
      const username = link.dataset.username;
      const url = link.href;

      modalMessage.textContent = `Are you sure you want to ${action} ${username}?`;
      actionUrl = url;
      isFormAction = false;

      modal.classList.remove("hidden");
    });
  });

  // === Handle Delete Message (POST) ===
  document.querySelectorAll(".delete-msg-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      modalMessage.textContent =
        btn.dataset.confirm || "Are you sure you want to delete this message?";
      messageIdInput.value = btn.dataset.id;
      userIdInput.value = ""; // clear other field
      isFormAction = true;

      modal.classList.remove("hidden");
    });
  });

  // === Handle Delete User (POST) ===
  document.querySelectorAll(".delete-user-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      modalMessage.textContent =
        btn.dataset.confirm || "Are you sure you want to delete this user?";
      userIdInput.value = btn.dataset.id;
      messageIdInput.value = ""; // clear other field
      isFormAction = true;

      modal.classList.remove("hidden");
    });
  });

  // === Confirm Button Behavior ===
  confirmBtn.addEventListener("click", (event) => {
    if (isFormAction) {
      // Allow normal form submission
      return;
    }

    // Handle GET-based redirect (e.g., promote/demote)
    event.preventDefault(); // ✅ Prevent unintended form submit
    if (actionUrl) {
      window.location.href = actionUrl;
    }
  });

  // === Cancel Button ===
  cancelBtn.addEventListener("click", closeModal);

  // === ESC Key Closes Modal ===
  window.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeModal();
  });

  // === Reset Modal State ===
  function closeModal() {
    modal.classList.add("hidden");
    messageIdInput.value = "";
    userIdInput.value = "";
    actionUrl = null;
    isFormAction = false;
  }
});
