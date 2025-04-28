<?php
class AdminController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // 显示管理员登录表单
    public function showLoginForm() {
        return [
            'view' => 'admin/login',
            'data' => ['title' => '管理员登录']
        ];
    }

    // 处理管理员登录
    public function login($request) {
        $data = json_decode(file_get_contents('php://input'), true);
        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';
        
        $stmt = $this->db->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            return ['success' => true, 'message' => '登录成功', 'redirect' => '/admin/dashboard'];
        } else {
            return ['success' => false, 'message' => '用户名或密码错误'];
        }
    }

    // 管理员仪表盘
    public function dashboard() {
        if (empty($_SESSION['admin_id'])) {
            return ['error' => '需要管理员权限'];
        }
        
        return [
            'view' => 'admin/dashboard',
            'data' => [
                'title' => '管理控制台',
                'admin' => [
                    'username' => $_SESSION['admin_username']
                ]
            ]
        ];
    }

    // 获取所有用户
    public function listUsers() {
        $stmt = $this->db->query("SELECT id, username, email, balance FROM users");
        $users = $stmt->fetchAll();
        
        return [
            'view' => 'admin/users',
            'data' => [
                'title' => '用户管理',
                'users' => $users,
                'admin' => [
                    'username' => $_SESSION['admin_username']
                ]
            ]
        ];
    }

    // 添加/编辑用户
    public function editUser($request) {
        // 从请求体获取JSON数据
        $input = json_decode(file_get_contents('php://input'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['success' => false, 'message' => '无效的JSON数据'];
        }

        // 验证必需参数
        $requiredParams = ['username', 'email', 'balance'];
        foreach ($requiredParams as $param) {
            if (empty($input[$param])) {
                return ['success' => false, 'message' => '缺少必要参数: ' . $param];
            }
        }

        $request = $input;
        $isEdit = isset($request['id']);

        $this->db->beginTransaction();
        try {
            if ($isEdit) {
                // 编辑用户
                $sql = "UPDATE users SET username = ?, email = ?, balance = ?";
                $params = [
                    htmlspecialchars($request['username']),
                    htmlspecialchars($request['email']),
                    floatval($request['balance'])
                ];

                // 如果有密码则更新密码
                if (!empty($request['password'])) {
                    $sql .= ", password = ?";
                    $params[] = password_hash($request['password'], PASSWORD_DEFAULT);
                }

                $sql .= " WHERE id = ?";
                $params[] = intval($request['id']);
            } else {
                // 添加用户
                if (empty($request['password'])) {
                    return ['success' => false, 'message' => '添加用户需要设置密码'];
                }

                $sql = "INSERT INTO users (username, email, password, balance) VALUES (?, ?, ?, ?)";
                $params = [
                    htmlspecialchars($request['username']),
                    htmlspecialchars($request['email']),
                    password_hash($request['password'], PASSWORD_DEFAULT),
                    floatval($request['balance'])
                ];
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);

            $this->db->commit();
            return ['success' => true, 'message' => '用户更新成功'];
        } catch (Exception $e) {
            $this->db->rollBack();
            return ['success' => false, 'message' => '用户更新失败: ' . $e->getMessage()];
        }
    }

    // 删除用户
    public function deleteUser($request) {
        // 从查询参数获取用户ID
        $userId = $_GET['id'] ?? null;
        if (!$userId) {
            return ['success' => false, 'message' => '缺少用户ID参数'];
        }

        $this->db->beginTransaction();
        try {
            // 删除用户交易记录
            $stmt = $this->db->prepare("DELETE FROM transactions WHERE user_id = ?");
            $stmt->execute([intval($userId)]);

            // 删除用户
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([intval($userId)]);

            $this->db->commit();
            return ['success' => true, 'message' => '用户删除成功'];
        } catch (Exception $e) {
            $this->db->rollBack();
            return ['success' => false, 'message' => '用户删除失败: ' . $e->getMessage()];
        }
    }

    // 获取所有交易记录
    public function listTransactions() {
        $stmt = $this->db->query("
            SELECT t.*, u.username 
            FROM transactions t
            JOIN users u ON t.user_id = u.id
            ORDER BY t.created_at DESC
        ");
        $transactions = $stmt->fetchAll();
        
        return [
            'view' => 'admin/transactions',
            'data' => [
                'title' => '交易管理',
                'transactions' => $transactions,
                'admin' => [
                    'username' => $_SESSION['admin_username']
                ]
            ]
        ];
    }
}
