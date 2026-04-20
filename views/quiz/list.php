<div class="page-title">
    <h1>Quizzes</h1>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="?page=quiz&action=create" class="btn btn-success">+ New Quiz</a>
    <?php endif; ?>
</div>

<?php if (empty($quizzes)): ?>
    <p>No quizzes available yet. <?php if (isset($_SESSION['user_id'])): ?><a href="?page=quiz&action=create">Create
                one!</a><?php endif; ?></p>
<?php else: ?>
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
                    <td><?php echo htmlspecialchars($quiz['title']); ?></td>
                    <td><?php echo htmlspecialchars($quiz['username'] ?? 'Unknown'); ?></td>
                    <td><?php echo date('M d, Y H:i', strtotime($quiz['created_at'])); ?></td>
                    <td>
                        <div class="button-group">
                            <a href="?page=quiz&action=view&id=<?php echo $quiz['id']; ?>" class="btn">View</a>
                            <?php if (isset($_SESSION['permission_level']) && $_SESSION['permission_level'] === 'Admin'): ?>
                                <a href="?page=quiz&action=delete&id=<?php echo $quiz['id']; ?>" class="btn btn-danger"
                                    onclick="return confirm('Are you sure?');">Delete</a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>