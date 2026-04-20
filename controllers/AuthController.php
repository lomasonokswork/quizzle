<?php
class AuthController
{
    private $userModel;

    public function __construct($userModel)
    {
        $this->userModel = $userModel;
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'CSRF token validation failed'];
                header('Location: ?page=login');
                exit;
            }

            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Username and password are required'];
                header('Location: ?page=login');
                exit;
            }

            if ($this->userModel->verifyPassword($username, $password)) {
                $user = $this->userModel->getUserByUsername($username);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['permission_level'] = $user['permission_level'];
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Login successful'];
                header('Location: ?page=quiz&action=list');
                exit;
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid username or password'];
                header('Location: ?page=login');
                exit;
            }
        }

        include 'views/layout/header.php';
        include 'views/auth/login.php';
        include 'views/layout/footer.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'CSRF token validation failed'];
                header('Location: ?page=register');
                exit;
            }

            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($username) || empty($password) || empty($confirmPassword)) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'All fields are required'];
                header('Location: ?page=register');
                exit;
            }

            if ($password !== $confirmPassword) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Passwords do not match'];
                header('Location: ?page=register');
                exit;
            }

            if (strlen($password) < 6) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Password must be at least 6 characters'];
                header('Location: ?page=register');
                exit;
            }

            if ($this->userModel->userExists($username)) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Username already exists'];
                header('Location: ?page=register');
                exit;
            }

            if ($this->userModel->createUser($username, $password, 'User')) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Registration successful. Please login.'];
                header('Location: ?page=login');
                exit;
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Registration failed. Try again.'];
                header('Location: ?page=register');
                exit;
            }
        }

        include 'views/layout/header.php';
        include 'views/auth/register.php';
        include 'views/layout/footer.php';
    }

    public function logout()
    {
        session_destroy();
        header('Location: ?page=login');
        exit;
    }
}
?>