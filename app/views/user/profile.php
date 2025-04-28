<?php
$title = '个人资料';
ob_start();
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">个人资料</h1>
    <button class="btn btn-primary" onclick="enableEdit()">编辑资料</button>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card user-card mb-4">
            <div class="card-body">
                <h5 class="card-title">基本信息</h5>
                <form id="profileForm" method="POST" action="/user/update_profile">
                    <div class="mb-3">
                        <label class="form-label">用户名</label>
                        <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($user['username']) ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">邮箱</label>
                        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">注册时间</label>
                        <input type="text" class="form-control" value="<?= $user['created_at'] ?>" disabled>
                    </div>
                    <button type="submit" class="btn btn-primary" id="saveBtn" style="display: none;">保存更改</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="cancelEdit()" id="cancelBtn" style="display: none;">取消</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card user-card">
            <div class="card-body">
                <h5 class="card-title">安全设置</h5>
                <div class="mb-3">
                    <label class="form-label">密码</label>
                    <a href="/user/change_password" class="btn btn-outline-primary w-100">修改密码</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function enableEdit() {
    document.querySelectorAll('#profileForm input').forEach(input => {
        if(input.name !== 'created_at') {
            input.disabled = false;
        }
    });
    document.getElementById('saveBtn').style.display = 'inline-block';
    document.getElementById('cancelBtn').style.display = 'inline-block';
    document.querySelector('button[onclick="enableEdit()"]').style.display = 'none';
}

function cancelEdit() {
    document.querySelectorAll('#profileForm input').forEach(input => {
        input.disabled = true;
    });
    document.getElementById('saveBtn').style.display = 'none';
    document.getElementById('cancelBtn').style.display = 'none';
    document.querySelector('button[onclick="enableEdit()"]').style.display = 'inline-block';
    // 这里可以添加重置表单值的逻辑
}
</script>

<?php
$content = ob_get_clean();
include __DIR__.'/layout.php';
?>
