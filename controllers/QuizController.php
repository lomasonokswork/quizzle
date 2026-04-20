<?php
class QuizController
{
    private $quizModel;
    private $questionModel;

    public function __construct($quizModel, $questionModel)
    {
        $this->quizModel = $quizModel;
        $this->questionModel = $questionModel;
    }

    public function listQuizzes()
    {
        $quizzes = $this->quizModel->getAll();
        include 'views/layout/header.php';
        include 'views/quiz/list.php';
        include 'views/layout/footer.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'CSRF token validation failed'];
                header('Location: ?page=quiz&action=create');
                exit;
            }

            $title = trim($_POST['title'] ?? '');

            if (empty($title)) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Quiz title is required'];
                header('Location: ?page=quiz&action=create');
                exit;
            }

            if (strlen($title) > 30) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Quiz title must not exceed 30 characters'];
                header('Location: ?page=quiz&action=create');
                exit;
            }

            $quizId = $this->quizModel->create($title, $_SESSION['user_id']);

            if ($quizId) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Quiz created successfully'];
                header('Location: ?page=quiz&action=view&id=' . $quizId);
                exit;
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Failed to create quiz'];
                header('Location: ?page=quiz&action=create');
                exit;
            }
        }

        include 'views/layout/header.php';
        include 'views/quiz/create.php';
        include 'views/layout/footer.php';
    }

    public function view()
    {
        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid quiz ID'];
            header('Location: ?page=quiz&action=list');
            exit;
        }

        $quiz = $this->quizModel->getById($id);

        if (!$quiz) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Quiz not found'];
            header('Location: ?page=quiz&action=list');
            exit;
        }

        $questions = $this->questionModel->getByQuizId($id);

        include 'views/layout/header.php';
        include 'views/quiz/view.php';
        include 'views/layout/footer.php';
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid quiz ID'];
            header('Location: ?page=quiz&action=list');
            exit;
        }

        if ($_SESSION['permission_level'] !== 'Admin') {
            include 'views/layout/header.php';
            include 'views/errors/403.php';
            include 'views/layout/footer.php';
            exit;
        }

        if ($this->quizModel->delete($id)) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Quiz deleted successfully'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Failed to delete quiz'];
        }

        header('Location: ?page=quiz&action=list');
        exit;
    }
}
?>