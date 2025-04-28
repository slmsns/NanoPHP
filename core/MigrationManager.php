<?php
namespace Core;

use PDO;
use PDOException;
use RuntimeException;

class MigrationManager
{
    private $db;
    private $migrationsDir;

    public function __construct(PDO $db, string $migrationsDir = null)
    {
        $this->db = $db;
        $this->migrationsDir = $migrationsDir ?? __DIR__ . '/../migrations';
        $this->ensureMigrationsTable();
    }

    public function getStatus(): array
    {
        $files = $this->getMigrationFiles();
        $applied = $this->getAppliedMigrations();
        
        $status = [];
        foreach ($files as $file) {
            $status[$file] = in_array($file, $applied) ? 'applied' : 'pending';
        }
        
        return $status;
    }

    public function migrate(string $direction = 'up'): array
    {
        if (!in_array($direction, ['up', 'down'])) {
            throw new \InvalidArgumentException('Direction must be either "up" or "down"');
        }

        $files = $this->getMigrationFiles();
        $applied = $this->getAppliedMigrations();
        
        if ($direction === 'up') {
            $toApply = array_diff($files, $applied);
            sort($toApply);
        } else {
            $toApply = array_intersect($applied, $files);
            rsort($toApply);
        }

        $executed = [];
        foreach ($toApply as $file) {
            $this->runMigration($file, $direction);
            $executed[] = $file;
        }

        return $executed;
    }

    private function runMigration(string $file, string $direction): void
    {
        require_once $this->migrationsDir . '/' . $file;
        
        $className = 'Migration_' . pathinfo($file, PATHINFO_FILENAME);
        if (!class_exists($className)) {
            throw new RuntimeException("Migration class {$className} not found");
        }

        $migration = new $className($this->db);
        $migration->{$direction}();

        if ($direction === 'up') {
            $this->recordMigration($file);
        } else {
            $this->removeMigration($file);
        }
    }

    private function ensureMigrationsTable(): void
    {
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL UNIQUE,
                batch INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");
    }

    private function getMigrationFiles(): array
    {
        if (!is_dir($this->migrationsDir)) {
            return [];
        }

        $files = scandir($this->migrationsDir);
        return array_filter($files, function($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'php';
        });
    }

    private function getAppliedMigrations(): array
    {
        $stmt = $this->db->query("SELECT name FROM migrations ORDER BY batch, name");
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    private function recordMigration(string $file): void
    {
        $batch = $this->getNextBatchNumber();
        $stmt = $this->db->prepare("INSERT INTO migrations (name, batch) VALUES (?, ?)");
        $stmt->execute([$file, $batch]);
    }

    private function removeMigration(string $file): void
    {
        $this->db->prepare("DELETE FROM migrations WHERE name = ?")->execute([$file]);
    }

    private function getNextBatchNumber(): int
    {
        $stmt = $this->db->query("SELECT MAX(batch) FROM migrations");
        return (int)$stmt->fetchColumn() + 1;
    }
}
