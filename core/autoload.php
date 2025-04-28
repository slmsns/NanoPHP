<?php
spl_autoload_register(function ($class) {
    // 处理核心类
    if (strpos($class, 'Core\\') === 0) {
        $file = substr(str_replace('\\', DIRECTORY_SEPARATOR, $class), 5) . '.php';
        $path = ROOT_PATH . '/core/' . $file;
        if (file_exists($path)) {
            require $path;
            return;
        }
    }
    
    // 处理应用控制器
    if (strpos($class, 'App\\Controllers\\') === 0) {
        $file = substr(str_replace('\\', DIRECTORY_SEPARATOR, $class), 15) . '.php';
        $path = ROOT_PATH . '/app/Controllers/' . $file;
        if (file_exists($path)) {
            require $path;
            return;
        }
    }
    
    // 处理应用模型
    if (strpos($class, 'App\\Models\\') === 0) {
        $file = substr(str_replace('\\', DIRECTORY_SEPARATOR, $class), 10) . '.php';
        $path = ROOT_PATH . '/app/Models/' . $file;
        if (file_exists($path)) {
            require $path;
            return;
        }
    }
    
    // 处理其他应用类
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    $path = ROOT_PATH . '/app/' . $file;
    if (file_exists($path)) {
        require $path;
        return;
    }
    
    throw new Exception("类 {$class} 未找到");
});
