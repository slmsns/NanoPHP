<?php
namespace Migrations;

use Core\Migration;

class Migration_20250427151000_create_transactions_table extends Migration
{
    
    public function up() {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS transactions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                type VARCHAR(20) NOT NULL COMMENT 'recharge/consumption',
                amount DECIMAL(10,2) NOT NULL,
                status VARCHAR(20) NOT NULL DEFAULT 'pending' COMMENT 'completed/pending/failed',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");
        
        // 添加索引
        $this->db->exec("CREATE INDEX idx_user_id ON transactions (user_id)");
        $this->db->exec("CREATE INDEX idx_created_at ON transactions (created_at)");
    }
    
    public function down() {
        $this->db->exec("DROP TABLE IF EXISTS transactions");
    }
}
