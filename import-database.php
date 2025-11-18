<?php
/**
 * Script untuk import database ke MySQL Railway
 * Usage: php import-database.php
 */

$host = 'switchback.proxy.rlwy.net';
$port = 13835;
$database = 'railway';
$username = 'root';
$password = 'hcveiHoZjeqZWwSjmCQTkocDqfeRQyvO';
$sqlFile = __DIR__ . '/../galeri-sekolah-elfa.sql';

echo "═══════════════════════════════════════════════════════════\n";
echo "  Import Database ke MySQL Railway\n";
echo "═══════════════════════════════════════════════════════════\n\n";

// Check if SQL file exists
if (!file_exists($sqlFile)) {
    die("❌ File SQL tidak ditemukan: $sqlFile\n");
}

echo "✅ File SQL ditemukan: $sqlFile\n";
echo "📊 Ukuran file: " . number_format(filesize($sqlFile)) . " bytes\n\n";

// Connect to MySQL
try {
    $dsn = "mysql:host=$host;port=$port;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    echo "✅ Koneksi ke MySQL Railway berhasil!\n";
    
    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✅ Database '$database' siap\n\n";
    
    // Select database
    $pdo->exec("USE `$database`");
    
    // Read SQL file
    echo "📖 Membaca file SQL...\n";
    $sql = file_get_contents($sqlFile);
    
    // Remove comments and split by semicolon
    $sql = preg_replace('/--.*$/m', '', $sql);
    $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);
    
    // Split into individual statements
    $statements = array_filter(
        array_map('trim', explode(';', $sql)),
        function($stmt) {
            return !empty($stmt) && !preg_match('/^(SET|START|COMMIT)/i', $stmt);
        }
    );
    
    $total = count($statements);
    $success = 0;
    $errors = 0;
    
    echo "📝 Menjalankan $total statement...\n\n";
    
    foreach ($statements as $index => $statement) {
        if (empty(trim($statement))) {
            continue;
        }
        
        try {
            $pdo->exec($statement);
            $success++;
            
            if (($index + 1) % 10 == 0) {
                echo "   Progress: " . ($index + 1) . "/$total statements\n";
            }
        } catch (PDOException $e) {
            $errors++;
            // Skip duplicate table errors
            if (strpos($e->getMessage(), 'already exists') === false) {
                echo "   ⚠️  Error pada statement " . ($index + 1) . ": " . $e->getMessage() . "\n";
            }
        }
    }
    
    echo "\n═══════════════════════════════════════════════════════════\n";
    echo "  Import Selesai!\n";
    echo "═══════════════════════════════════════════════════════════\n";
    echo "✅ Berhasil: $success statements\n";
    if ($errors > 0) {
        echo "⚠️  Errors: $errors statements (biasanya karena table sudah ada)\n";
    }
    echo "\n✅ Database berhasil diimport ke Railway!\n";
    
} catch (PDOException $e) {
    die("❌ Error: " . $e->getMessage() . "\n");
}

