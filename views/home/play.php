<div class="page-title">
    <h1><?php echo htmlspecialchars($quiz['title']); ?></h1>
    <p class="quiz-info">Total Questions: <strong><?php echo count($questions); ?></strong></p>
</div>

<div class="quiz-container">
    <form method="POST" action="?page=home&action=submit">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="hidden" name="quiz_id" value="<?php echo $quiz['id']; ?>">

        <?php foreach ($questions as $index => $question): ?>
            <div class="question-block">
                <h3>Question <?php echo $index + 1; ?> of <?php echo count($questions); ?></h3>
                <p class="question-text"><?php echo htmlspecialchars($question['question']); ?></p>

                <div class="options">
                    <?php 
                    $variants = [
                        $question['variant_1'],
                        $question['variant_2'],
                        $question['variant_3'],
                        $question['variant_4']
                    ];
                    $variants = array_filter($variants, function($v) { return !empty($v); });
                    shuffle($variants);
                    
                    foreach ($variants as $variant): 
                    ?>
                        <label class="option-label">
                            <input type="radio" name="question_<?php echo $question['id']; ?>" 
                                   value="<?php echo htmlspecialchars($variant); ?>" required>
                            <span><?php echo htmlspecialchars($variant); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="quiz-actions">
            <a href="?page=home" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-success">Submit Quiz</button>
        </div>
    </form>
</div>
