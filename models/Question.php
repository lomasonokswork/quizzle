<?php
class Question
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getByQuizId($quizId)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM questions WHERE quiz_id = ? ORDER BY id ASC");
            $stmt->execute([$quizId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getById($id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM questions WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function create($quizId, $question, $variant1, $variant2, $variant3, $variant4, $variantCorrect)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO questions (quiz_id, question, variant_1, variant_2, variant_3, variant_4, variant_correct) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$quizId, $question, $variant1, $variant2, $variant3, $variant4, $variantCorrect]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update($id, $question, $variant1, $variant2, $variant3, $variant4, $variantCorrect)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE questions SET question = ?, variant_1 = ?, variant_2 = ?, variant_3 = ?, variant_4 = ?, variant_correct = ? WHERE id = ?");
            $stmt->execute([$question, $variant1, $variant2, $variant3, $variant4, $variantCorrect, $id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM questions WHERE id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getQuizIdByQuestionId($questionId)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT quiz_id FROM questions WHERE id = ?");
            $stmt->execute([$questionId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['quiz_id'] : false;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>