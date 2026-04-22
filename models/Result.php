<?php
class Result
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function saveResult($userId, $quizId, $score, $correctAnswers, $totalQuestions)
    {
        try {
            $stmt = $this->pdo->prepare(
                "INSERT INTO quiz_results (user_id, quiz_id, score, correct_answers, total_questions, attempted_at) 
                 VALUES (?, ?, ?, ?, ?, NOW())"
            );
            $stmt->execute([$userId, $quizId, $score, $correctAnswers, $totalQuestions]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getResultById($id)
    {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT r.*, q.title as quiz_title, u.username 
                 FROM quiz_results r 
                 LEFT JOIN quizzes q ON r.quiz_id = q.id 
                 LEFT JOIN users u ON r.user_id = u.id 
                 WHERE r.id = ?"
            );
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getUserResults($userId)
    {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT r.*, q.title as quiz_title 
                 FROM quiz_results r 
                 LEFT JOIN quizzes q ON r.quiz_id = q.id 
                 WHERE r.user_id = ? 
                 ORDER BY r.attempted_at DESC"
            );
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getQuizResults($quizId)
    {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT r.*, u.username 
                 FROM quiz_results r 
                 LEFT JOIN users u ON r.user_id = u.id 
                 WHERE r.quiz_id = ? 
                 ORDER BY r.score DESC, r.attempted_at DESC"
            );
            $stmt->execute([$quizId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getLeaderboard($quizId = null)
    {
        try {
            if ($quizId) {
                $stmt = $this->pdo->prepare(
                    "SELECT u.id, u.username, q.id as quiz_id, q.title as quiz_title, 
                            AVG(r.score) as avg_score, COUNT(r.id) as total_attempts, 
                            MAX(r.score) as best_score
                     FROM users u
                     LEFT JOIN quiz_results r ON u.id = r.user_id
                     LEFT JOIN quizzes q ON r.quiz_id = q.id
                     WHERE q.id = ?
                     GROUP BY u.id, u.username, q.id, q.title
                     ORDER BY best_score DESC, avg_score DESC"
                );
                $stmt->execute([$quizId]);
            } else {
                $stmt = $this->pdo->prepare(
                    "SELECT u.id, u.username, 
                            AVG(r.score) as avg_score, COUNT(r.id) as total_attempts, 
                            MAX(r.score) as best_score
                     FROM users u
                     LEFT JOIN quiz_results r ON u.id = r.user_id
                     GROUP BY u.id, u.username
                     ORDER BY best_score DESC, avg_score DESC"
                );
                $stmt->execute();
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
?>
