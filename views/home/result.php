<?php
$score = (float) $result['score'];
$isHighScore = $score >= 80;
$message = 'Keep practicing!';

if ($score >= 80) {
    $message = 'Great job!';
} elseif ($score >= 60) {
    $message = 'Nice progress!';
} elseif ($score >= 40) {
    $message = 'You are getting there.';
}
?>

<section class="page-title">
    <div>
        <p class="card-kicker">Results</p>
        <h1>Quiz Results</h1>
        <p>Your score is saved. Compare it with the leaderboard and try again whenever you want.</p>
    </div>
</section>

<div class="results-container">
    <section class="result-card<?php echo $isHighScore ? ' has-celebration' : ''; ?>" aria-labelledby="result-title">
        <h2 id="result-title"><?php echo htmlspecialchars($quiz['title']); ?></h2>

        <div class="score-display">
            <div class="score-circle" style="--score: <?php echo min(100, max(0, $score)); ?>">
                <span class="score-percentage"><?php echo $result['score']; ?>%</span>
            </div>
        </div>

        <p class="score-label">You scored <?php echo $result['correct_answers']; ?> / <?php echo $result['total_questions']; ?></p>
        <p><?php echo $message; ?></p>

        <div class="result-details">
            <div class="result-detail-row">
                <strong>Correct answers</strong>
                <span><?php echo $result['correct_answers']; ?>/<?php echo $result['total_questions']; ?></span>
            </div>
            <div class="result-detail-row">
                <strong>Score</strong>
                <span><?php echo $result['score']; ?>%</span>
            </div>
            <div class="result-detail-row">
                <strong>Attempted on</strong>
                <span><?php echo date('M d, Y H:i', strtotime($result['attempted_at'])); ?></span>
            </div>
        </div>

        <div class="result-actions">
            <a href="?page=home&action=play&id=<?php echo $result['quiz_id']; ?>" class="btn">Try Again</a>
            <a href="?page=home" class="btn btn-secondary">Back to Quizzes</a>
        </div>
    </section>

    <section class="leaderboard-section" aria-labelledby="leaderboard-title">
        <p class="card-kicker">Top performers</p>
        <h2 id="leaderboard-title">Quiz Leaderboard</h2>

        <?php if (empty($leaderboard)): ?>
            <div class="empty-state">
                <h3>No scores recorded yet</h3>
                <p>Finish a quiz attempt to start the leaderboard.</p>
            </div>
        <?php else: ?>
            <div class="table-wrap">
                <table class="leaderboard-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Score</th>
                            <th>Tries</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($leaderboard as $rank => $entry): ?>
                            <?php if ($entry['username']): ?>
                                <tr <?php echo ((int) $entry['id'] === (int) $_SESSION['user_id']) ? 'class="current-user"' : ''; ?>>
                                    <td><?php echo $rank + 1; ?></td>
                                    <td><?php echo htmlspecialchars($entry['username']); ?></td>
                                    <td><?php echo $entry['best_score'] ? number_format($entry['best_score'], 2) . '%' : '-'; ?></td>
                                    <td><?php echo $entry['total_attempts'] ?? 0; ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
</div>
