<?php
require __DIR__ . '/core/autoload.php';

$config = require __DIR__ . '/config/database.php';
$db = new Core\Database($config);
$manager = new Core\MigrationManager($db);

$command = $argv[1] ?? 'status';

try {
    switch ($command) {
        case 'status':
            $status = $manager->getStatus();
            echo "Migration Status:\n";
            foreach ($status as $file => $state) {
                echo " - {$file}: {$state}\n";
            }
            break;
            
        case 'up':
            $executed = $manager->migrate('up');
            echo "Executed migrations:\n";
            foreach ($executed as $file) {
                echo " - {$file}\n";
            }
            break;
            
        case 'down':
            $executed = $manager->migrate('down');
            echo "Rolled back migrations:\n";
            foreach ($executed as $file) {
                echo " - {$file}\n";
            }
            break;
            
        case 'fresh':
            $manager->migrate('down');
            $executed = $manager->migrate('up');
            echo "Database refreshed. Executed migrations:\n";
            foreach ($executed as $file) {
                echo " - {$file}\n";
            }
            break;
            
        case 'refresh':
            $manager->migrate('down');
            $executed = $manager->migrate('up');
            echo "Latest migrations refreshed. Executed migrations:\n";
            foreach ($executed as $file) {
                echo " - {$file}\n";
            }
            break;
            
        default:
            echo "Usage: php migrate.php [status|up|down|fresh|refresh]\n";
            exit(1);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
