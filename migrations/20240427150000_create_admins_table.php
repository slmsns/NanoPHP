<?php
namespace Migrations;

use Core\Migration;

class Migration_20240427150000_create_admins_table extends Migration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS admins (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                created_at DATETIME,
                updated_at DATETIME
            )
        ");

        // 添加默认管理员账户
        $stmt = $this->db->prepare(
            "INSERT INTO admins (username, password, email, created_at) VALUES (?, ?, ?, NOW())"
        );
        $stmt->execute([
            'admin', 
            password_hash('admin123', PASSWORD_DEFAULT), 
            'admin@example.com'
        ]);
    }

    public function down()
    {
        $this->execute("DROP TABLE IF EXISTS admins");
    }
}
