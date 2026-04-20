<?php
class Quiz
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT q.*, u.username FROM quizzes q LEFT JOIN users u ON q.created_by = u.id ORDER BY q.created_at DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getById($id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT q.*, u.username FROM quizzes q LEFT JOIN users u ON q.created_by = u.id WHERE q.id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function create($title, $createdBy)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO quizzes (title, created_by, created_at) VALUES (?, ?, NOW())");
            $stmt->execute([$title, $createdBy]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM questions WHERE quiz_id = ?");
            $stmt->execute([$id]);

            $stmt = $this->pdo->prepare("DELETE FROM quizzes WHERE id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function canModify($quizId, $userId, $permissionLevel)
    {
        $quiz = $this->getById($quizId);
        if (!$quiz) {
            return false;
        }
        return $permissionLevel === 'Admin' || $quiz['created_by'] == $userId;
    }
}
?>