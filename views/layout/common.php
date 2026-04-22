<?php
// Generate CSRF token if not exists
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Display flash messages
if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    if ($flash['type'] === 'success') {
        echo '<div class="success-message">' . htmlspecialchars($flash['message']) . '</div>';
    } elseif ($flash['type'] === 'error') {
        echo '<div class="error-message">' . htmlspecialchars($flash['message']) . '</div>';
    }
    unset($_SESSION['flash']);
}
?>