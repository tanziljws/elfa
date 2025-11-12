<?php

require_once 'vendor/autoload.php';

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing Laravel Application...\n";

try {
    // Test database connection
    $pdo = DB::connection()->getPdo();
    echo "✓ Database connection successful!\n";
    
    // Test galleries count
    $count = DB::table('galleries')->count();
    echo "✓ Galleries table has $count records\n";
    
    // Test route
    $url = route('gallery.index');
    echo "✓ Gallery route: $url\n";
    
    // Test admin route
    $adminUrl = route('admin.dashboard');
    echo "✓ Admin route: $adminUrl\n";
    
    echo "\n=== Application Ready! ===\n";
    echo "Public Gallery: http://localhost:8000\n";
    echo "Admin Dashboard: http://localhost:8000/admin\n";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
