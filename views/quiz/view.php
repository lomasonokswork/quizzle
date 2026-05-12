<section class="page-title">
    <div>
        <p class="card-kicker">Question set</p>
        <h1><?php echo htmlspecialchars($quiz['title']); ?></h1>
        <p><?php echo count($questions); ?> question<?php echo count($questions) === 1 ? '' : 's'; ?> in this quiz.</p>
    </div>
    <div class="title-actions">
        <a href="?page=question&action=add&quiz_id=<?php echo $quiz['id']; ?>" class="btn">Add Question</a>
        <a href="?page=quiz&action=list" class="btn btn-secondary">Back to Quizzes</a>
    </div>
</section>

<section class="questions-section" aria-labelledby="questions-title">
    <h2 id="questions-title">Questions</h2>

    <?php if (empty($questions)): ?>
        <div class="empty-state">
            <h3>No questions yet</h3>
            <p>Add a first question to make this quiz playable.</p>
        </div>
    <?php else: ?>
        <?php foreach ($questions as $q): ?>
            <article class="question-item">
                <p class="question-number">Question</p>
                <h3><?php echo htmlspecialchars($q['question']); ?></h3>
                <div class="question-variants">
                    <ul class="variant-list">
                        <li><?php echo htmlspecialchars($q['variant_1']); ?></li>
                        <li><?php echo htmlspecialchars($q['variant_2']); ?></li>
                        <li><?php echo htmlspecialchars($q['variant_3']); ?></li>
                        <li><?php echo htmlspecialchars($q['variant_4']); ?></li>
                        <li class="correct-answer">Correct: <?php echo htmlspecialchars($q['variant_correct']); ?></li>
                    </ul>
                </div>
                <div class="button-group">
                    <a href="?page=question&action=edit&id=<?php echo $q['id']; ?>" class="btn btn-secondary">Edit</a>
                    <a href="?page=question&action=delete&id=<?php echo $q['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                </div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</section>
