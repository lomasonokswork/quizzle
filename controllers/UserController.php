<?php
class UserController
{
    private $userModel;

    public function __construct($userModel)
    {
        $this->userModel = $userModel;
    }

    public function listUsers()
    {
        if ($_SESSION['permission_level'] !== 'Admin') {
            include 'views/layout/header.php';
            include 'views/errors/403.php';
            include 'views/layout/footer.php';
            exit;
        }

        $users = $this->userModel->getAll();

        include 'views/layout/header.php';
        include 'views/admin/users.php';
        include 'views/layout/footer.php';
    }

    public function makeAdmin()
    {
        if ($_SESSION['permission_level'] !== 'Admin') {
            include 'views/layout/header.php';
            include 'views/errors/403.php';
            include 'views/layout/footer.php';
            exit;
        }

        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid user ID'];
            header('Location: ?page=admin&action=users');
            exit;
        }

        $user = $this->userModel->getUserById($id);

        if (!$user) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'User not found'];
            header('Location: ?page=admin&action=users');
            exit;
        }

        if ($user['id'] == $_SESSION['user_id']) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'You cannot modify your own permissions'];
            header('Location: ?page=admin&action=users');
            exit;
        }

        if ($this->userModel->makeAdmin($id)) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'User promoted to Admin'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Failed to update user'];
        }

        header('Location: ?page=admin&action=users');
        exit;
    }

    public function removeAdmin()
    {
        if ($_SESSION['permission_level'] !== 'Admin') {
            include 'views/layout/header.php';
            include 'views/errors/403.php';
            include 'views/layout/footer.php';
            exit;
        }

        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid user ID'];
            header('Location: ?page=admin&action=users');
            exit;
        }

        $user = $this->userModel->getUserById($id);

        if (!$user) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'User not found'];
            header('Location: ?page=admin&action=users');
            exit;
        }

        if ($user['id'] == $_SESSION['user_id']) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'You cannot modify your own permissions'];
            header('Location: ?page=admin&action=users');
            exit;
        }

        if ($this->userModel->removeAdmin($id)) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'User demoted to User'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Failed to update user'];
        }

        header('Location: ?page=admin&action=users');
        exit;
    }
}
?>