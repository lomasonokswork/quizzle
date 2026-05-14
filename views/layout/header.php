<?php
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$currentPage = $_GET['page'] ?? 'home';
$currentAction = $_GET['action'] ?? 'index';

if (!function_exists('nav_active')) {
    function nav_active($page, $action = null)
    {
        $currentPage = $_GET['page'] ?? 'home';
        $currentAction = $_GET['action'] ?? 'index';

        if ($currentPage !== $page) {
            return '';
        }

        if ($action !== null && $currentAction !== $action) {
            return '';
        }

        return ' active';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="public/favicon.svg">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="public/css/home-index.css">
    <link rel="stylesheet" href="public/css/home-play.css">
    <link rel="stylesheet" href="public/css/home-result.css">
    <title>Quizzle</title>
</head>

<body>
    <header class="site-header">
        <nav class="site-nav" aria-label="Main navigation">
            <div class="brand" aria-label="Quizzle">
                <span class="brand-mark" aria-hidden="true">Q</span>
                <span>Quizzle</span>
            </div>

            <button class="nav-toggle" type="button" aria-controls="nav-menu" aria-expanded="false">
                <span class="nav-toggle-lines" aria-hidden="true"></span>
                <span class="sr-only">Toggle navigation</span>
            </button>

            <div class="nav-menu" id="nav-menu">
                <div class="nav-links">
                    <a class="<?php echo nav_active('home'); ?>" href="?page=home">Home</a>
                    <?php if (isset($_SESSION['permission_level']) && $_SESSION['permission_level'] === 'Admin'): ?>
                        <a class="<?php echo nav_active('quiz', 'list'); ?>" href="?page=quiz&action=list">Manage Quizzes</a>
                    <?php endif; ?>
                </div>

                <div class="nav-actions">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if (isset($_SESSION['permission_level']) && $_SESSION['permission_level'] === 'Admin'): ?>
                            <a class="admin-link<?php echo nav_active('admin', 'users'); ?>" href="?page=admin&action=users">Admin Panel</a>
                        <?php endif; ?>
                        <a href="?page=logout">Logout</a>
                    <?php else: ?>
                        <a class="<?php echo nav_active('login'); ?>" href="?page=login">Login</a>
                        <a class="<?php echo nav_active('register'); ?>" href="?page=register">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <main class="page-shell">
        <?php include 'common.php'; ?>
