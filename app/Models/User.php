<?php
namespace App\Models;

use Core\Database;

class User
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function register($username, $password, $email)
    {
        // 检查用户名是否已存在
        if ($this->findByUsername($username)) {
            throw new \Exception("用户名已存在");
        }

        // 创建用户
        $this->db->query(
            "INSERT INTO users (username, password, email, balance, created_at) VALUES (?, ?, ?, 0, NOW())",
            [$username, password_hash($password, PASSWORD_DEFAULT), $email]
        );

        return $this->findByUsername($username);
    }

    public function login($username, $password)
    {
        $user = $this->findByUsername($username);
        if (!$user || !password_verify($password, $user['password'])) {
            throw new \Exception("用户名或密码错误");
        }

        return $user;
    }

    public function findByUsername($username)
    {
        return $this->db->query(
            "SELECT * FROM users WHERE username = ?",
            [$username]
        )->fetch();
    }

    public function updateBalance($userId, $amount)
    {
        $this->db->query(
            "UPDATE users SET balance = balance + ? WHERE id = ?",
            [$amount, $userId]
        );

        return $this->db->query(
            "SELECT balance FROM users WHERE id = ?",
            [$userId]
        )->fetchColumn();
    }

    public function getAllUsers()
    {
        return $this->db->query("SELECT * FROM users")->fetchAll();
    }
}
