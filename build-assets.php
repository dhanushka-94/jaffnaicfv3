<?php
/**
 * Build Vite Assets Script
 * 
 * This script builds the frontend assets using Vite.
 * Access this file via browser: https://uat.jaffnaicf.lk/build-assets.php
 * 
 * IMPORTANT: Delete this file after running it for security reasons.
 */

// Security: Only allow in production or with a secret key
$secretKey = 'build_' . date('Ymd'); // Simple daily key
$providedKey = $_GET['key'] ?? '';

if ($providedKey !== $secretKey && php_sapi_name() !== 'cli') {
    die('Access denied. Use: ?key=' . $secretKey);
}

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Building Assets</title>
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
    <h1>Building Vite Assets</h1>
    <pre>
<?php

$basePath = __DIR__;
$publicPath = $basePath . '/public';
$buildPath = $publicPath . '/build';

echo "Base Path: {$basePath}\n";
echo "Public Path: {$publicPath}\n";
echo "Build Path: {$buildPath}\n\n";

// Check if Node.js is available
echo "Checking Node.js...\n";
$nodeVersion = shell_exec('node --version 2>&1');
if ($nodeVersion) {
    echo "✓ Node.js found: " . trim($nodeVersion) . "\n";
} else {
    echo "✗ Node.js not found. Please install Node.js or build assets locally.\n";
    echo "\nTo build locally:\n";
    echo "1. Run: npm install\n";
    echo "2. Run: npm run build\n";
    echo "3. Upload the 'public/build' folder to the server\n";
    exit(1);
}

// Check if npm is available
echo "\nChecking npm...\n";
$npmVersion = shell_exec('npm --version 2>&1');
if ($npmVersion) {
    echo "✓ npm found: " . trim($npmVersion) . "\n";
} else {
    echo "✗ npm not found. Please install npm.\n";
    exit(1);
}

// Check if node_modules exists
echo "\nChecking node_modules...\n";
if (is_dir($basePath . '/node_modules')) {
    echo "✓ node_modules directory exists\n";
} else {
    echo "⚠ node_modules not found. Installing dependencies...\n";
    echo "Running: npm install\n";
    $installOutput = shell_exec('cd ' . escapeshellarg($basePath) . ' && npm install 2>&1');
    echo $installOutput . "\n";
    
    if (!is_dir($basePath . '/node_modules')) {
        echo "✗ Failed to install dependencies\n";
        exit(1);
    }
    echo "✓ Dependencies installed\n";
}

// Build assets
echo "\nBuilding assets with Vite...\n";
echo "Running: npm run build\n";
$buildOutput = shell_exec('cd ' . escapeshellarg($basePath) . ' && npm run build 2>&1');
echo $buildOutput . "\n";

// Check if build was successful
if (is_dir($buildPath) && file_exists($buildPath . '/manifest.json')) {
    echo "\n✓ Build successful!\n";
    echo "✓ manifest.json found at: {$buildPath}/manifest.json\n";
    
    // List built files
    $manifest = json_decode(file_get_contents($buildPath . '/manifest.json'), true);
    if ($manifest) {
        echo "\nBuilt files:\n";
        foreach ($manifest as $key => $file) {
            echo "  - {$key} -> {$file['file']}\n";
        }
    }
    
    echo "\n✓ Assets are ready!\n";
    echo "\n⚠ IMPORTANT: Delete this file (build-assets.php) for security!\n";
} else {
    echo "\n✗ Build failed or manifest.json not found\n";
    echo "Please check the output above for errors.\n";
    exit(1);
}

?>
    </pre>
</body>
</html>

