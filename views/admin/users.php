<div class="page-title">
    <h1>User Management</h1>
    <a href="?page=quiz&action=list" class="btn btn-secondary">Back to Quizzes</a>
</div>

<?php if (empty($users)): ?>
    <p>No users found.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Permission Level</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td>
                        <?php echo htmlspecialchars($user['username']); ?>
                        <?php if ($user['id'] == $_SESSION['user_id']): ?>
                            <span style="color: #27ae60; font-size: 0.85rem;"> (You)</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span
                            style="background-color: <?php echo $user['permission_level'] === 'Admin' ? '#e74c3c' : '#3498db'; ?>; color: white; padding: 0.25rem 0.5rem; border-radius: 3px;">
                            <?php echo htmlspecialchars($user['permission_level']); ?>
                        </span>
                    </td>
                    <td><?php echo date('M d, Y H:i', strtotime($user['created_at'])); ?></td>
                    <td>
                        <div class="button-group">
                            <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                <?php if ($user['permission_level'] === 'User'): ?>
                                    <a href="?page=admin&action=makeadmin&id=<?php echo $user['id']; ?>" class="btn btn-success"
                                        onclick="return confirm('Make this user an Admin?');">Make Admin</a>
                                <?php else: ?>
                                    <a href="?page=admin&action=removeadmin&id=<?php echo $user['id']; ?>" class="btn btn-danger"
                                        onclick="return confirm('Remove admin privileges?');">Remove Admin</a>
                                <?php endif; ?>
                            <?php else: ?>
                                <span style="color: #95a5a6;">Your account</span>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>