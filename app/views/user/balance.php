
<?php
$title = '账户余额';
ob_start();
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">账户余额</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#rechargeModal">充值</button>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card user-card">
            <div class="card-body text-center">
                <i class="bi bi-wallet2" style="font-size: 3rem; color: #198754;"></i>
                <h3 class="card-title mt-3">当前余额</h3>
                <p class="display-4"><?= $user['balance'] ?? 0 ?> 元</p>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card user-card">
            <div class="card-body">
                <h5 class="card-title">交易记录</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>时间</th>
                                <th>类型</th>
                                <th>金额</th>
                                <th>状态</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $tx): ?>
                            <tr>
                                <td><?= $tx['created_at'] ?></td>
                                <td><?= $tx['type'] === 'recharge' ? '充值' : '消费' ?></td>
                                <td class="<?= $tx['amount'] > 0 ? 'text-success' : 'text-danger' ?>">
                                    <?= $tx['amount'] > 0 ? '+' : '' ?><?= $tx['amount'] ?> 元
                                </td>
                                <td>
                                    <span class="badge bg-<?= $tx['status'] === 'completed' ? 'success' : 'warning' ?>">
                                        <?= $tx['status'] === 'completed' ? '已完成' : '处理中' ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 充值模态框 -->
<div class="modal fade" id="rechargeModal" tabindex="-1" aria-labelledby="rechargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rechargeModalLabel">账户充值</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="/user/recharge">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">充值金额</label>
                        <input type="number" class="form-control" name="amount" min="10" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">支付方式</label>
                        <select class="form-select" name="payment_method" required>
                            <option value="alipay">支付宝</option>
                            <option value="wechat">微信支付</option>
                            <option value="bank">银行卡</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-primary">确认充值</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__.'/layout.php';
?>
