<?php
class Router {
    private $routes = [];
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addRoute($method, $path, $controller, $action, $middleware = null) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'controller' => $controller,
            'action' => $action,
            'middleware' => $middleware
        ];
    }

    public function dispatch() {
        require __DIR__ . '/Middleware.php';
        require __DIR__ . '/View.php';
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // 设置默认CONTENT_TYPE
        if (!isset($_SERVER['CONTENT_TYPE']) && $requestMethod === 'POST') {
            $_SERVER['CONTENT_TYPE'] = 'application/json';
        }

        // 准备调试信息
        $debug = "Debug Info:<br>";
        $debug .= "Request: $requestMethod $requestUri<br>";
        $debug .= "Available routes:<br>";
        foreach ($this->routes as $i => $route) {
            $debug .= "Route $i: {$route['method']} {$route['path']}<br>";
        }

        foreach ($this->routes as $route) {
            // 简单路径匹配
            if ($route['method'] === $requestMethod && $route['path'] === $requestUri) {
                error_log("Matched route: {$route['method']} {$route['path']}");
                // 执行中间件
                if ($route['middleware']) {
                    call_user_func($route['middleware']);
                }

                $controllerClass = $route['controller'];
                $action = $route['action'];

                // 实例化控制器
                $controller = new $controllerClass($this->db);

                // 调用控制器方法
                $requestData = array_merge($_GET, $_POST);
                $response = $controller->$action($requestData);

                // 处理响应
                if (is_array($response) && isset($response['view'])) {
                    // 渲染视图
                    $view = new View();
                    echo $view->render($response['view'], $response['data'] ?? []);
                } else {
                    // 返回JSON响应
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
                return;
            }
        }

        // 没有匹配的路由
        echo $debug;
        header('HTTP/1.1 404 Not Found', true, 404);
        echo json_encode(['error' => 'Not Found']);
    }
}
