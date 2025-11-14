<?php
/**
 * Script untuk Backup Database XAMPP MySQL
 * 
 * Usage: php backup-database.php
 */

require __DIR__ . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Configuration
$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$port = $_ENV['DB_PORT'] ?? '3307';
$database = $_ENV['DB_DATABASE'] ?? 'galeri-sekolah-elfa';
$username = $_ENV['DB_USERNAME'] ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? '';

// Backup directory
$backupDir = __DIR__ . '/database/backups';
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0755, true);
}

// Backup filename with timestamp
$timestamp = date('Y-m-d_His');
$backupFile = $backupDir . "/backup_{$database}_{$timestamp}.sql";

echo "🔄 Starting database backup...\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Database: {$database}\n";
echo "Host: {$host}:{$port}\n";
echo "Backup file: {$backupFile}\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Build mysqldump command
$passwordArg = $password ? "-p\"{$password}\"" : '';
$command = "mysqldump -u {$username} {$passwordArg} -h {$host} -P {$port} {$database} > \"{$backupFile}\" 2>&1";

// Execute backup
exec($command, $output, $returnCode);

if ($returnCode === 0 && file_exists($backupFile)) {
    $fileSize = filesize($backupFile);
    $fileSizeMB = round($fileSize / 1024 / 1024, 2);
    
    echo "✅ Backup berhasil!\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "File: {$backupFile}\n";
    echo "Size: {$fileSizeMB} MB\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    
    // List all backups
    echo "📦 Daftar Backup:\n";
    $backups = glob($backupDir . "/*.sql");
    rsort($backups);
    
    foreach (array_slice($backups, 0, 5) as $backup) {
        $size = round(filesize($backup) / 1024 / 1024, 2);
        $date = date('Y-m-d H:i:s', filemtime($backup));
        echo "  • " . basename($backup) . " ({$size} MB) - {$date}\n";
    }
    
    echo "\n💡 Tip: Simpan file backup ini sebelum migrasi ke Railway!\n";
    
} else {
    echo "❌ Backup gagal!\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    
    if (!empty($output)) {
        echo "Error output:\n";
        foreach ($output as $line) {
            echo "  {$line}\n";
        }
    }
    
    echo "\n💡 Troubleshooting:\n";
    echo "  1. Pastikan mysqldump terinstall\n";
    echo "  2. Cek credentials di file .env\n";
    echo "  3. Pastikan XAMPP MySQL running\n";
    echo "  4. Cek port MySQL (default XAMPP: 3307)\n";
    
    exit(1);
}
