<?php

/**
 * footer.php
 * ----------
 * Shared footer for the LAMPConnect site.
 * - Displays branding, contact info, and social links.
 * - Loads configuration constants securely.
 */

require_once __DIR__ . '/../../LAMPConnect-secure/config.php';
?>

<footer class="site-footer">
  <!-- Glitch-style site name -->
  <div class="glitch-text" data-text="LAMP Connect">LAMP Connect</div>

  <!-- Social media links -->
  <div class="social-icons">
    <a href="<?= htmlspecialchars(GITHUB_URL) ?>" target="_blank" rel="noopener noreferrer" aria-label="GitHub">
      <i class="fab fa-github"></i>
    </a>
    <a href="<?= htmlspecialchars(LINKEDIN_URL) ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
      <i class="fab fa-linkedin"></i>
    </a>
    <a href="mailto:<?= htmlspecialchars(CONTACT_EMAIL) ?>" aria-label="Email">
      <i class="fas fa-envelope"></i>
    </a>
  </div>

  <!-- Contact info -->
  <p>
    <a href="tel:+1234567890" class="glitch-link">
      <i class="fas fa-phone-alt"></i> +123 456 7890
    </a> |
    <a href="https://maps.google.com/?q=123+Hackerman+Ave,+Cyberspace"
      target="_blank"
      rel="noopener noreferrer"
      class="glitch-link">
      <i class="fas fa-map-marker-alt"></i> 123 Hackerman Ave
    </a>
  </p>

  <!-- Legal -->
  <p class="footer-crt-text">
    © <?= date('Y') ?> LAMPConnect. Built using Linux, Apache, MySQL & PHP.
  </p>
</footer>