<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>个人中心</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/user">用户中心</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/user/profile">
                            <i class="bi bi-person"></i> 个人资料
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/user/balance">
                            <i class="bi bi-wallet2"></i> 余额管理
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/user/transactions">
                            <i class="bi bi-list-check"></i> 交易记录
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
        <div class="row">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">个人信息</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="bg-light rounded-circle d-inline-block p-4 mb-2">
                                <i class="bi bi-person-fill" style="font-size: 2rem;"></i>
                            </div>
                            <h4><?= htmlspecialchars($user['username']) ?></h4>
                            <p class="text-muted"><?= htmlspecialchars($user['email']) ?></p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                账户余额
                                <span class="badge bg-primary rounded-pill"><?= $user['balance'] ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                注册时间
                                <span><?= $user['created_at'] ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">最近交易</h5>
                        <a href="/transactions" class="btn btn-sm btn-outline-primary">查看全部</a>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($transactions)): ?>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>类型</th>
                                        <th>金额</th>
                                        <th>描述</th>
                                        <th>时间</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transactions as $tx): ?>
                                    <tr>
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
                        <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-wallet2" style="font-size: 2rem;"></i>
                            <p class="mt-2">暂无交易记录</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
