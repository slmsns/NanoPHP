<?php
class View {
    // 渲染视图模板
    public function render($viewPath, $data = []) {
        // 提取数据为变量
        extract($data);
        
        // 模板文件路径
        $templateFile = __DIR__ . '/../../resources/views/' . $viewPath . '.html.php';
        
        // 检查模板文件是否存在
        if (!file_exists($templateFile)) {
            throw new Exception("View template not found: " . $viewPath);
        }
        
        // 开启输出缓冲
        ob_start();
        
        // 引入模板文件
        include $templateFile;
        
        // 获取并清空缓冲内容
        $content = ob_get_clean();
        
        // 返回渲染后的内容
        return $content;
    }
}
