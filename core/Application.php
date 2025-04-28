<?php
namespace Core;

class Application
{
    protected $config = [];
    protected $router;
    protected $db;

    public function __construct(array $config)
    {
        $this->config = $config;
        
        // 初始化数据库连接
        $this->db = new Database($this->config['database']);
        
        // 初始化路由
        $this->router = new Router();
    }

    public function run($router)
    {
        try {
            // 处理请求
            $request = new Request();
            
            // 路由分发
            $response = $router->dispatch($request);
            
            // 发送响应
            if ($response instanceof Response) {
                $response->send();
            } else {
                echo $response;
            }
        } catch (\Exception $e) {
            // 错误处理
            $this->handleException($e);
        }
    }

    protected function handleException(\Exception $e)
    {
        // 根据环境显示错误信息
        if ($this->config['debug'] ?? false) {
            $error = sprintf(
                "<h1>Error: %s</h1><pre>%s</pre>",
                $e->getMessage(),
                $e->getTraceAsString()
            );
        } else {
            $error = "An error occurred. Please try again later.";
        }
        
        http_response_code($e->getCode() ?: 500);
        echo $error;
    }
}
