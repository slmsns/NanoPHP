<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? '管理后台' ?></title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0;
            display: flex;
            min-height: 100vh;
        }
        .admin-header {
            background: #2c3e50;
            color: white;
            padding: 1rem;
            width: 100%;
        }
        .admin-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-nav a {
            color: white;
            margin-right: 1rem;
            text-decoration: none;
        }
        .admin-sidebar {
            width: 200px;
            background: #34495e;
            color: white;
            padding: 1rem;
        }
        .admin-sidebar ul {
            list-style: none;
            padding: 0;
        }
        .admin-sidebar li {
            margin-bottom: 0.5rem;
        }
        .admin-sidebar a {
            color: white;
            text-decoration: none;
        }
        .admin-content {
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
    <div class="admin-sidebar">
        <h3>管理菜单</h3>
        <ul>
            <li><a href="/admin/dashboard">仪表盘</a></li>
            <li><a href="/admin/users">用户管理</a></li>
            <li><a href="/admin/settings">系统设置</a></li>
        </ul>
    </div>
    <div style="flex: 1; display: flex; flex-direction: column;">
        <header class="admin-header">
            <nav class="admin-nav">
                <div>
                    <a href="/admin/dashboard">管理后台</a>
                </div>
                <div>
                    <a href="/user/profile">我的资料</a>
                    <a href="/user/logout">退出</a>
                </div>
            </nav>
        </header>
        <main class="admin-content">
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>
            <?= $content ?>
        </main>
    </div>
</body>
</html>
