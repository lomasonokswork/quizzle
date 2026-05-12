<section class="form-page">
    <div class="form-header">
        <p class="card-kicker">Create account</p>
        <h1>Register</h1>
        <p>Join Quizzle to save quiz attempts and build a history of your scores.</p>
    </div>

    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" autocomplete="username" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" autocomplete="new-password" required>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" autocomplete="new-password" required>
        </div>

        <button type="submit">Register</button>
    </form>

    <p class="form-note">
        Already have an account? <a href="?page=login">Login here</a>
    </p>
</section>
