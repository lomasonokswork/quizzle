<?php
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/style.css">
    <link rel="stylesheet" href="../public/css/home-index.css">
    <link rel="stylesheet" href="../public/css/home-play.css">
    <link rel="stylesheet" href="../public/css/home-result.css">
    <title>Quizzle - Quiz Management System</title>
</head>

<body>
    <header>
        <nav>
            <div class="logo"><a href="?page=home" style="color: white; text-decoration: none;">Quizzle</a>
            </div>
            <div class="nav-middle">
                <a href="?page=home">Home</a>
                <?php if (isset($_SESSION['permission_level']) && $_SESSION['permission_level'] === 'Admin'): ?>
                    <a href="?page=quiz&action=list">Manage Quizzes</a>
                <?php endif; ?>
            </div>
            <div class="nav-right">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="user-info">
                        <?php if (isset($_SESSION['permission_level']) && $_SESSION['permission_level'] === 'Admin'): ?>
                            <a href="?page=admin&action=users" style="font-weight: bold; color: #f1c40f;">Admin Panel</a>
                        <?php endif; ?>
                        <a href="?page=logout">Logout</a>
                    </div>
                <?php else: ?>
                    <div class="user-info">
                        <a href="?page=login">Login</a>
                        <a href="?page=register">Register</a>
                    </div>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <div class="container">
        <?php include 'common.php'; ?>