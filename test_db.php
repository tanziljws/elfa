<?php

require_once 'vendor/autoload.php';

// Load Laravel environment
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing MySQL Database Connection...\n";

try {
    // Test database connection
    $pdo = DB::connection()->getPdo();
    echo "✓ Database connection successful!\n";
    
    // Test database name
    $database = DB::connection()->getDatabaseName();
    echo "✓ Connected to database: $database\n";
    
    // Test if galleries table exists
    $tables = DB::select("SHOW TABLES");
    echo "✓ Tables in database: " . count($tables) . "\n";
    
    foreach ($tables as $table) {
        $tableName = array_values((array)$table)[0];
        echo "  - $tableName\n";
    }
    
    // Test galleries table if exists
    if (DB::getSchemaBuilder()->hasTable('galleries')) {
        $count = DB::table('galleries')->count();
        echo "✓ Galleries table has $count records\n";
    } else {
        echo "⚠ Galleries table not found\n";
    }
    
} catch (Exception $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "\n";
    echo "Error details:\n";
    echo "- Make sure XAMPP MySQL is running\n";
    echo "- Check database configuration in .env\n";
    echo "- Verify database 'galeri_sekolah_nafisa' exists\n";
}
