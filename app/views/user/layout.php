<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户中心 - <?= $title ?? '我的账户' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            padding-top: 56px;
            background-color: #f8f9fa;
        }
        .user-sidebar {
            position: fixed;
            top: 56px;
            bottom: 0;
            left: 0;
            width: 250px;
            padding: 20px 0;
            background-color: #fff;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, .075);
        }
        .user-content {
            margin-left: 250px;
            padding: 20px;
        }
        .user-card {
            border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .15);
        }
        .nav-link {
            color: #495057;
            padding: 10px 20px;
        }
        .nav-link.active {
            color: #0d6efd;
            background-color: rgba(13, 110, 253, .1);
        }
        .nav-link:hover {
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/user/dashboard">用户中心</a>
            <div class="d-flex">
                <span class="text-white me-3">欢迎，<?= $_SESSION['user']['username'] ?? '用户' ?></span>
                <a href="/user/logout" class="btn btn-outline-light">退出</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block user-sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/user/dashboard') !== false ? 'active' : '' ?>" href="/user/dashboard">
                                <i class="bi bi-speedometer2 me-2"></i>控制面板
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/user/profile') !== false ? 'active' : '' ?>" href="/user/profile">
                                <i class="bi bi-person me-2"></i>个人资料
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/user/balance') !== false ? 'active' : '' ?>" href="/user/balance">
                                <i class="bi bi-wallet2 me-2"></i>账户余额
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 user-content">
                <?= $content ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
