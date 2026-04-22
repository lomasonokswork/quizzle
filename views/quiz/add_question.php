<h1>Add Question to <?php echo htmlspecialchars($quiz['title']); ?></h1>

<form method="POST" class="form-wide">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

    <div class="form-group">
        <label for="question">Question:</label>
        <textarea id="question" name="question" required></textarea>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="variant_1">Variant 1:</label>
            <div class="variant-input-group">
                <input type="text" id="variant_1" name="variant_1" required>
                <label class="variant-correct-label">
                    <input type="radio" name="variant_correct" value="variant_1" required>
                    <span>Correct</span>
                </label>
            </div>
        </div>

        <div class="form-group">
            <label for="variant_2">Variant 2:</label>
            <div class="variant-input-group">
                <input type="text" id="variant_2" name="variant_2" required>
                <label class="variant-correct-label">
                    <input type="radio" name="variant_correct" value="variant_2" required>
                    <span>Correct</span>
                </label>
            </div>
        </div>

        <div class="form-group">
            <label for="variant_3">Variant 3:</label>
            <div class="variant-input-group">
                <input type="text" id="variant_3" name="variant_3" required>
                <label class="variant-correct-label">
                    <input type="radio" name="variant_correct" value="variant_3" required>
                    <span>Correct</span>
                </label>
            </div>
        </div>

        <div class="form-group">
            <label for="variant_4">Variant 4:</label>
            <div class="variant-input-group">
                <input type="text" id="variant_4" name="variant_4" required>
                <label class="variant-correct-label">
                    <input type="radio" name="variant_correct" value="variant_4" required>
                    <span>Correct</span>
                </label>
            </div>
        </div>
    </div>

    <button type="submit">Add Question</button>
</form>

<p style="text-align: center; margin-top: 1rem;">
    <a href="?page=quiz&action=view&id=<?php echo $quiz['id']; ?>">Back to Quiz</a>
</p></content>
<parameter name="filePath">c:\laragon\www\quizzle-1\views\quiz\add_question.php