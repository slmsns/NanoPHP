<h2>编辑用户</h2>
<form method="post" action="/admin/users/edit/<?= $user['id'] ?>">
    <div>
        <label for="username">用户名:</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
    </div>
    <div>
        <label for="email">邮箱:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
    </div>
    <div>
        <label for="balance">余额:</label>
        <input type="number" id="balance" name="balance" step="0.01" value="<?= $user['balance'] ?>" required>
    </div>
    <div>
        <label for="is_admin">管理员:</label>
        <input type="checkbox" id="is_admin" name="is_admin" value="1" <?= $user['is_admin'] ? 'checked' : '' ?>>
    </div>
    <button type="submit">保存</button>
</form>
