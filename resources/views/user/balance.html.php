<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>余额管理</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/user/profile">用户中心</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/user/profile">
                            <i class="bi bi-person"></i> 个人资料
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/user/balance">
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
                        <a class="nav-link" href="/user/logout">
                            <i class="bi bi-box-arrow-right"></i> 退出
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">账户余额</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="display-4 mb-3">¥<?= $user['balance'] ?></div>
                        <div class="d-flex justify-content-around">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#depositModal">
                                <i class="bi bi-plus-lg"></i> 充值
                            </button>
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#withdrawModal">
                                <i class="bi bi-dash-lg"></i> 提现
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">最近交易</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($transactions)): ?>
                        <div class="list-group">
                            <?php foreach ($transactions as $tx): ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <span><?= htmlspecialchars($tx['description']) ?></span>
                                    <span class="<?= $tx['amount'] > 0 ? 'text-success' : 'text-danger' ?>">
                                        <?= $tx['amount'] > 0 ? '+' : '' ?><?= $tx['amount'] ?>
                                    </span>
                                </div>
                                <small class="text-muted"><?= $tx['created_at'] ?></small>
                            </div>
                            <?php endforeach; ?>
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

    <!-- 充值模态框 -->
    <div class="modal fade" id="depositModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">账户充值</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="depositForm">
                        <div class="mb-3">
                            <label for="depositAmount" class="form-label">充值金额</label>
                            <input type="number" class="form-control" id="depositAmount" name="amount" min="1" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="depositMethod" class="form-label">支付方式</label>
                            <select class="form-select" id="depositMethod" name="method" required>
                                <option value="alipay">支付宝</option>
                                <option value="wechat">微信支付</option>
                                <option value="bank">银行卡</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="confirmDeposit">确认充值</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 提现模态框 -->
    <div class="modal fade" id="withdrawModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">账户提现</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="withdrawForm">
                        <div class="mb-3">
                            <label for="withdrawAmount" class="form-label">提现金额</label>
                            <input type="number" class="form-control" id="withdrawAmount" name="amount" 
                                   min="1" max="<?= $user['balance'] ?>" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="bankAccount" class="form-label">银行账号</label>
                            <input type="text" class="form-control" id="bankAccount" name="account" required>
                        </div>
                        <div class="mb-3">
                            <label for="bankName" class="form-label">开户银行</label>
                            <input type="text" class="form-control" id="bankName" name="bank" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="confirmWithdraw">确认提现</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 充值功能
        document.getElementById('confirmDeposit').addEventListener('click', function() {
            const amount = document.getElementById('depositAmount').value;
            const method = document.getElementById('depositMethod').value;
            
            if (!amount || amount <= 0) {
                alert('请输入有效的充值金额');
                return;
            }
            
            fetch('/balance/deposit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    amount: parseFloat(amount),
                    method: method
                })
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert('充值成功');
                    location.reload();
                } else {
                    alert(result.message || '充值失败');
                }
            })
            .catch(error => {
                alert('请求失败: ' + error.message);
            });
        });

        // 提现功能
        document.getElementById('confirmWithdraw').addEventListener('click', function() {
            const amount = document.getElementById('withdrawAmount').value;
            const account = document.getElementById('bankAccount').value;
            const bank = document.getElementById('bankName').value;
            
            if (!amount || amount <= 0) {
                alert('请输入有效的提现金额');
                return;
            }
            
            if (parseFloat(amount) > <?= $user['balance'] ?>) {
                alert('提现金额不能超过账户余额');
                return;
            }
            
            if (!account || !bank) {
                alert('请输入完整的银行信息');
                return;
            }
            
            fetch('/balance/withdraw', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    amount: parseFloat(amount),
                    account: account,
                    bank: bank
                })
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert('提现申请已提交');
                    location.reload();
                } else {
                    alert(result.message || '提现失败');
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
