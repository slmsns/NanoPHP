<?php
$title = '控制面板';
ob_start();
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">控制面板</h1>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">用户总数</h5>
                <p class="card-text display-4"><?= $userCount ?></p>
                <a href="/admin/users" class="text-white">查看详情 <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__.'/layout.php';
?>
