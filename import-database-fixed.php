<?php
/**
 * Script untuk import database ke MySQL Railway (Fixed Version)
 * Usage: php import-database-fixed.php
 */

$host = 'switchback.proxy.rlwy.net';
$port = 13835;
$database = 'railway';
$username = 'root';
$password = 'hcveiHoZjeqZWwSjmCQTkocDqfeRQyvO';
$sqlFile = __DIR__ . '/../galeri-sekolah-elfa.sql';

echo "═══════════════════════════════════════════════════════════\n";
echo "  Import Database ke MySQL Railway (Fixed)\n";
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
    
    // Fix TEXT columns with default values (MySQL 8+ doesn't allow this)
    $sql = preg_replace('/\b(text|longtext)\s+NOT\s+NULL\s+DEFAULT\s+[\'"]/i', '$1 NOT NULL', $sql);
    
    // Remove comments
    $sql = preg_replace('/--.*$/m', '', $sql);
    $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);
    
    // Split into individual statements
    $statements = [];
    $current = '';
    $inString = false;
    $stringChar = '';
    
    for ($i = 0; $i < strlen($sql); $i++) {
        $char = $sql[$i];
        $prev = $i > 0 ? $sql[$i - 1] : '';
        
        // Handle string literals
        if (($char == '"' || $char == "'") && $prev != '\\') {
            if (!$inString) {
                $inString = true;
                $stringChar = $char;
            } elseif ($char == $stringChar) {
                $inString = false;
                $stringChar = '';
            }
        }
        
        $current .= $char;
        
        // If we hit a semicolon and we're not in a string, end the statement
        if ($char == ';' && !$inString) {
            $stmt = trim($current);
            if (!empty($stmt) && 
                !preg_match('/^(SET|START|COMMIT|\/\*|\s*$)/i', $stmt)) {
                $statements[] = $stmt;
            }
            $current = '';
        }
    }
    
    // Add remaining statement if any
    if (!empty(trim($current))) {
        $statements[] = trim($current);
    }
    
    $total = count($statements);
    $success = 0;
    $errors = 0;
    $skipped = 0;
    
    echo "📝 Menjalankan $total statement...\n\n";
    
    foreach ($statements as $index => $statement) {
        if (empty(trim($statement))) {
            continue;
        }
        
        try {
            $pdo->exec($statement);
            $success++;
            
            if (($index + 1) % 20 == 0) {
                echo "   Progress: " . ($index + 1) . "/$total statements\n";
            }
        } catch (PDOException $e) {
            $errorMsg = $e->getMessage();
            
            // Skip known non-critical errors
            if (strpos($errorMsg, 'already exists') !== false ||
                strpos($errorMsg, 'Duplicate entry') !== false ||
                strpos($errorMsg, 'Duplicate key') !== false) {
                $skipped++;
                continue;
            }
            
            $errors++;
            echo "   ⚠️  Error pada statement " . ($index + 1) . ": " . substr($errorMsg, 0, 100) . "\n";
        }
    }
    
    echo "\n═══════════════════════════════════════════════════════════\n";
    echo "  Import Selesai!\n";
    echo "═══════════════════════════════════════════════════════════\n";
    echo "✅ Berhasil: $success statements\n";
    if ($skipped > 0) {
        echo "⏭️  Dilewati: $skipped statements (sudah ada)\n";
    }
    if ($errors > 0) {
        echo "⚠️  Errors: $errors statements\n";
    }
    echo "\n✅ Database berhasil diimport ke Railway!\n";
    
    // Verify tables
    echo "\n📋 Daftar tabel yang berhasil dibuat:\n";
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    foreach ($tables as $table) {
        $count = $pdo->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
        echo "   - $table ($count rows)\n";
    }
    
} catch (PDOException $e) {
    die("❌ Error: " . $e->getMessage() . "\n");
}

