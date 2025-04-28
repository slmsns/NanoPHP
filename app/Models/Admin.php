<?php
namespace App\Models;

use Core\Database;

class Admin
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function login($username, $password)
    {
        $admin = $this->findByUsername($username);
        if (!$admin || !password_verify($password, $admin['password'])) {
            throw new \Exception("用户名或密码错误");
        }

        return $admin;
    }

    public function findByUsername($username)
    {
        return $this->db->query(
            "SELECT * FROM admins WHERE username = ?",
            [$username]
        )->fetch();
    }
}
