<?php
$title = '新增用户';
ob_start();
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">新增用户</h1>
</div>

<form method="POST" action="/admin/users/store">
    <div class="mb-3">
        <label for="username" class="form-label">用户名</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">邮箱</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">密码</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="mb-3">
        <label for="balance" class="form-label">初始余额</label>
        <input type="number" step="0.01" class="form-control" id="balance" name="balance" value="0">
    </div>
    <button type="submit" class="btn btn-primary">保存</button>
    <a href="/admin/users" class="btn btn-outline-secondary">取消</a>
</form>

<?php
$content = ob_get_clean();
include __DIR__.'/layout.php';
?>
