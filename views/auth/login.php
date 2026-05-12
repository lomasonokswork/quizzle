<section class="form-page">
    <div class="form-header">
        <p class="card-kicker">Welcome back</p>
        <h1>Login</h1>
        <p>Sign in to continue your quizzes and track your results.</p>
    </div>

    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" autocomplete="username" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" autocomplete="current-password" required>
        </div>

        <button type="submit">Login</button>
    </form>

    <p class="form-note">
        Don't have an account? <a href="?page=register">Register here</a>
    </p>
</section>
