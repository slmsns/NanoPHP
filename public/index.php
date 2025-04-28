<?php
$config = require __DIR__ . '/../config/database.php';
require __DIR__ . '/../app/core/Router.php';
require __DIR__ . '/../app/controllers/UserController.php';

// 配置会话
session_set_cookie_params([
    'lifetime' => 86400,
    'path' => '/',
    'domain' => 'localhost',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();

// 初始化数据库连接
try {
    $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']};port={$config['port']}";
    $db = new PDO($dsn, $config['username'], $config['password'], $config['options']);
} catch (PDOException $e) {
    die("数据库连接失败: " . $e->getMessage());
}

// 初始化路由
$router = new Router($db);

require __DIR__ . '/../app/controllers/AdminController.php';

// 加载路由配置
$routes = require __DIR__ . '/../routes/web.php';
foreach ($routes as $route) {
    $router->addRoute(...$route);
}

// 分发请求
$router->dispatch();
