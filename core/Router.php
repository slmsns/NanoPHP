<?php
namespace Core;

class Router
{
    protected $routes = [];
    protected $middleware = [];

    public function addRoute($method, $path, $handler, $middleware = [])
    {
        $this->routes[$method][$path] = [
            'handler' => $handler,
            'middleware' => $middleware
        ];
    }

    public function dispatch(Request $request)
    {
        $method = $request->getMethod();
        $path = $request->getPath();

        // 查找匹配的路由
        foreach ($this->routes[$method] ?? [] as $routePath => $route) {
            if ($this->matchPath($routePath, $path, $params)) {
                // 执行中间件
                foreach ($route['middleware'] as $middleware) {
                    $middleware = new $middleware();
                    $middleware->handle($request);
                }

                // 执行控制器方法
                return $this->callHandler($route['handler'], $params);
            }
        }

        // 没有找到路由
        throw new \Exception("Route not found", 404);
    }

    protected function matchPath($routePath, $requestPath, &$params)
    {
        $params = [];
        
        // 规范化路径
        $routePath = trim($routePath, '/');
        $requestPath = trim($requestPath, '/');

        // 精确匹配
        if ($routePath === $requestPath) {
            return true;
        }

        // 参数化路由匹配
        $routeParts = explode('/', $routePath);
        $requestParts = explode('/', $requestPath);

        if (count($routeParts) !== count($requestParts)) {
            return false;
        }

        foreach ($routeParts as $key => $routePart) {
            if (strpos($routePart, '{') === 0 && strpos($routePart, '}') === strlen($routePart) - 1) {
                // 提取参数名
                $paramName = substr($routePart, 1, -1);
                $params[$paramName] = $requestParts[$key];
            } elseif ($routePart !== $requestParts[$key]) {
                return false;
            }
        }

        return true;
    }

    protected function callHandler($handler, $params)
    {
        if (is_string($handler)) {
            list($controller, $method) = explode('@', $handler);
            $controller = "App\\Controllers\\" . $controller;
            
            // 创建Request和Response对象
            $request = new Request();
            $response = new Response();
            
            // 实例化控制器并传递依赖
            $controller = new $controller($request, $response);
            return $controller->$method($params);
        }

        if (is_callable($handler)) {
            return $handler($params);
        }

        throw new \Exception("Invalid route handler");
    }
}
