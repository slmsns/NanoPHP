<?php
class Middleware {
    public static function adminOnly() {
        // 检查session中是否有admin_id
        if (empty($_SESSION['admin_id'])) {
            header('HTTP/1.1 403 Forbidden');
            echo json_encode(['error' => '需要管理员权限']);
            exit;
        }
    }
}
