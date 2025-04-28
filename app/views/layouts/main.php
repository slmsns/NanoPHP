<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'PHP框架' ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        header { background: #333; color: white; padding: 1rem; }
        nav a { color: white; margin-right: 1rem; text-decoration: none; }
        .container { padding: 1rem; }
        .alert { padding: 0.5rem; margin: 1rem 0; border-radius: 4px; }
        .alert-error { background: #ffebee; color: #c62828; }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="/">首页</a>
            <?php if (isset($_SESSION['user'])): ?>
                <?php if ($_SESSION['user']['is_admin']): ?>
                    <a href="/admin">管理后台</a>
                <?php endif; ?>
                <a href="/user/dashboard">用户中心</a>
                <a href="/user/logout">退出</a>
            <?php else: ?>
                <a href="/user/login">登录</a>
                <a href="/user/register">注册</a>
            <?php endif; ?>
        </nav>
    </header>
    <div class="container">
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>
        <?= $content ?>
    </div>
</body>
</html>
