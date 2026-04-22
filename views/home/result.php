<div class="page-title">
    <h1>Quiz Results</h1>
</div>

<div class="results-container">
    <div class="result-card">
        <h2><?php echo htmlspecialchars($quiz['title']); ?></h2>
        
        <div class="score-display">
            <div class="score-circle">
                <span class="score-percentage"><?php echo $result['score']; ?>%</span>
            </div>
        </div>

        <div class="result-details">
            <p>
                <strong>Correct Answers:</strong> 
                <span class="answer-count"><?php echo $result['correct_answers']; ?>/<?php echo $result['total_questions']; ?></span>
            </p>
            <p>
                <strong>Score:</strong> 
                <span class="score-text">
                    <?php 
                    if ($result['score'] >= 80) {
                        echo 'Excellent!';
                    } elseif ($result['score'] >= 60) {
                        echo 'Good!';
                    } elseif ($result['score'] >= 40) {
                        echo 'Fair';
                    } else {
                        echo 'Try Again';
                    }
                    ?>
                </span>
            </p>
            <p>
                <strong>Attempted On:</strong> 
                <span><?php echo date('M d, Y H:i', strtotime($result['attempted_at'])); ?></span>
            </p>
        </div>

        <div class="result-actions">
            <a href="?page=home" class="btn btn-primary">Back to Home</a>
            <a href="?page=home&action=play&id=<?php echo $result['quiz_id']; ?>" class="btn btn-secondary">Retake Quiz</a>
        </div>
    </div>

    <div class="leaderboard-section">
        <h2>Quiz Leaderboard</h2>
        <p class="leaderboard-subtitle">Top scores for this quiz</p>

        <?php if (empty($leaderboard)): ?>
            <p>No scores recorded yet.</p>
        <?php else: ?>
            <table class="leaderboard-table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>User</th>
                        <th>Best Score</th>
                        <th>Average Score</th>
                        <th>Attempts</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leaderboard as $rank => $entry): ?>
                        <?php if ($entry['username']): ?>
                            <tr <?php echo ($_SESSION['user_id']) ? 'class="current-user"' : ''; ?>>
                                <td class="rank"><?php echo $rank + 1; ?></td>
                                <td class="username"><?php echo htmlspecialchars($entry['username']); ?></td>
                                <td class="best-score"><?php echo $entry['best_score'] ? number_format($entry['best_score'], 2) . '%' : '-'; ?></td>
                                <td class="avg-score"><?php echo $entry['avg_score'] ? number_format($entry['avg_score'], 2) . '%' : '-'; ?></td>
                                <td class="attempts"><?php echo $entry['total_attempts'] ?? 0; ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
