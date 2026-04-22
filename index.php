<?php
session_start();

require_once 'config/database.php';

require_once 'models/User.php';
require_once 'models/Quiz.php';
require_once 'models/Question.php';
require_once 'models/Result.php';

require_once 'controllers/AuthController.php';
require_once 'controllers/QuizController.php';
require_once 'controllers/QuestionController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/HomeController.php';

$userModel = new User($pdo);
$quizModel = new Quiz($pdo);
$questionModel = new Question($pdo);
$resultModel = new Result($pdo);

$authController = new AuthController($userModel);
$quizController = new QuizController($quizModel, $questionModel);
$questionController = new QuestionController($questionModel, $quizModel);
$userController = new UserController($userModel);
$homeController = new HomeController($quizModel, $questionModel, $resultModel);

$page = isset($_GET['page']) ? trim($_GET['page']) : 'home';
$action = isset($_GET['action']) ? trim($_GET['action']) : 'index';

$publicPages = ['login', 'register'];

$isAuthenticated = isset($_SESSION['user_id']);

if (!in_array($page, $publicPages) && !$isAuthenticated) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'Please log in first'];
    header('Location: ?page=login');
    exit;
}

try {
    if ($page === 'login') {
        $authController->login();
    } elseif ($page === 'register') {
        $authController->register();
    } elseif ($page === 'logout') {
        $authController->logout();
    } elseif ($page === 'quiz') {
        if ($action === 'list') {
            $quizController->listQuizzes();
        } elseif ($action === 'create') {
            $quizController->create();
        } elseif ($action === 'view') {
            $quizController->view();
        } elseif ($action === 'delete') {
            $quizController->delete();
        } else {
            $quizController->listQuizzes();
        }
    } elseif ($page === 'question') {
        if ($action === 'add') {
            $questionController->add();
        } elseif ($action === 'edit') {
            $questionController->edit();
        } elseif ($action === 'delete') {
            $questionController->delete();
        } else {
            header('Location: ?page=quiz&action=list');
            exit;
        }
    } elseif ($page === 'admin') {
        if ($action === 'users') {
            $userController->listUsers();
        } elseif ($action === 'makeadmin') {
            $userController->makeAdmin();
        } elseif ($action === 'removeadmin') {
            $userController->removeAdmin();
        } else {
            header('Location: ?page=admin&action=users');
            exit;
        }
    } elseif ($page === 'home') {
        if ($action === 'play') {
            $homeController->play();
        } elseif ($action === 'submit') {
            $homeController->submit();
        } elseif ($action === 'result') {
            $homeController->result();
        } else {
            $homeController->index();
        }
    } else {
        header('Location: ?page=home');
        exit;
    }
} catch (Exception $e) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()];
    header('Location: ?page=quiz&action=list');
    exit;
}
?>