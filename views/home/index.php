<section class="hero">
    <p class="card-kicker">Quiz dashboard</p>
    <h1>Pick a quiz and sharpen what you know.</h1>
    <p>Browse available quizzes, review your recent scores, and jump back into practice whenever you are ready.</p>
    <div class="hero-actions">
        <?php if (!empty($quizzes)): ?>
            <a class="btn" href="#quizzes">Browse Quizzes</a>
        <?php endif; ?>
        <?php if (!empty($userResults)): ?>
            <a class="btn btn-secondary" href="#history">View History</a>
        <?php endif; ?>
    </div>
</section>

<section id="quizzes" aria-labelledby="quizzes-title">
    <div class="page-title">
        <div>
            <p class="card-kicker">Available now</p>
            <h2 id="quizzes-title">Quizzes</h2>
            <p>Choose a quiz card to begin. Your latest attempt is shown when available.</p>
        </div>
    </div>

    <?php if (empty($quizzes)): ?>
        <div class="empty-state">
            <h3>No quizzes available yet</h3>
            <p>Check back soon for fresh questions.</p>
        </div>
    <?php else: ?>
        <div class="quizzes-grid">
            <?php foreach ($quizzes as $quiz): ?>
                <?php
                $attemptCount = count(array_filter($userResults, function ($r) use ($quiz) {
                    return $r['quiz_id'] == $quiz['id'];
                }));
                ?>
                <article class="quiz-card">
                    <span class="card-kicker">General knowledge</span>
                    <h3><?php echo htmlspecialchars($quiz['title']); ?></h3>
                    <p>Challenge yourself with a focused set of questions and get instant scoring when you finish.</p>

                    <div class="quiz-stats">
                        <?php if (isset($userResultsByQuiz[$quiz['id']])): ?>
                            <span class="score-badge">Last score <?php echo $userResultsByQuiz[$quiz['id']]['score']; ?>%</span>
                            <span class="attempts-badge"><?php echo $attemptCount; ?> attempt<?php echo $attemptCount === 1 ? '' : 's'; ?></span>
                        <?php else: ?>
                            <span class="attempts-badge">Not attempted yet</span>
                            <span class="difficulty-badge">Starter friendly</span>
                        <?php endif; ?>
                    </div>

                    <div class="button-group">
                        <a href="?page=home&action=play&id=<?php echo $quiz['id']; ?>" class="btn">Play Quiz</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<section class="history-section" id="history" aria-labelledby="history-title">
    <div class="page-title">
        <div>
            <p class="card-kicker">Progress</p>
            <h2 id="history-title">Quiz History</h2>
            <p>Recent attempts help you spot where practice is paying off.</p>
        </div>
    </div>

    <?php if (empty($userResults)): ?>
        <div class="empty-state">
            <h3>No attempts yet</h3>
            <p>Start with any quiz above and your results will appear here.</p>
        </div>
    <?php else: ?>
        <div class="table-wrap">
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
                            <td><span class="badge"><?php echo $result['score']; ?>%</span></td>
                            <td><?php echo $result['correct_answers']; ?>/<?php echo $result['total_questions']; ?></td>
                            <td><?php echo date('M d, Y H:i', strtotime($result['attempted_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>
