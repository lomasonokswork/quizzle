<?php
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    $type = $flash['type'] === 'success' ? 'success-message' : 'error-message';
    echo '<div class="' . $type . '" role="status" aria-live="polite">' . htmlspecialchars($flash['message']) . '</div>';
    unset($_SESSION['flash']);
}
?>
