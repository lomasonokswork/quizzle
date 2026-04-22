<?php
class QuestionController
{
    private $questionModel;
    private $quizModel;

    public function __construct($questionModel, $quizModel)
    {
        $this->questionModel = $questionModel;
        $this->quizModel = $quizModel;
    }

    public function add()
    {
        $quizId = $_GET['quiz_id'] ?? null;

        if (!$quizId || !is_numeric($quizId)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid quiz ID'];
            header('Location: ?page=quiz&action=list');
            exit;
        }

        $quiz = $this->quizModel->getById($quizId);

        if (!$quiz) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Quiz not found'];
            header('Location: ?page=quiz&action=list');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'CSRF token validation failed'];
                header('Location: ?page=question&action=add&quiz_id=' . $quizId);
                exit;
            }

            $question = trim($_POST['question'] ?? '');
            $variant1 = trim($_POST['variant_1'] ?? '');
            $variant2 = trim($_POST['variant_2'] ?? '');
            $variant3 = trim($_POST['variant_3'] ?? '');
            $variant4 = trim($_POST['variant_4'] ?? '');
            $variantCorrectKey = $_POST['variant_correct'] ?? '';

            if (empty($question) || empty($variant1) || empty($variant2) || empty($variant3) || empty($variant4) || empty($variantCorrectKey)) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'All fields are required'];
                header('Location: ?page=question&action=add&quiz_id=' . $quizId);
                exit;
            }

            $variantMap = [
                'variant_1' => $variant1,
                'variant_2' => $variant2,
                'variant_3' => $variant3,
                'variant_4' => $variant4
            ];

            if (!isset($variantMap[$variantCorrectKey])) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid correct answer selection'];
                header('Location: ?page=question&action=add&quiz_id=' . $quizId);
                exit;
            }

            $variantCorrect = $variantMap[$variantCorrectKey];

            if ($this->questionModel->create($quizId, $question, $variant1, $variant2, $variant3, $variant4, $variantCorrect)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Question added successfully'];
                header('Location: ?page=quiz&action=view&id=' . $quizId);
                exit;
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Failed to add question'];
                header('Location: ?page=question&action=add&quiz_id=' . $quizId);
                exit;
            }
        }

        include 'views/layout/header.php';
        include 'views/quiz/add_question.php';
        include 'views/layout/footer.php';
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid question ID'];
            header('Location: ?page=quiz&action=list');
            exit;
        }

        $question = $this->questionModel->getById($id);

        if (!$question) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Question not found'];
            header('Location: ?page=quiz&action=list');
            exit;
        }

        $quizId = $question['quiz_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'CSRF token validation failed'];
                header('Location: ?page=question&action=edit&id=' . $id);
                exit;
            }

            $questionText = trim($_POST['question'] ?? '');
            $variant1 = trim($_POST['variant_1'] ?? '');
            $variant2 = trim($_POST['variant_2'] ?? '');
            $variant3 = trim($_POST['variant_3'] ?? '');
            $variant4 = trim($_POST['variant_4'] ?? '');
            $variantCorrectKey = $_POST['variant_correct'] ?? '';

            if (empty($questionText) || empty($variant1) || empty($variant2) || empty($variant3) || empty($variant4) || empty($variantCorrectKey)) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'All fields are required'];
                header('Location: ?page=question&action=edit&id=' . $id);
                exit;
            }

            $variantMap = [
                'variant_1' => $variant1,
                'variant_2' => $variant2,
                'variant_3' => $variant3,
                'variant_4' => $variant4
            ];

            if (!isset($variantMap[$variantCorrectKey])) {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid correct answer selection'];
                header('Location: ?page=question&action=edit&id=' . $id);
                exit;
            }

            $variantCorrect = $variantMap[$variantCorrectKey];

            if ($this->questionModel->update($id, $questionText, $variant1, $variant2, $variant3, $variant4, $variantCorrect)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Question updated successfully'];
                header('Location: ?page=quiz&action=view&id=' . $quizId);
                exit;
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Failed to update question'];
                header('Location: ?page=question&action=edit&id=' . $id);
                exit;
            }
        }

        include 'views/layout/header.php';
        include 'views/quiz/edit_question.php';
        include 'views/layout/footer.php';
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Invalid question ID'];
            header('Location: ?page=quiz&action=list');
            exit;
        }

        $question = $this->questionModel->getById($id);

        if (!$question) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Question not found'];
            header('Location: ?page=quiz&action=list');
            exit;
        }

        $quizId = $question['quiz_id'];

        if ($this->questionModel->delete($id)) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Question deleted successfully'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Failed to delete question'];
        }

        header('Location: ?page=quiz&action=view&id=' . $quizId);
        exit;
    }
}
?>