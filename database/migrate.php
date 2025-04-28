<?php
// 定义根目录
define('ROOT_PATH', dirname(__DIR__));

// 加载自动加载文件
require_once ROOT_PATH . '/core/autoload.php';

use Core\Database;
use Exception;

// 直接加载数据库配置
$config = [
    'database' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' => 'framework',
        'username' => 'root',
        'password' => '123456',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
    ]
];

try {
    echo "尝试连接数据库...\n";
    print_r($config['database']);
    
    // 初始化数据库连接
    $db = new Database($config['database']);
    echo "数据库连接成功\n";

    // 获取所有迁移文件
    $migrations = glob(__DIR__ . '/migrations/*.php');
    echo "找到迁移文件: " . count($migrations) . "个\n";

    // 按文件名排序
    sort($migrations);

    // 执行迁移
    foreach ($migrations as $migration) {
        echo "执行迁移: " . basename($migration) . "\n";
        $migrationClass = require $migration;
        $migrationClass->up($db);
    }

    echo "数据库迁移完成\n";
} catch (Exception $e) {
    echo "迁移失败: " . $e->getMessage() . "\n";
    exit(1);
}
