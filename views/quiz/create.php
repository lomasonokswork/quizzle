<h1 style="text-align: center; margin-bottom: 2rem;">Create New Quiz</h1>

<form method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

    <div class="form-group">
        <label for="title">Quiz Title (max 30 characters):</label>
        <input type="text" id="title" name="title" maxlength="30" required>
    </div>

    <button type="submit">Create Quiz</button>
</form>

<p style="text-align: center; margin-top: 1rem;">
    <a href="?page=quiz&action=list">Back to Quizzes</a>
</p>