<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>编辑资料</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/profile">用户中心</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/profile">
                            <i class="bi bi-person"></i> 个人资料
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/profile/edit">
                            <i class="bi bi-pencil"></i> 编辑资料
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/balance">
                            <i class="bi bi-wallet2"></i> 余额管理
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="nav-link">欢迎，<?= $user['username'] ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">
                            <i class="bi bi-box-arrow-right"></i> 退出
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">编辑个人资料</h4>
                    </div>
                    <div class="card-body">
                        <form id="profileForm" action="/profile/update" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">用户名</label>
                                <input type="text" class="form-control" id="username" name="username" 
                                       value="<?= htmlspecialchars($user['username']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">邮箱</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= htmlspecialchars($user['email']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="current_password" class="form-label">当前密码</label>
                                <input type="password" class="form-control" id="current_password" 
                                       name="current_password" placeholder="输入当前密码以确认更改">
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">新密码</label>
                                <input type="password" class="form-control" id="new_password" 
                                       name="new_password" placeholder="留空则不修改密码">
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">确认新密码</label>
                                <input type="password" class="form-control" id="confirm_password" 
                                       name="confirm_password" placeholder="再次输入新密码">
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">保存更改</button>
                                <a href="/profile" class="btn btn-outline-secondary">取消</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('profileForm');
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (newPassword && newPassword !== confirmPassword) {
                alert('新密码与确认密码不匹配');
                return;
            }
            
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert('资料更新成功');
                    window.location.href = '/profile';
                } else {
                    alert(result.message || '更新失败');
                }
            })
            .catch(error => {
                alert('请求失败: ' + error.message);
            });
        });
    });
    </script>
</body>
</html>
