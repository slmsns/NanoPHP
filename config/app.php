<?php
return [
    // 应用设置
    'name' => 'PHP Framework',
    'env' => 'development',
    'debug' => true,

    // 数据库设置
    'database' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' => 'framework',
        'username' => 'root',
        'password' => '123456',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
    ],

    // 视图设置
    'views' => [
        'path' => ROOT_PATH . '/app/views',
        'cache' => ROOT_PATH . '/storage/views',
    ],
];
