<?php
$title = '控制面板';
ob_start();
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">控制面板</h1>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card user-card">
            <div class="card-body text-center">
                <i class="bi bi-person-circle" style="font-size: 3rem; color: #0d6efd;"></i>
                <h5 class="card-title mt-3"><?= htmlspecialchars($_SESSION['user']['username']) ?></h5>
                <p class="card-text"><?= htmlspecialchars($_SESSION['user']['email']) ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-8 mb-4">
        <div class="card user-card">
            <div class="card-body">
                <h5 class="card-title">账户概览</h5>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-wallet2 me-3" style="font-size: 1.5rem; color: #198754;"></i>
                            <div>
                                <h6 class="mb-0">账户余额</h6>
                                <p class="mb-0 text-muted"><?= $user['balance'] ?? 0 ?> 元</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-check me-3" style="font-size: 1.5rem; color: #fd7e14;"></i>
                            <div>
                                <h6 class="mb-0">注册时间</h6>
                                <p class="mb-0 text-muted"><?= $user['created_at'] ?? '未知' ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__.'/layout.php';
?>
