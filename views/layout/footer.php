    </main>

    <footer class="site-footer">
        <div class="footer-inner">
            <div>
                <div class="footer-brand">Quizzle</div>
                <p class="footer-copy">A focused place to build, take, and improve quizzes.</p>
            </div>
            <div class="footer-links" aria-label="Footer links">
                <a href="?page=home">Home</a>
                <?php if (isset($_SESSION['permission_level']) && $_SESSION['permission_level'] === 'Admin'): ?>
                    <a href="?page=quiz&action=list">Manage Quizzes</a>
                    <a href="?page=admin&action=users">Admin Panel</a>
                <?php endif; ?>
            </div>
            <p class="footer-copy">&copy; <?php echo date('Y'); ?> Quizzle. Learn a little sharper.</p>
        </div>
    </footer>

    <script src="public/js/main.js"></script>
</body>

</html>
