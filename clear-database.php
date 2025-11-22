<?php
/**
 * Clear All Database Data Script
 * 
 * This script clears all data from all database tables.
 * Access this file via browser: https://your-domain.com/clear-database.php
 * 
 * IMPORTANT: Delete this file after running it for security reasons.
 */

// Security: Only allow in local environment or with a secret key
$secretKey = 'clear_' . date('Ymd'); // Simple daily key
$providedKey = $_GET['key'] ?? '';

if ($providedKey !== $secretKey && php_sapi_name() !== 'cli' && env('APP_ENV') !== 'local') {
    die('Access denied. Use: ?key=' . $secretKey);
}

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Clearing Database</title>
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
    <h1>Clearing All Database Data</h1>
    <pre>
<?php

try {
    // Disable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    echo "✓ Foreign key checks disabled\n\n";

    // List of all tables to truncate (excluding Laravel system tables like migrations, cache, jobs, sessions)
    $tables = [
        'categories',
        'films',
        'venues',
        'schedules',
        'jury_members',
        'masterclasses',
        'news',
        'partners',
        'team_members',
        'archives',
        'contact_messages',
        'downloads',
        'site_settings',
        'sliders',
        'application_settings',
        'programme_images',
        'schedule_images',
        'masterclass_images',
        'debut_film_images',
        'jury_debut_images',
        'jury_short_images',
        'national_short_images',
        'international_short_images',
        'new_asian_current_images',
        'section_settings',
        'partner_categories',
        'gallery_images',
        'about_jaffnaicf_images',
        'reviews',
        'users',
    ];

    $truncatedCount = 0;
    $skippedCount = 0;

    // Truncate all tables
    foreach ($tables as $table) {
        if (Schema::hasTable($table)) {
            try {
                DB::table($table)->truncate();
                echo "✓ Truncated table: {$table}\n";
                $truncatedCount++;
            } catch (\Exception $e) {
                echo "✗ Error truncating {$table}: " . $e->getMessage() . "\n";
                $skippedCount++;
            }
        } else {
            echo "⚠ Table does not exist: {$table}\n";
            $skippedCount++;
        }
    }

    // Re-enable foreign key checks
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    echo "\n✓ Foreign key checks re-enabled\n\n";

    echo "========================================\n";
    echo "Summary:\n";
    echo "  Tables truncated: {$truncatedCount}\n";
    echo "  Tables skipped: {$skippedCount}\n";
    echo "========================================\n";
    echo "\n✓ All database data cleared successfully!\n";
    echo "\n⚠ IMPORTANT: Delete this file (clear-database.php) for security!\n";

} catch (\Exception $e) {
    echo "\n✗ Error: " . $e->getMessage() . "\n";
    echo "\nStack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}

?>
    </pre>
</body>
</html>

