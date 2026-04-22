<div class="page-title">
    <h1>Available Quizzes</h1>
</div>

<?php if (empty($quizzes)): ?>
    <p>No quizzes available yet.</p>
<?php else: ?>
    <div class="quizzes-grid">
        <?php foreach ($quizzes as $quiz): ?>
            <div class="quiz-card">
                <h3><?php echo htmlspecialchars($quiz['title']); ?></h3>

                <?php if (isset($userResultsByQuiz[$quiz['id']])): ?>
                    <div class="quiz-stats">
                        <p class="score-badge">Last Score: <strong><?php echo $userResultsByQuiz[$quiz['id']]['score']; ?>%</strong>
                        </p>
                        <p class="attempts-badge">Attempts:
                            <strong><?php echo count(array_filter($userResults, function ($r) use ($quiz) {
                                return $r['quiz_id'] == $quiz['id']; })); ?></strong>
                        </p>
                    </div>
                <?php else: ?>
                    <div class="quiz-stats">
                        <p class="attempts-badge">Not attempted yet</p>
                    </div>
                <?php endif; ?>

                <div class="button-group">
                    <a href="?page=home&action=play&id=<?php echo $quiz['id']; ?>" class="btn btn-primary">Play Quiz</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="history-section">
        <h2>Quiz History</h2>
        <?php if (empty($userResults)): ?>
            <p>You haven't attempted any quizzes yet. Start by playing one of the quizzes above!</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Quiz Title</th>
                        <th>Score</th>
                        <th>Correct Answers</th>
                        <th>Date Attempted</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($userResults as $result): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($result['quiz_title']); ?></td>
                            <td><?php echo $result['score']; ?>%</td>
                            <td><?php echo $result['correct_answers']; ?>/<?php echo $result['total_questions']; ?></td>
                            <td><?php echo date('M d, Y H:i', strtotime($result['attempted_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
<?php endif; ?>