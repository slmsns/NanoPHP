<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>交易管理</title>
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
                        <a class="nav-link" href="/admin/users">
                            <i class="bi bi-people"></i> 用户管理
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/admin/transactions">
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
                <h4 class="mb-0">交易记录</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="transactionsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>用户</th>
                                <th>类型</th>
                                <th>金额</th>
                                <th>描述</th>
                                <th>时间</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $tx): ?>
                            <tr>
                                <td><?= $tx['id'] ?></td>
                                <td><?= htmlspecialchars($tx['username']) ?></td>
                                <td>
                                    <span class="badge <?= $tx['amount'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                                        <?= $tx['amount'] > 0 ? '收入' : '支出' ?>
                                    </span>
                                </td>
                                <td><?= abs($tx['amount']) ?></td>
                                <td><?= htmlspecialchars($tx['description']) ?></td>
                                <td><?= $tx['created_at'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- 删除确认模态框 -->
    <div class="modal fade" id="deleteTransactionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">确认删除</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>确定要删除这笔交易记录吗？此操作不可撤销。</p>
                    <input type="hidden" id="deleteTransactionId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-danger" id="confirmTransactionDelete">确认删除</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 删除交易记录
        document.querySelectorAll('.delete-transaction').forEach(btn => {
            btn.addEventListener('click', function() {
                const modal = new bootstrap.Modal(document.getElementById('deleteTransactionModal'));
                document.getElementById('deleteTransactionId').value = this.dataset.id;
                modal.show();
            });
        });

        // 确认删除
        document.getElementById('confirmTransactionDelete').addEventListener('click', function() {
            const transactionId = document.getElementById('deleteTransactionId').value;
            
            fetch('/admin/transactions/' + transactionId, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert('交易记录删除成功');
                    location.reload();
                } else {
                    alert(result.message || '删除失败');
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
