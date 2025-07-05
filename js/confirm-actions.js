// js/confirm-actions.js

document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".confirm-action").forEach(function (link) {
    link.addEventListener("click", function (event) {
      const message = this.dataset.confirm;
      if (!confirm(message)) {
        event.preventDefault();
      }
    });
  });
});
