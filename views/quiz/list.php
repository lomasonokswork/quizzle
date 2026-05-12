<section class="page-title">
    <div>
        <p class="card-kicker">Administration</p>
        <h1>Quizzes</h1>
        <p>Review quizzes, open their question sets, or create something new.</p>
    </div>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="?page=quiz&action=create" class="btn">New Quiz</a>
    <?php endif; ?>
</section>

<?php if (empty($quizzes)): ?>
    <div class="empty-state">
        <h3>No quizzes available yet</h3>
        <?php if (isset($_SESSION['user_id'])): ?>
            <p><a href="?page=quiz&action=create">Create the first quiz</a> to get started.</p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Created By</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($quizzes as $quiz): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($quiz['title']); ?></strong></td>
                        <td><?php echo htmlspecialchars($quiz['username'] ?? 'Unknown'); ?></td>
                        <td><?php echo date('M d, Y H:i', strtotime($quiz['created_at'])); ?></td>
                        <td>
                            <div class="button-group">
                                <a href="?page=quiz&action=view&id=<?php echo $quiz['id']; ?>" class="btn btn-secondary">View</a>
                                <?php if (isset($_SESSION['permission_level']) && $_SESSION['permission_level'] === 'Admin'): ?>
                                    <a href="?page=quiz&action=delete&id=<?php echo $quiz['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
