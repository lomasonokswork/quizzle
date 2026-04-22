<div class="page-title">
    <h1><?php echo htmlspecialchars($quiz['title']); ?></h1>
    <a href="?page=quiz&action=list" class="btn btn-secondary">Back to Quizzes</a>
</div>

<h2>Questions (<?php echo count($questions); ?>)</h2>

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
                <a href="?page=question&action=delete&id=<?php echo $q['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<h2>Add New Question</h2>
<a href="?page=question&action=add&quiz_id=<?php echo $quiz['id']; ?>" class="btn btn-success">+ Add Question</a>