<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Serve static files from storage if they exist (for Railway PHP built-in server)
if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/storage/') === 0) {
    // Get the file path from request URI
    $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    
    // Try symlink path first
    $symlinkPath = __DIR__ . $requestPath;
    
    // If symlink doesn't exist, try direct storage path
    if (!file_exists($symlinkPath)) {
        $storagePath = str_replace('/storage/', '/../storage/app/public/', $requestPath);
        $storagePath = __DIR__ . $storagePath;
        
        if (file_exists($storagePath) && is_file($storagePath)) {
            $symlinkPath = $storagePath;
        }
    }
    
    // Serve the file if it exists
    if (file_exists($symlinkPath) && is_file($symlinkPath) && is_readable($symlinkPath)) {
        $mimeType = mime_content_type($symlinkPath) ?: 'application/octet-stream';
        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . filesize($symlinkPath));
        header('Cache-Control: public, max-age=31536000');
        header('Access-Control-Allow-Origin: *');
        readfile($symlinkPath);
        exit;
    }
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
