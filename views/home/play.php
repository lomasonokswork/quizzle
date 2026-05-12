<section class="page-title">
    <div>
        <p class="card-kicker">Quiz in progress</p>
        <h1><?php echo htmlspecialchars($quiz['title']); ?></h1>
        <p><?php echo count($questions); ?> questions. Select an answer, submit it, and move through the set at your pace.</p>
    </div>
    <a href="?page=home" class="btn btn-secondary">Exit Quiz</a>
</section>

<section class="quiz-container" aria-labelledby="quiz-title">
    <form method="POST" action="?page=home&action=submit" id="quizForm" data-quiz-form>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="hidden" name="quiz_id" value="<?php echo $quiz['id']; ?>">

        <div class="progress-wrapper">
            <div class="progress-topline">
                <span id="quiz-title">Question progress</span>
                <span id="progressText">0 / <?php echo count($questions); ?></span>
            </div>
            <div class="progress" aria-hidden="true">
                <div class="progress-bar" id="progressBar" style="width:0%"></div>
            </div>
        </div>

        <?php foreach ($questions as $index => $question): ?>
            <article class="question-block" data-index="<?php echo $index; ?>">
                <p class="question-number">Question <?php echo $index + 1; ?> of <?php echo count($questions); ?></p>
                <h2 class="question-text"><?php echo htmlspecialchars($question['question']); ?></h2>

                <div class="options" role="radiogroup" aria-label="Answers for question <?php echo $index + 1; ?>">
                    <?php
                    $variants = [
                        $question['variant_1'],
                        $question['variant_2'],
                        $question['variant_3'],
                        $question['variant_4']
                    ];
                    $variants = array_filter($variants, function ($v) {
                        return !empty($v);
                    });
                    shuffle($variants);

                    foreach ($variants as $variant):
                    ?>
                        <label class="option-label">
                            <input type="radio" name="visible_question_<?php echo $question['id']; ?>" value="<?php echo htmlspecialchars($variant); ?>">
                            <span><?php echo htmlspecialchars($variant); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>

                <input type="hidden" name="question_<?php echo $question['id']; ?>" id="answer_<?php echo $question['id']; ?>" value="">

                <div class="quiz-actions">
                    <a href="?page=home" class="btn btn-secondary">Cancel</a>
                    <button type="button" class="btn submit-answer">Submit Answer</button>
                </div>
            </article>
        <?php endforeach; ?>

        <div class="finish-actions">
            <button type="submit" class="btn" id="finishBtn" hidden>Finish Quiz</button>
        </div>
    </form>
</section>
