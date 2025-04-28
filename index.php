<?php
// 定义项目根目录
define('ROOT_PATH', __DIR__);

// 引入自动加载文件
require_once ROOT_PATH . '/core/autoload.php';

// 启动应用
$app = new Core\Application();
$app->run();
