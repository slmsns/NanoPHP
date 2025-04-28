<?php
$title = '用户管理';
ob_start();
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">用户管理</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="/admin/users/create" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-plus-lg"></i> 新增用户
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>用户名</th>
                <th>邮箱</th>
                <th>余额</th>
                <th>注册时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= $user['balance'] ?></td>
                <td><?= $user['created_at'] ?></td>
                <td>
                    <a href="/admin/users/edit/<?= $user['id'] ?>" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i> 编辑
                    </a>
                    <button onclick="confirmDelete(<?= $user['id'] ?>)" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-trash"></i> 删除
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function confirmDelete(userId) {
    if (confirm('确定要删除这个用户吗？')) {
        window.location.href = '/admin/users/delete/' + userId;
    }
}
</script>

<?php
$content = ob_get_clean();
include __DIR__.'/layout.php';
?>
