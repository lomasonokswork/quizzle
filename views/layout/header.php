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
    <title>Quizzle - Quiz Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        header {
            background-color: #2c3e50;
            color: white;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 1.5rem;
            transition: opacity 0.3s;
        }

        nav a:hover {
            opacity: 0.8;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        table th,
        table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #2c3e50;
            color: white;
            font-weight: bold;
        }

        table tr:hover {
            background-color: #f9f9f9;
        }

        .button-group {
            display: flex;
            gap: 0.5rem;
        }

        button,
        .btn,
        a.btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background-color 0.3s;
        }

        button:hover,
        .btn:hover,
        a.btn:hover {
            background-color: #2980b9;
        }

        .btn-danger {
            background-color: #e74c3c;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-success {
            background-color: #27ae60;
        }

        .btn-success:hover {
            background-color: #229954;
        }

        .btn-secondary {
            background-color: #95a5a6;
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
        }

        form {
            background-color: white;
            padding: 1.5rem;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        select,
        textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        form button {
            width: 100%;
        }

        .form-wide {
            max-width: 100%;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .form-row-full {
            grid-column: 1 / -1;
        }

        h1 {
            margin-bottom: 1.5rem;
            color: #2c3e50;
        }

        h2 {
            margin-bottom: 1rem;
            color: #2c3e50;
        }

        .page-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .question-item {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .question-item h3 {
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }

        .question-variants {
            background-color: #f9f9f9;
            padding: 0.5rem;
            border-radius: 3px;
            margin: 0.5rem 0;
            font-size: 0.9rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .variant-input-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .variant-input-group input[type="text"] {
            flex: 1;
        }

        .variant-correct-label {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            white-space: nowrap;
            font-weight: normal;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 3px;
            transition: background-color 0.2s;
        }

        .variant-correct-label:hover {
            background-color: #f0f0f0;
        }

        .variant-correct-label input[type="radio"] {
            cursor: pointer;
            margin: 0;
        }

        .variant-correct-label span {
            font-size: 0.85rem;
            color: #27ae60;
            font-weight: bold;
        }

        @media (max-width: 600px) {
            nav {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            nav a {
                margin-left: 0;
            }

            .nav-right {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
                width: 100%;
            }

            table {
                font-size: 0.9rem;
            }

            table th,
            table td {
                padding: 0.5rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .button-group {
                flex-direction: column;
            }

            button,
            .btn,
            a.btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="logo"><a href="?page=quiz&action=list" style="color: white; text-decoration: none;">Quizzle</a>
            </div>
            <div class="nav-right">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="user-info">
                        <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
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
        <?php
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