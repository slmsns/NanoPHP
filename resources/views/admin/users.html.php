<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户管理</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/admin/dashboard">管理控制台</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/dashboard">
                            <i class="bi bi-speedometer2"></i> 仪表盘
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/admin/users">
                            <i class="bi bi-people"></i> 用户管理
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/transactions">
                            <i class="bi bi-cash-stack"></i> 交易管理
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="nav-link">欢迎，<?= $admin['username'] ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/logout">
                            <i class="bi bi-box-arrow-right"></i> 退出
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">用户列表</h4>
                    <button class="btn btn-primary" id="addUserBtn">
                        <i class="bi bi-plus-lg"></i> 添加用户
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="usersTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>用户名</th>
                                <th>邮箱</th>
                                <th>余额</th>
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
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary edit-user" 
                                            data-id="<?= $user['id'] ?>"
                                            data-username="<?= htmlspecialchars($user['username']) ?>"
                                            data-email="<?= htmlspecialchars($user['email']) ?>"
                                            data-balance="<?= $user['balance'] ?>">
                                        <i class="bi bi-pencil"></i> 编辑
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger delete-user" 
                                            data-id="<?= $user['id'] ?>">
                                        <i class="bi bi-trash"></i> 删除
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- 用户编辑模态框 -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">编辑用户</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <input type="hidden" name="id" id="userId" value="">
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
                            <input type="password" class="form-control" id="password" name="password" placeholder="留空则不修改密码">
                        </div>
                        <div class="mb-3">
                            <label for="balance" class="form-label">余额</label>
                            <input type="number" class="form-control" id="balance" name="balance" step="0.01" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="saveUserBtn">保存</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // 用户管理交互逻辑
    document.addEventListener('DOMContentLoaded', function() {
        const userModal = new bootstrap.Modal('#userModal');
        
        // 添加用户按钮
        document.getElementById('addUserBtn').addEventListener('click', function() {
            document.getElementById('modalTitle').textContent = '添加用户';
            document.getElementById('userForm').reset();
            document.getElementById('userId').value = '';
            userModal.show();
        });

        // 编辑用户按钮
        document.querySelectorAll('.edit-user').forEach(btn => {
            btn.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                const row = this.closest('tr');
                
                document.getElementById('modalTitle').textContent = '编辑用户';
                document.getElementById('userId').value = userId;
                document.getElementById('username').value = row.cells[1].textContent;
                document.getElementById('email').value = row.cells[2].textContent;
                document.getElementById('balance').value = row.cells[3].textContent;
                
                userModal.show();
            });
        });

        // 保存用户
        document.getElementById('saveUserBtn').addEventListener('click', function() {
            const form = document.getElementById('userForm');
            // 添加用户时不发送id，编辑用户时发送
            const data = {
                username: form.username.value.trim(),
                email: form.email.value.trim(),
                password: form.password.value.trim(),
                balance: parseFloat(form.balance.value)
            };
            
            // 如果是编辑用户，添加id参数
            if (form.id.value.trim()) {
                data.id = form.id.value.trim();
            }

            // 添加用户时密码必填，编辑用户时可选
            const isAddUser = !data.id;
            if (!data.username || !data.email || isNaN(data.balance) || (isAddUser && !data.password)) {
                alert('请填写所有必填字段' + (isAddUser ? '（密码必填）' : ''));
                return;
            }

            // 确保发送正确的JSON数据
            const requestOptions = {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            };
            
            fetch('/admin/users', requestOptions)
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    location.reload();
                } else {
                    alert(result.message);
                }
            })
            .catch(error => {
                alert('操作失败: ' + error.message);
            });
        });

        // 删除用户
        document.querySelectorAll('.delete-user').forEach(btn => {
            btn.addEventListener('click', function() {
                if (confirm('确定要删除此用户吗？')) {
                    const userId = this.getAttribute('data-id');
                    
                    fetch('/admin/users?id=' + userId, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            location.reload();
                        } else {
                            alert(result.message);
                        }
                    });
                }
            });
        });
    });
    </script>
</body>
</html>
