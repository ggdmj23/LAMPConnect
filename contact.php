<?php

/**
 * contact.php
 * -----------
 * Displays a contact form and shows feedback based on status from the URL.
 * Handles guest or user message preview modals.
 */

session_start(); // Optional: include if not already started via header
$pageTitle = "Contact";
include 'includes/header.php';

// === Feedback Message Setup ===
$message = '';
$messageClass = '';
$statusParam = $_GET['status'] ?? '';

if (in_array($statusParam, ['success', 'partial', 'error', 'guest-preview', 'user-preview'])) {
    $mailStatus = $_GET['mail'] ?? '';
    switch ($mailStatus) {
        case 'success':
            $message = '<span class="console-label ok">[OK]</span> Your message has been sent successfully!';
            $messageClass = 'success';
            break;
        case 'fail':
            $message = '<span class="console-label warn">[WARN]</span> Your message was saved, but the email could not be sent.';
            $messageClass = 'error';
            break;
        default:
            if ($statusParam === 'error') {
                $message = '<span class="console-label error">[ERROR]</span> Something went wrong. Please try again.';
                $messageClass = 'error';
            }
            break;
    }
}

// === Guest/User Preview Modal Setup ===
$showGuestModal = false;
$modalTitle = '';

if (in_array($statusParam, ['guest-preview', 'user-preview'])) {
    $modalTitle = $statusParam === 'guest-preview' ? 'Guest Message Preview' : 'User Message Preview';
    $guestMessage = [
        'name'    => htmlspecialchars($_GET['name'] ?? '', ENT_QUOTES, 'UTF-8'),
        'email'   => htmlspecialchars($_GET['email'] ?? '', ENT_QUOTES, 'UTF-8'),
        'message' => nl2br(htmlspecialchars($_GET['message'] ?? '', ENT_QUOTES, 'UTF-8')),
        'mail'    => ($_GET['mail'] ?? '') === 'success' ? 'Email sent' : 'Email failed',
    ];
    $showGuestModal = true;
}
?>

<div class="admin-layout">

    <!-- LEFT SIDEBAR -->
    <aside class="admin-sidebar">
        <h3><i class="fas fa-question-circle"></i> Need Help?</h3>
        <ul class="admin-menu">
            <li><i class="fas fa-info-circle"></i> <a href="about.php">What is LAMPConnect?</a></li>
            <li><i class="fas fa-book"></i> <a href="#">User Guide (Coming Soon)</a></li>
            <li><i class="fas fa-shield-alt"></i> <a href="#">Privacy Policy</a></li>
            <li><i class="fas fa-bug"></i> <a href="#">Report a Bug</a></li>
            <li><i class="fas fa-envelope"></i> <a href="#">Contact Admin Team</a></li>
            <?php if (isset($_SESSION['user'])): ?>
                <li><i class="fas fa-sign-out-alt"></i>
                    <a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['user']['name']) ?>)</a>
                </li>
            <?php else: ?>
                <li><i class="fas fa-sign-in-alt"></i>
                    <a href="login.php">Login</a>
                </li>
            <?php endif; ?>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- Feedback Message -->
        <?php if (!empty($message)): ?>
            <div class="status-message <?= htmlspecialchars($messageClass, ENT_QUOTES, 'UTF-8') ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <!-- Contact Form -->
        <h2>Contact Us</h2>
        <form action="process_contact.php" method="POST" autocomplete="off">
            <label for="name">Name:</label><br>
            <input type="text" name="name" id="name" required><br><br>

            <label for="email">Email:</label><br>
            <input type="email" name="email" id="email" required><br><br>

            <label for="message">Message:</label><br>
            <textarea name="message" id="message" rows="5" required></textarea><br><br>

            <input type="submit" value="Send">
        </form>

        <!-- Guest/User Message Preview Modal -->
        <?php if ($showGuestModal): ?>
            <div id="guestModal" class="modal hidden">
                <div class="modal-content">
                    <h3><span class="typewriter-text"><?= $modalTitle ?></span><span class="cursor">_</span></h3>
                    <div class="typewriter-block modal-scrollable">
                        <p><strong>Name:</strong> <?= $guestMessage['name'] ?></p>
                        <p><strong>Email:</strong> <?= $guestMessage['email'] ?></p>
                        <p><strong>Message:</strong><br>
                        <div id="guest-message"><?= $guestMessage['message'] ?></div>
                        </p>
                        <p><strong>Status:</strong> <?= $guestMessage['mail'] ?></p>
                    </div>
                    <div class="modal-actions">
                        <button id="closeGuestModal">Close</button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- RIGHT SIDEBAR -->
    <aside class="admin-spacer">
        <h3><i class="fas fa-lightbulb"></i> Message Tips</h3>
        <ul class="admin-menu">
            <li><i class="fas fa-check-circle"></i> Be clear and concise</li>
            <li><i class="fas fa-user-tag"></i> Include your username (if logged in)</li>
            <li><i class="fas fa-clock"></i> We usually reply within 24–48 hours</li>
            <li><i class="fas fa-shield-virus"></i> Do not include sensitive info</li>
        </ul>

        <h3><i class="fas fa-envelope-open-text"></i> Email Status</h3>
        <ul class="admin-menu">
            <li><i class="fas fa-paper-plane"></i> Mail handler: <strong>msmtp</strong></li>
            <li><i class="fas fa-server"></i> Mail service: <strong>Gmail API</strong></li>
            <li><i class="fas fa-info-circle"></i> <strong>Status:</strong>
                <span style="color:#0f0;">
                    <?= (isset($_GET['mail']) && $_GET['mail'] === 'success') ? 'OK' : 'Pending'; ?>
                </span>
            </li>
        </ul>
    </aside>

</div>

<?php include 'includes/footer.php'; ?>
<script src="js/guest-modal.js"></script>