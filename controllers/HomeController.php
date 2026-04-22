<?php
class HomeController
{
    private $quizModel;
    private $questionModel;
    private $resultModel;

    public function __construct($quizModel, $questionModel, $resultModel)
    {
        $this->quizModel = $quizModel;
        $this->questionModel = $questionModel;
        $this->resultModel = $resultModel;
    }

    public function index()
    {
        $quizzes = $this->quizModel->getAll();
        $userResults = $this->resultModel->getUserResults($_SESSION['user_id']);
        $userResultsByQuiz = [];
        
        foreach ($userResults as $result) {
            $userResultsByQuiz[$result['quiz_id']] = $result;
        }

        include 'views/layout/header.php';
        include 'views/home/index.php';
        include 'views/layout/footer.php';
    }

    public function play()
    {
        $quizId = $_GET['id'] ?? null;

        if (!$quizId || !is_numeric($quizId)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid quiz ID'];
            header('Location: ?page=home');
            exit;
        }

        $quiz = $this->quizModel->getById($quizId);

        if (!$quiz) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Quiz not found'];
            header('Location: ?page=home');
            exit;
        }

        $questions = $this->questionModel->getByQuizId($quizId);

        if (empty($questions)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'This quiz has no questions yet'];
            header('Location: ?page=home');
            exit;
        }

        include 'views/layout/header.php';
        include 'views/home/play.php';
        include 'views/layout/footer.php';
    }

    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid request method'];
            header('Location: ?page=home');
            exit;
        }

        if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'CSRF token validation failed'];
            header('Location: ?page=home');
            exit;
        }

        $quizId = $_POST['quiz_id'] ?? null;

        if (!$quizId || !is_numeric($quizId)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid quiz ID'];
            header('Location: ?page=home');
            exit;
        }

        $quiz = $this->quizModel->getById($quizId);

        if (!$quiz) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Quiz not found'];
            header('Location: ?page=home');
            exit;
        }

        $questions = $this->questionModel->getByQuizId($quizId);
        $correctAnswers = 0;
        $totalQuestions = count($questions);

        foreach ($questions as $question) {
            $userAnswer = $_POST['question_' . $question['id']] ?? null;
            if ($userAnswer && trim($userAnswer) === trim($question['variant_correct'])) {
                $correctAnswers++;
            }
        }

        $score = ($correctAnswers / $totalQuestions) * 100;
        $resultId = $this->resultModel->saveResult(
            $_SESSION['user_id'],
            $quizId,
            round($score, 2),
            $correctAnswers,
            $totalQuestions
        );

        if ($resultId) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Quiz completed successfully!'];
            header('Location: ?page=home&action=result&id=' . $resultId);
            exit;
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Failed to save quiz result'];
            header('Location: ?page=home');
            exit;
        }
    }

    public function result()
    {
        $resultId = $_GET['id'] ?? null;

        if (!$resultId || !is_numeric($resultId)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid result ID'];
            header('Location: ?page=home');
            exit;
        }

        $result = $this->resultModel->getResultById($resultId);

        if (!$result || $result['user_id'] != $_SESSION['user_id']) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Result not found or access denied'];
            header('Location: ?page=home');
            exit;
        }

        $quiz = $this->quizModel->getById($result['quiz_id']);
        $leaderboard = $this->resultModel->getLeaderboard($result['quiz_id']);

        include 'views/layout/header.php';
        include 'views/home/result.php';
        include 'views/layout/footer.php';
    }
}
?>
