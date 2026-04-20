<?php
$mode = $_GET['action'] ?? 'view';
$isEditMode = $mode === 'edit' && isset($_GET['id']);
$isAddMode = $mode === 'add';

if ($isAddMode && empty($quiz)) {
    echo '<p>Invalid quiz</p>';
    echo '<a href="?page=quiz&action=list">Back to Quizzes</a>';
    exit;
}

if ($isEditMode && !isset($question)) {
    echo '<p>Invalid question</p>';
    echo '<a href="?page=quiz&action=list">Back to Quizzes</a>';
    exit;
}
?>

<?php if (!$isAddMode && !$isEditMode): ?>
    <div class="page-title">
        <h1><?php echo htmlspecialchars($quiz['title']); ?></h1>
        <a href="?page=quiz&action=list" class="btn btn-secondary">Back to Quizzes</a>
    </div>

    <h2>Questions (<?php echo count($questions); ?>)</h2>
<?php endif; ?>

<?php if ($isEditMode): ?>
    <h1>Edit Question</h1>
<?php elseif ($isAddMode): ?>
    <h1>Add Question to <?php echo htmlspecialchars($quiz['title'] ?? ''); ?></h1>
<?php endif; ?>

<?php if ($isAddMode || $isEditMode): ?>
    <form method="POST" class="form-wide">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

        <div class="form-group">
            <label for="question">Question:</label>
            <textarea id="question" name="question"
                required><?php echo $isEditMode ? htmlspecialchars($question['question']) : ''; ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="variant_1">Variant 1:</label>
                <div class="variant-input-group">
                    <input type="text" id="variant_1" name="variant_1" required
                        value="<?php echo $isEditMode ? htmlspecialchars($question['variant_1']) : ''; ?>">
                    <label class="variant-correct-label">
                        <input type="radio" name="variant_correct" value="variant_1" 
                            <?php echo ($isEditMode && $question['variant_correct'] === $question['variant_1']) ? 'checked' : ''; ?> required>
                        <span>Correct</span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="variant_2">Variant 2:</label>
                <div class="variant-input-group">
                    <input type="text" id="variant_2" name="variant_2" required
                        value="<?php echo $isEditMode ? htmlspecialchars($question['variant_2']) : ''; ?>">
                    <label class="variant-correct-label">
                        <input type="radio" name="variant_correct" value="variant_2"
                            <?php echo ($isEditMode && $question['variant_correct'] === $question['variant_2']) ? 'checked' : ''; ?> required>
                        <span>Correct</span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="variant_3">Variant 3:</label>
                <div class="variant-input-group">
                    <input type="text" id="variant_3" name="variant_3" required
                        value="<?php echo $isEditMode ? htmlspecialchars($question['variant_3']) : ''; ?>">
                    <label class="variant-correct-label">
                        <input type="radio" name="variant_correct" value="variant_3"
                            <?php echo ($isEditMode && $question['variant_correct'] === $question['variant_3']) ? 'checked' : ''; ?> required>
                        <span>Correct</span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="variant_4">Variant 4:</label>
                <div class="variant-input-group">
                    <input type="text" id="variant_4" name="variant_4" required
                        value="<?php echo $isEditMode ? htmlspecialchars($question['variant_4']) : ''; ?>">
                    <label class="variant-correct-label">
                        <input type="radio" name="variant_correct" value="variant_4"
                            <?php echo ($isEditMode && $question['variant_correct'] === $question['variant_4']) ? 'checked' : ''; ?> required>
                        <span>Correct</span>
                    </label>
                </div>
            </div>
        </div>

        <button type="submit"><?php echo $isEditMode ? 'Update Question' : 'Add Question'; ?></button>
    </form>

    <p style="text-align: center; margin-top: 1rem;">
        <a href="?page=quiz&action=view&id=<?php echo $isEditMode ? $quizId : $_GET['quiz_id']; ?>">Back to Quiz</a>
    </p>
<?php elseif (!$isAddMode && !$isEditMode): ?>
    <?php if (empty($questions)): ?>
        <p>No questions yet.</p>
    <?php else: ?>
        <?php foreach ($questions as $q): ?>
            <div class="question-item">
                <h3>Q: <?php echo htmlspecialchars($q['question']); ?></h3>
                <div class="question-variants">
                    <strong>Variants:</strong><br>
                    1. <?php echo htmlspecialchars($q['variant_1']); ?><br>
                    2. <?php echo htmlspecialchars($q['variant_2']); ?><br>
                    3. <?php echo htmlspecialchars($q['variant_3']); ?><br>
                    4. <?php echo htmlspecialchars($q['variant_4']); ?><br>
                    <strong style="color: green;">Correct: <?php echo htmlspecialchars($q['variant_correct']); ?></strong>
                </div>
                <div class="action-buttons">
                    <a href="?page=question&action=edit&id=<?php echo $q['id']; ?>" class="btn">Edit</a>
                    <a href="?page=question&action=delete&id=<?php echo $q['id']; ?>" class="btn btn-danger"
                        onclick="return confirm('Are you sure?');">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <h2>Add New Question</h2>
    <a href="?page=question&action=add&quiz_id=<?php echo $quiz['id']; ?>" class="btn btn-success">+ Add Question</a>
<?php endif; ?>