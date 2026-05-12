<section class="form-page-wide">
    <div class="form-header">
        <p class="card-kicker">Question builder</p>
        <h1>Edit Question</h1>
        <p>Update the prompt, variants, and the correct answer.</p>
    </div>

    <form method="POST" class="form-wide">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

        <div class="form-group">
            <label for="question">Question</label>
            <textarea id="question" name="question" required><?php echo htmlspecialchars($question['question']); ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="variant_1">Variant 1</label>
                <div class="variant-input-group">
                    <input type="text" id="variant_1" name="variant_1" required value="<?php echo htmlspecialchars($question['variant_1']); ?>">
                    <label class="variant-correct-label">
                        <input type="radio" name="variant_correct" value="variant_1" <?php echo ($question['variant_correct'] === $question['variant_1']) ? 'checked' : ''; ?> required>
                        <span>Correct</span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="variant_2">Variant 2</label>
                <div class="variant-input-group">
                    <input type="text" id="variant_2" name="variant_2" required value="<?php echo htmlspecialchars($question['variant_2']); ?>">
                    <label class="variant-correct-label">
                        <input type="radio" name="variant_correct" value="variant_2" <?php echo ($question['variant_correct'] === $question['variant_2']) ? 'checked' : ''; ?> required>
                        <span>Correct</span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="variant_3">Variant 3</label>
                <div class="variant-input-group">
                    <input type="text" id="variant_3" name="variant_3" required value="<?php echo htmlspecialchars($question['variant_3']); ?>">
                    <label class="variant-correct-label">
                        <input type="radio" name="variant_correct" value="variant_3" <?php echo ($question['variant_correct'] === $question['variant_3']) ? 'checked' : ''; ?> required>
                        <span>Correct</span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="variant_4">Variant 4</label>
                <div class="variant-input-group">
                    <input type="text" id="variant_4" name="variant_4" required value="<?php echo htmlspecialchars($question['variant_4']); ?>">
                    <label class="variant-correct-label">
                        <input type="radio" name="variant_correct" value="variant_4" <?php echo ($question['variant_correct'] === $question['variant_4']) ? 'checked' : ''; ?> required>
                        <span>Correct</span>
                    </label>
                </div>
            </div>
        </div>

        <button type="submit">Update Question</button>
    </form>

    <p class="form-note">
        <a href="?page=quiz&action=view&id=<?php echo $quizId; ?>">Back to Quiz</a>
    </p>
</section>
