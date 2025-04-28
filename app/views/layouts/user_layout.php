<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? '用户中心' ?></title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0;
            display: flex;
            min-height: 100vh;
        }
        .user-header {
            background: #3498db;
            color: white;
            padding: 1rem;
            width: 100%;
        }
        .user-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .user-nav a {
            color: white;
            margin-right: 1rem;
            text-decoration: none;
        }
        .user-sidebar {
            width: 200px;
            background: #2980b9;
            color: white;
            padding: 1rem;
        }
        .user-sidebar ul {
            list-style: none;
            padding: 0;
        }
        .user-sidebar li {
            margin-bottom: 0.5rem;
        }
        .user-sidebar a {
            color: white;
            text-decoration: none;
        }
        .user-content {
            flex: 1;
            padding: 1rem;
        }
        .alert {
            padding: 0.5rem;
            margin: 1rem 0;
            border-radius: 4px;
        }
        .alert-error {
            background: #ffebee;
            color: #c62828;
        }
    </style>
</head>
<body>
    <div class="user-sidebar">
        <h3>用户菜单</h3>
        <ul>
            <li><a href="/user/dashboard">个人中心</a></li>
            <li><a href="/user/profile">个人资料</a></li>
            <li><a href="/user/balance">账户余额</a></li>
            <li><a href="/user/settings">账户设置</a></li>
        </ul>
    </div>
    <div style="flex: 1; display: flex; flex-direction: column;">
        <header class="user-header">
            <nav class="user-nav">
                <div>
                    <a href="/user/dashboard">用户中心</a>
                </div>
                <div>
                    <a href="/">返回首页</a>
                    <a href="/user/logout">退出</a>
                </div>
            </nav>
        </header>
        <main class="user-content">
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>
            <?= $content ?>
        </main>
    </div>
</body>
</html>
