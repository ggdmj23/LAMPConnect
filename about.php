<?php

/**
 * about.php
 * ---------
 * Displays information about the LAMPConnect project,
 * including goals, features, technologies used, and learning outcomes.
 */

$pageTitle = "About";
include 'includes/header.php';
?>

<div class="admin-layout">

  <!-- LEFT SIDEBAR: Navigation Links -->
  <aside class="admin-sidebar">
    <h3><i class="fas fa-book"></i> Explore</h3>
    <ul class="admin-menu">
      <li><i class="fas fa-lightbulb"></i> <a href="index.php">What is LAMPConnect?</a></li>
      <li><i class="fas fa-rocket"></i> <a href="contact.php">Try the Contact Form</a></li>
      <li><i class="fas fa-code-branch"></i> <a href="#">View Project Structure</a></li>
      <li><i class="fas fa-graduation-cap"></i> <a href="#">Learning Checklist</a></li>
      <li><i class="fas fa-file-alt"></i> <a href="#">Documentation</a></li>
    </ul>
  </aside>

  <!-- MAIN CONTENT -->
  <div class="main-content">

    <!-- Project Introduction -->
    <h2>About LAMPConnect</h2>
    <p>
      <strong>LAMPConnect</strong> is a lightweight, beginner-friendly web project built on the
      <em>LAMP stack</em> — Linux, Apache, MySQL, and PHP. It helps students and developers understand
      how to connect frontend forms with backend logic and database storage.
    </p>

    <!-- Project Goals -->
    <h3>Project Goals</h3>
    <ul class="custom-bullets">
      <li>Learn how to set up a local development environment</li>
      <li>Understand how PHP interacts with MySQL databases</li>
      <li>Practice secure form handling and email integration</li>
      <li>Modularize code for scalability and readability</li>
    </ul>

    <!-- Feature List -->
    <h3>Features</h3>
    <p>This project includes:</p>
    <ul class="custom-bullets">
      <li>A contact form that saves data to a database and sends notification emails</li>
      <li>Modular PHP structure with reusable headers, footers, and config files</li>
      <li>A clean folder layout for separating styles, logic, and views</li>
      <li>Logging to a local <code>log.txt</code> file to track system behavior</li>
    </ul>

    <!-- Technology Stack -->
    <h3>Technologies Used</h3>
    <ul class="custom-bullets">
      <li>Linux Mint</li>
      <li>Apache2</li>
      <li>MySQL</li>
      <li>PHP 8+</li>
      <li>VS Codium</li>
      <li>msmtp + Gmail App Password</li>
    </ul>

    <!-- Closing Encouragement -->
    <p>
      If you're just getting started with backend web development or looking for
      a practical LAMP project template, <strong>LAMPConnect</strong> is a great place to begin!
    </p>

  </div>

  <!-- RIGHT SIDEBAR: Learning Outcomes & Tools -->
  <aside class="admin-spacer">
    <h3><i class="fas fa-graduation-cap"></i> Learning Outcomes</h3>
    <ul class="admin-menu">
      <li><i class="fas fa-check-circle"></i> Set up a secure LAMP environment</li>
      <li><i class="fas fa-check-circle"></i> Understand PHP <-> MySQL integration</li>
      <li><i class="fas fa-check-circle"></i> Implement reusable layout components</li>
      <li><i class="fas fa-check-circle"></i> Practice backend email handling</li>
      <li><i class="fas fa-check-circle"></i> Build modular, maintainable code</li>
    </ul>

    <h3><i class="fas fa-tools"></i> Tools in Use</h3>
    <ul class="admin-menu">
      <li><i class="fas fa-terminal"></i> Linux Mint Terminal</li>
      <li><i class="fas fa-server"></i> Apache 2.4</li>
      <li><i class="fas fa-database"></i> MySQL 8</li>
      <li><i class="fas fa-code"></i> PHP <?= htmlspecialchars(phpversion()) ?></li>
      <li><i class="fas fa-laptop-code"></i> VS Codium</li>
    </ul>
  </aside>

</div>

<?php include 'includes/footer.php'; ?>