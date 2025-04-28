<?php
namespace Core;

use PDO;
use PDOException;

abstract class Migration
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    abstract public function up();
    abstract public function down();

    protected function execute(string $sql): void
    {
        try {
            $this->db->exec($sql);
        } catch (PDOException $e) {
            throw new \RuntimeException(
                "Migration failed: " . $e->getMessage()
            );
        }
    }

    protected function tableExists(string $tableName): bool
    {
        $stmt = $this->db->query("SHOW TABLES LIKE '$tableName'");
        return $stmt->rowCount() > 0;
    }
}
