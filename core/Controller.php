<?php
namespace Core;

class Controller
{
    protected $request;
    protected $response;
    protected $db;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        
        // 初始化数据库连接
        $config = require ROOT_PATH . '/config/app.php';
        $this->db = new Database($config['database']);
    }

    protected function view($template, $data = [])
    {
        return $this->response->view($template, $data);
    }

    protected function json($data)
    {
        return $this->response->json($data);
    }

    protected function redirect($url)
    {
        $this->response->setHeader('Location', $url);
        $this->response->setStatusCode(302);
        return $this->response;
    }
}
