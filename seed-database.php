<?php
/**
 * Seed Database Script
 * 
 * This script seeds the database with initial data (admin user, settings, etc.).
 * Access this file via browser: https://your-domain.com/seed-database.php
 * 
 * IMPORTANT: Delete this file after running it for security reasons.
 */

// Security: Only allow with a secret key or in local environment
$secretKey = 'seed_' . date('Ymd'); // Simple daily key
$providedKey = $_GET['key'] ?? '';

if ($providedKey !== $secretKey && php_sapi_name() !== 'cli' && env('APP_ENV') !== 'local') {
    die('Access denied. Use: ?key=' . $secretKey);
}

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Seeding Database</title>
    <style>
        body { font-family: monospace; padding: 20px; background: #1a1a1a; color: #0f0; }
        .success { color: #0f0; }
        .error { color: #f00; }
        .info { color: #0ff; }
        .warning { color: #ff0; }
        pre { background: #000; padding: 10px; border: 1px solid #333; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>Seeding Database</h1>
    <pre>
<?php

try {
    echo "Starting database seeding...\n\n";

    // Run AdminUserSeeder
    echo "Running AdminUserSeeder...\n";
    $seeder = new \Database\Seeders\AdminUserSeeder();
    $seeder->run();
    echo "✓ Admin user created\n\n";

    echo "========================================\n";
    echo "✓ Database seeding completed successfully!\n";
    echo "========================================\n\n";
    
    echo "Admin Login Credentials:\n";
    echo "  Email: admin@admin.com\n";
    echo "  Password: admin123\n\n";
    
    echo "⚠ IMPORTANT: Delete this file (seed-database.php) for security!\n";

} catch (\Exception $e) {
    echo "\n✗ Error: " . $e->getMessage() . "\n";
    echo "\nStack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}

?>
    </pre>
</body>
</html>

