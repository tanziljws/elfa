<?php
/**
 * Script untuk Restore Database ke Railway MySQL
 * 
 * Usage: php restore-database.php [backup-file.sql]
 */

require __DIR__ . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Get backup file from argument
$backupFile = $argv[1] ?? null;

if (!$backupFile) {
    echo "❌ Error: Backup file tidak ditemukan!\n\n";
    echo "Usage: php restore-database.php [backup-file.sql]\n\n";
    echo "Contoh:\n";
    echo "  php restore-database.php database/backups/backup_2025-01-14_123456.sql\n\n";
    
    // List available backups
    $backupDir = __DIR__ . '/database/backups';
    if (is_dir($backupDir)) {
        $backups = glob($backupDir . "/*.sql");
        if (!empty($backups)) {
            rsort($backups);
            echo "📦 Backup tersedia:\n";
            foreach (array_slice($backups, 0, 5) as $backup) {
                $size = round(filesize($backup) / 1024 / 1024, 2);
                $date = date('Y-m-d H:i:s', filemtime($backup));
                echo "  • " . basename($backup) . " ({$size} MB) - {$date}\n";
            }
        }
    }
    
    exit(1);
}

// Check if backup file exists
if (!file_exists($backupFile)) {
    echo "❌ Error: File '{$backupFile}' tidak ditemukan!\n";
    exit(1);
}

// Railway MySQL Configuration
$host = $_ENV['DB_HOST'] ?? 'viaduct.proxy.rlwy.net';
$port = $_ENV['DB_PORT'] ?? '3306';
$database = $_ENV['DB_DATABASE'] ?? 'railway';
$username = $_ENV['DB_USERNAME'] ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? '';

echo "🔄 Starting database restore to Railway...\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Source: {$backupFile}\n";
echo "Target Database: {$database}\n";
echo "Host: {$host}:{$port}\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Confirmation
echo "⚠️  PERINGATAN: Ini akan menimpa data di database Railway!\n";
echo "Apakah Anda yakin? (yes/no): ";
$handle = fopen("php://stdin", "r");
$confirmation = trim(fgets($handle));
fclose($handle);

if (strtolower($confirmation) !== 'yes') {
    echo "\n❌ Restore dibatalkan.\n";
    exit(0);
}

echo "\n🔄 Memulai restore...\n";

// Test connection first
try {
    $dsn = "mysql:host={$host};port={$port};charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 10,
    ]);
    
    echo "✅ Koneksi ke Railway berhasil!\n";
    
    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$database}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✅ Database '{$database}' siap!\n\n";
    
    $pdo = null; // Close connection
    
} catch (PDOException $e) {
    echo "❌ Koneksi ke Railway gagal!\n";
    echo "Error: " . $e->getMessage() . "\n\n";
    echo "💡 Troubleshooting:\n";
    echo "  1. Cek Railway Variables sudah benar\n";
    echo "  2. Pastikan MySQL service running di Railway\n";
    echo "  3. Cek file .env sudah diupdate dengan Railway credentials\n";
    exit(1);
}

// Build mysql command
$passwordArg = $password ? "-p\"{$password}\"" : '';
$command = "mysql -u {$username} {$passwordArg} -h {$host} -P {$port} {$database} < \"{$backupFile}\" 2>&1";

// Execute restore
echo "⏳ Importing data...\n";
$startTime = microtime(true);

exec($command, $output, $returnCode);

$endTime = microtime(true);
$duration = round($endTime - $startTime, 2);

if ($returnCode === 0) {
    echo "✅ Restore berhasil!\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "Duration: {$duration} seconds\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    
    // Verify data
    echo "🔍 Verifying data...\n";
    try {
        $dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        
        // Get table count
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $tableCount = count($tables);
        
        echo "✅ Database verification:\n";
        echo "  • Tables: {$tableCount}\n";
        
        // Show some table info
        foreach (array_slice($tables, 0, 5) as $table) {
            $stmt = $pdo->query("SELECT COUNT(*) FROM `{$table}`");
            $count = $stmt->fetchColumn();
            echo "  • {$table}: {$count} rows\n";
        }
        
        if ($tableCount > 5) {
            echo "  • ... dan " . ($tableCount - 5) . " tabel lainnya\n";
        }
        
    } catch (PDOException $e) {
        echo "⚠️  Warning: Tidak bisa verifikasi data\n";
        echo "Error: " . $e->getMessage() . "\n";
    }
    
    echo "\n✅ Migrasi database selesai!\n";
    echo "\n💡 Next steps:\n";
    echo "  1. Test koneksi: php artisan tinker\n";
    echo "  2. Run migrations: php artisan migrate\n";
    echo "  3. Clear cache: php artisan config:clear\n";
    echo "  4. Test aplikasi di Railway\n";
    
} else {
    echo "❌ Restore gagal!\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    
    if (!empty($output)) {
        echo "Error output:\n";
        foreach ($output as $line) {
            echo "  {$line}\n";
        }
    }
    
    echo "\n💡 Troubleshooting:\n";
    echo "  1. Pastikan mysql client terinstall\n";
    echo "  2. Cek Railway credentials di .env\n";
    echo "  3. Pastikan Railway MySQL service running\n";
    echo "  4. Cek koneksi internet\n";
    echo "  5. Cek file backup tidak corrupt\n";
    
    exit(1);
}
