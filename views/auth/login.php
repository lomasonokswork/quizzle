<h1 style="text-align: center; margin-bottom: 2rem;">Login</h1>

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

    <button type="submit">Login</button>
</form>

<p style="text-align: center; margin-top: 1rem;">
    Don't have an account? <a href="?page=register">Register here</a>
</p>