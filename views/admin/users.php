<section class="page-title">
    <div>
        <p class="card-kicker">Admin panel</p>
        <h1>User Management</h1>
        <p>Manage account permission levels for Quizzle users.</p>
    </div>
    <a href="?page=quiz&action=list" class="btn btn-secondary">Back to Quizzes</a>
</section>

<?php if (empty($users)): ?>
    <div class="empty-state">
        <h3>No users found</h3>
        <p>New users will appear here after registration.</p>
    </div>
<?php else: ?>
    <div class="table-wrap">
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
                            <strong><?php echo htmlspecialchars($user['username']); ?></strong>
                            <?php if ($user['id'] == $_SESSION['user_id']): ?>
                                <span class="badge badge-success">You</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="role-badge <?php echo $user['permission_level'] === 'Admin' ? 'role-admin' : 'role-user'; ?>">
                                <?php echo htmlspecialchars($user['permission_level']); ?>
                            </span>
                        </td>
                        <td><?php echo date('M d, Y H:i', strtotime($user['created_at'])); ?></td>
                        <td>
                            <div class="button-group">
                                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                    <?php if ($user['permission_level'] === 'User'): ?>
                                        <a href="?page=admin&action=makeadmin&id=<?php echo $user['id']; ?>" class="btn btn-secondary" onclick="return confirm('Make this user an Admin?');">Make Admin</a>
                                    <?php else: ?>
                                        <a href="?page=admin&action=removeadmin&id=<?php echo $user['id']; ?>" class="btn btn-danger" onclick="return confirm('Remove admin privileges?');">Remove Admin</a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted">Your account</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
