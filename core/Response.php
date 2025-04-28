<?php
namespace Core;

class Response
{
    protected $statusCode = 200;
    protected $headers = [];
    protected $content;

    public function setStatusCode($code)
    {
        $this->statusCode = $code;
        return $this;
    }

    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function json($data)
    {
        $this->setHeader('Content-Type', 'application/json');
        $this->content = json_encode($data);
        return $this;
    }

    public function view($template, $data = [])
    {
        // 简单的视图渲染
        ob_start();
        extract($data);
        require ROOT_PATH . '/app/views/' . $template . '.php';
        $this->content = ob_get_clean();
        return $this;
    }

    public function send()
    {
        http_response_code($this->statusCode);
        
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
        
        echo $this->content;
    }
}
