<?php

/**
 * message_center.php
 * ------------------
 * Displays all submitted messages for admins and super admins.
 * Accessible only to authenticated admin-level users.
 */

require_once 'includes/require_admin.php';
require_once 'includes/db.php';
require_once 'includes/auth_utils.php';

$pageTitle = "Message Center";
include 'includes/header.php';

$pdo = getPDO();
$stmt = $pdo->query("SELECT * FROM messages ORDER BY submitted_at DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="admin-layout">

    <!-- LEFT SIDEBAR -->
    <aside class="admin-sidebar">
        <h3><i class="fas fa-toolbox"></i> Admin Menu</h3>
        <ul class="admin-menu">
            <li><i class="fas fa-users-cog"></i> <a href="manage_users.php">User Management</a></li>

            <?php if (isSuperAdmin()): ?>
                <li><i class="fas fa-user-shield"></i> <a href="super_manage_users.php">Role Management</a></li>
            <?php endif; ?>

            <li><i class="fas fa-comments"></i> <a class="active" href="message_center.php">Message Center</a></li>
            <li><i class="fas fa-file-alt"></i> <a href="#">Reports</a></li>
            <li><i class="fas fa-cogs"></i> <a href="#">System Settings</a></li>
            <li><i class="fas fa-user-cog"></i> <a href="dashboard.php">Dashboard</a></li>
            <li><i class="fas fa-sign-out-alt"></i>
                <a href="logout.php">Logout (<?= htmlspecialchars(getCurrentUser()['name']) ?>)</a>
            </li>
        </ul>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <h2>Message Center</h2>

        <?php if (empty($messages)): ?>
            <p>No messages found.</p>
        <?php else: ?>
            <div class="scroll-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $msg): ?>
                            <tr>
                                <td><?= htmlspecialchars($msg['id']) ?></td>
                                <td><?= htmlspecialchars($msg['user_id'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($msg['name']) ?></td>
                                <td><?= htmlspecialchars($msg['email']) ?></td>
                                <td><?= nl2br(htmlspecialchars(mb_strimwidth($msg['message'], 0, 30, '...'))) ?></td>
                                <td><?= htmlspecialchars($msg['submitted_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- RIGHT SIDEBAR -->
    <aside class="admin-spacer">
        <h3><i class="fas fa-lightbulb"></i> Tips</h3>
        <ul class="admin-menu">
            <li><i class="fas fa-envelope-open-text"></i> Review messages submitted by users</li>
            <li><i class="fas fa-user-clock"></i> Check timestamps for context</li>
        </ul>
    </aside>

</div>

<?php include 'includes/footer.php'; ?>