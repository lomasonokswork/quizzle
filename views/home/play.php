<div class="page-title">
    <h1><?php echo htmlspecialchars($quiz['title']); ?></h1>
    <p class="quiz-info">Total Questions: <strong><?php echo count($questions); ?></strong></p>
</div>

<div class="quiz-container">
    <form method="POST" action="?page=home&action=submit" id="quizForm">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="hidden" name="quiz_id" value="<?php echo $quiz['id']; ?>">

        <div class="progress-wrapper">
            <div class="progress-label">Progress</div>
            <div class="progress">
                <div class="progress-bar" id="progressBar" style="width:0%"></div>
            </div>
            <div class="progress-text" id="progressText">0 / <?php echo count($questions); ?></div>
        </div>

        <?php foreach ($questions as $index => $question): ?>
            <div class="question-block" data-index="<?php echo $index; ?>">
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
                            <input type="radio" name="visible_question_<?php echo $question['id']; ?>" 
                                   value="<?php echo htmlspecialchars($variant); ?>">
                            <span><?php echo htmlspecialchars($variant); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>

                <input type="hidden" name="answers[<?php echo $question['id']; ?>]" id="answer_<?php echo $question['id']; ?>" value="">

                <div class="quiz-actions">
                    <a href="?page=home" class="btn btn-secondary">Cancel</a>
                    <button type="button" class="btn btn-primary submit-answer">Submit Answer</button>
                </div>
            </div>
        <?php endforeach; ?>

        <div style="text-align:center; margin-top:18px;">
            <button type="submit" class="btn btn-success" id="finishBtn" style="display:none;">Finish Quiz</button>
        </div>
    </form>

    <script>
    (function(){
        const questionBlocks = Array.from(document.querySelectorAll('.question-block'));
        const total = questionBlocks.length;
        let current = 0;

        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');
        const finishBtn = document.getElementById('finishBtn');

        function showIndex(i){
            questionBlocks.forEach((el, idx) => {
                el.style.display = idx === i ? 'block' : 'none';
            });
            updateProgress();
        }

        function updateProgress(){
            const answered = questionBlocks.reduce((count, el) => {
                const hidden = el.querySelector('input[type="hidden"]');
                return count + (hidden && hidden.value ? 1 : 0);
            }, 0);
            const pct = Math.round((answered / total) * 100);
            progressBar.style.width = pct + '%';
            progressText.textContent = answered + ' / ' + total;

            // show finish button when all answered
            if(answered === total){
                finishBtn.style.display = 'inline-block';
            } else {
                finishBtn.style.display = 'none';
            }
        }

        // bind submit-answer buttons
        questionBlocks.forEach((el, idx) => {
            const submitBtn = el.querySelector('.submit-answer');
            submitBtn.addEventListener('click', function(){
                const radio = el.querySelector('input[type="radio"]:checked');
                if(!radio){
                    alert('Please select an answer before submitting.');
                    return;
                }
                const hidden = el.querySelector('input[type="hidden"]');
                hidden.value = radio.value;
                updateProgress();
                // advance to next unanswered question if any
                let next = null;
                for(let i = idx + 1; i < total; i++){
                    const h = questionBlocks[i].querySelector('input[type="hidden"]');
                    if(!h.value){ next = i; break; }
                }
                if(next === null){
                    for(let i = 0; i < idx; i++){
                        const h = questionBlocks[i].querySelector('input[type="hidden"]');
                        if(!h.value){ next = i; break; }
                    }
                }
                if(next !== null){
                    current = next;
                    showIndex(current);
                } else {
                    // all answered
                    updateProgress();
                    // show finish button and keep current hidden
                }
            });
        });

        // allow pressing Enter to submit answer on radio selection (optional)
        document.querySelectorAll('.options').forEach(opt => {
            opt.addEventListener('keydown', (e) => {
                if(e.key === 'Enter'){
                    const parent = opt.closest('.question-block');
                    const btn = parent.querySelector('.submit-answer');
                    if(btn) btn.click();
                }
            });
        });

        showIndex(current);
    })();
    </script>
</div>
