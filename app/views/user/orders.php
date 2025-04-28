<?php include 'layout.php'; ?>

<div class="user-content">
    <h2>我的订单</h2>
    
    <?php if (!empty($orders)): ?>
        <table class="orders-table">
            <thead>
                <tr>
                    <th>订单号</th>
                    <th>日期</th>
                    <th>商品</th>
                    <th>金额</th>
                    <th>状态</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= date('Y-m-d', strtotime($order['created_at'])) ?></td>
                        <td><?= $order['product_name'] ?></td>
                        <td>¥<?= number_format($order['amount'], 2) ?></td>
                        <td class="status-<?= $order['status'] ?>">
                            <?= $this->getOrderStatusText($order['status']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>暂无订单记录</p>
    <?php endif; ?>
</div>

<style>
    .orders-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }
    .orders-table th, .orders-table td {
        padding: 0.75rem;
        border-bottom: 1px solid #eee;
        text-align: left;
    }
    .orders-table th {
        background-color: #f5f5f5;
    }
    .status-pending {
        color: #f39c12;
    }
    .status-completed {
        color: #27ae60;
    }
    .status-cancelled {
        color: #e74c3c;
    }
</style>
