<?php
/**
 * Fix 403 Forbidden Error After Login
 * 
 * This script fixes common causes of 403 errors after login in Filament.
 * Access this file via browser: https://your-domain.com/fix-403.php
 * 
 * IMPORTANT: Delete this file after running it for security reasons.
 */

// Security: Only allow with a secret key or in local environment
$secretKey = 'fix403_' . date('Ymd'); // Simple daily key
$providedKey = $_GET['key'] ?? '';

if ($providedKey !== $secretKey && php_sapi_name() !== 'cli' && env('APP_ENV') !== 'local') {
    die('Access denied. Use: ?key=' . $secretKey);
}

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Fixing 403 Error</title>
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
    <h1>Fixing 403 Forbidden Error</h1>
    <pre>
<?php

try {
    echo "Starting 403 error fix...\n\n";

    // 1. Clear all caches
    echo "1. Clearing application cache...\n";
    Artisan::call('cache:clear');
    echo "   ✓ Application cache cleared\n";

    echo "\n2. Clearing config cache...\n";
    Artisan::call('config:clear');
    echo "   ✓ Config cache cleared\n";

    echo "\n3. Clearing route cache...\n";
    Artisan::call('route:clear');
    echo "   ✓ Route cache cleared\n";

    echo "\n4. Clearing view cache...\n";
    Artisan::call('view:clear');
    echo "   ✓ View cache cleared\n";

    echo "\n5. Clearing event cache...\n";
    Artisan::call('event:clear');
    echo "   ✓ Event cache cleared\n";

    // 2. Create storage link if it doesn't exist
    echo "\n6. Checking storage link...\n";
    $linkPath = public_path('storage');
    $targetPath = storage_path('app/public');
    
    if (!File::exists($linkPath)) {
        if (File::exists($targetPath)) {
            if (PHP_OS_FAMILY === 'Windows') {
                // Windows: Create junction
                $command = 'mklink /J "' . $linkPath . '" "' . $targetPath . '"';
                exec($command, $output, $return);
                if ($return === 0) {
                    echo "   ✓ Storage link created (Windows junction)\n";
                } else {
                    echo "   ⚠ Could not create storage link automatically. Please create manually:\n";
                    echo "     Run: php artisan storage:link\n";
                }
            } else {
                // Unix/Linux: Create symlink
                symlink($targetPath, $linkPath);
                echo "   ✓ Storage link created\n";
            }
        } else {
            echo "   ⚠ Storage directory does not exist. Creating...\n";
            File::makeDirectory($targetPath, 0755, true);
            if (PHP_OS_FAMILY !== 'Windows') {
                symlink($targetPath, $linkPath);
            }
            echo "   ✓ Storage directory and link created\n";
        }
    } else {
        echo "   ✓ Storage link already exists\n";
    }

    // 3. Fix file permissions (Unix/Linux only)
    if (PHP_OS_FAMILY !== 'Windows') {
        echo "\n7. Fixing file permissions...\n";
        $directories = [
            storage_path(),
            storage_path('app'),
            storage_path('app/public'),
            storage_path('framework'),
            storage_path('framework/cache'),
            storage_path('framework/sessions'),
            storage_path('framework/views'),
            storage_path('logs'),
            bootstrap_path('cache'),
        ];

        foreach ($directories as $dir) {
            if (File::exists($dir)) {
                chmod($dir, 0755);
                echo "   ✓ Fixed permissions for: " . basename($dir) . "\n";
            }
        }
    } else {
        echo "\n7. Skipping file permissions (Windows)\n";
    }

    // 4. Clear session files
    echo "\n8. Clearing session files...\n";
    $sessionPath = storage_path('framework/sessions');
    if (File::exists($sessionPath)) {
        $files = File::files($sessionPath);
        $count = 0;
        foreach ($files as $file) {
            if (File::delete($file)) {
                $count++;
            }
        }
        echo "   ✓ Cleared {$count} session files\n";
    } else {
        echo "   ⚠ Session directory does not exist\n";
    }

    // 5. Optimize for production (if needed)
    echo "\n9. Optimizing application...\n";
    try {
        Artisan::call('config:cache');
        echo "   ✓ Config cached\n";
    } catch (\Exception $e) {
        echo "   ⚠ Could not cache config: " . $e->getMessage() . "\n";
    }

    try {
        Artisan::call('route:cache');
        echo "   ✓ Routes cached\n";
    } catch (\Exception $e) {
        echo "   ⚠ Could not cache routes: " . $e->getMessage() . "\n";
    }

    try {
        Artisan::call('view:cache');
        echo "   ✓ Views cached\n";
    } catch (\Exception $e) {
        echo "   ⚠ Could not cache views: " . $e->getMessage() . "\n";
    }

    // 6. Check .env configuration
    echo "\n10. Checking .env configuration...\n";
    $envPath = base_path('.env');
    if (File::exists($envPath)) {
        $envContent = File::get($envPath);
        
        $checks = [
            'APP_KEY' => 'APP_KEY is set',
            'APP_URL' => 'APP_URL is set',
            'DB_CONNECTION' => 'DB_CONNECTION is set',
            'SESSION_DRIVER' => 'SESSION_DRIVER is set',
        ];

        foreach ($checks as $key => $message) {
            if (preg_match("/^{$key}=/m", $envContent)) {
                echo "   ✓ {$message}\n";
            } else {
                echo "   ⚠ {$message} - MISSING\n";
            }
        }

        // Check if SESSION_DRIVER is database
        if (preg_match("/^SESSION_DRIVER=database/m", $envContent)) {
            echo "   ✓ SESSION_DRIVER is set to 'database'\n";
            echo "   ℹ Make sure 'sessions' table exists (run migrations if needed)\n";
        }
    } else {
        echo "   ✗ .env file not found!\n";
    }

    echo "\n========================================\n";
    echo "✓ 403 error fix completed!\n";
    echo "========================================\n\n";
    
    echo "Next steps:\n";
    echo "1. Try logging in again\n";
    echo "2. If still getting 403, check:\n";
    echo "   - File permissions on storage/ and bootstrap/cache/\n";
    echo "   - .env file has correct APP_URL\n";
    echo "   - Database sessions table exists (if using database sessions)\n";
    echo "   - Web server configuration (Apache/Nginx)\n";
    echo "\n";
    echo "⚠ IMPORTANT: Delete this file (fix-403.php) for security!\n";

} catch (\Exception $e) {
    echo "\n✗ Error: " . $e->getMessage() . "\n";
    echo "\nStack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}

?>
    </pre>
</body>
</html>

