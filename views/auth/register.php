<h1 style="text-align: center; margin-bottom: 2rem;">Register</h1>

<form method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
    </div>

    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>

    <div class="form-group">
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
    </div>

    <button type="submit">Register</button>
</form>

<p style="text-align: center; margin-top: 1rem;">
    Already have an account? <a href="?page=login">Login here</a>
</p>