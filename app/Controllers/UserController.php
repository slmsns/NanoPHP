<?php
class UserController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // 用户登录
    public function login($request) {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return [
                'view' => 'auth/login',
                'data' => ['title' => '用户登录']
            ];
        }

        // 解析JSON请求体
        if (strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
            $json = file_get_contents('php://input');
            $request = json_decode($json, true);
        }

        // 验证输入
        if (empty($request['username']) || empty($request['password'])) {
            return ['success' => false, 'message' => '用户名和密码不能为空'];
        }

        // POST请求处理登录
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$request['username']]);
        $user = $stmt->fetch();

        if ($user && password_verify($request['password'], $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return ['success' => true, 'message' => '登录成功'];
        } else {
            return ['success' => false, 'message' => '用户名或密码错误'];
        }
    }

    // 用户注册
    public function register($request) {
        // 解析JSON请求体
        if (strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
            $json = file_get_contents('php://input');
            $request = json_decode($json, true);
        }

        // 验证输入
        if (empty($request['username']) || empty($request['password']) || empty($request['email'])) {
            return ['success' => false, 'message' => '用户名、密码和邮箱不能为空'];
        }

        $hashedPassword = password_hash($request['password'], PASSWORD_DEFAULT);
        
        try {
            $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$request['username'], $request['email'], $hashedPassword]);
            return ['success' => true, 'message' => '注册成功'];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => '注册失败: ' . $e->getMessage()];
        }
    }

    // 查看用户资料
    public function profile() {
        if (empty($_SESSION['user_id'])) {
            return ['error' => '需要登录'];
        }
        
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
        
        return [
            'view' => 'user/profile',
            'data' => [
                'user' => $user,
                'title' => '用户中心'
            ]
        ];
    }

    // 更新用户资料
    public function updateProfile($userId, $request) {
        $stmt = $this->db->prepare("UPDATE users SET email = ? WHERE id = ?");
        $stmt->execute([$request['email'], $userId]);
        return ['success' => true, 'message' => '资料更新成功'];
    }

    // 充值余额
    public function recharge($userId, $amount) {
        $this->db->beginTransaction();
        try {
            // 更新用户余额
            $stmt = $this->db->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
            $stmt->execute([$amount, $userId]);

            // 记录交易
            $stmt = $this->db->prepare("INSERT INTO transactions (user_id, type, amount, status) VALUES (?, 'recharge', ?, 'completed')");
            $stmt->execute([$userId, $amount]);

            $this->db->commit();
            return ['success' => true, 'message' => '充值成功'];
        } catch (Exception $e) {
            $this->db->rollBack();
            return ['success' => false, 'message' => '充值失败: ' . $e->getMessage()];
        }
    }

    // 用户中心主页面
    public function dashboard() {
        if (empty($_SESSION['user_id'])) {
            return ['error' => '需要登录'];
        }
        
        return [
            'view' => 'user/dashboard',
            'data' => [
                'title' => '用户中心',
                'user' => $this->getUserData($_SESSION['user_id'])
            ]
        ];
    }

    // 余额管理页面
    public function balance() {
        if (empty($_SESSION['user_id'])) {
            return ['error' => '需要登录'];
        }
        
        $userId = $_SESSION['user_id'];
        $user = $this->getUserData($userId);

        $stmt = $this->db->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY created_at DESC LIMIT 10");
        $stmt->execute([$userId]);
        $transactions = $stmt->fetchAll();
        
        return [
            'view' => 'user/balance',
            'data' => [
                'title' => '账户余额',
                'user' => $user,
                'transactions' => $transactions
            ]
        ];
    }

    // 订单记录页面
    public function orders() {
        if (empty($_SESSION['user_id'])) {
            return ['error' => '需要登录'];
        }
        
        $userId = $_SESSION['user_id'];
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        $orders = $stmt->fetchAll();
        
        return [
            'view' => 'user/orders',
            'data' => [
                'title' => '我的订单',
                'orders' => $orders
            ]
        ];
    }

    // 获取用户数据
    private function getUserData($userId) {
        $stmt = $this->db->prepare("SELECT id, username, email, balance FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }
}
