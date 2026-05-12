<section class="form-page">
    <div class="form-header">
        <p class="card-kicker">New quiz</p>
        <h1>Create Quiz</h1>
        <p>Name your quiz. You can add questions after it is created.</p>
    </div>

    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

        <div class="form-group">
            <label for="title">Quiz Title</label>
            <input type="text" id="title" name="title" maxlength="30" required>
        </div>

        <button type="submit">Create Quiz</button>
    </form>

    <p class="form-note">
        <a href="?page=quiz&action=list">Back to Quizzes</a>
    </p>
</section>
