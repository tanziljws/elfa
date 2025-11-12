<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Gallery;

echo "=== TEST FOTO GALERI ===\n\n";

$galleries = Gallery::all();

if ($galleries->count() == 0) {
    echo "❌ Tidak ada foto di database\n";
    exit;
}

echo "✅ Ditemukan " . $galleries->count() . " foto di database\n\n";

foreach ($galleries as $gallery) {
    echo "📸 Foto: " . $gallery->title . "\n";
    echo "   Path: " . $gallery->image_path . "\n";
    echo "   URL: " . $gallery->image_url . "\n";
    
    // Check if file exists
    $fullPath = storage_path('app/public/' . $gallery->image_path);
    if (file_exists($fullPath)) {
        echo "   ✅ File exists (" . number_format(filesize($fullPath) / 1024, 2) . " KB)\n";
    } else {
        echo "   ❌ File NOT found\n";
    }
    
    echo "   Status: " . ($gallery->is_active ? '✅ Aktif' : '❌ Tidak Aktif') . "\n";
    echo "   Kategori: " . $gallery->category . "\n\n";
}

echo "=== SUMMARY ===\n";
echo "Total foto: " . $galleries->count() . "\n";
echo "Foto aktif: " . $galleries->where('is_active', true)->count() . "\n";
echo "Foto tidak aktif: " . $galleries->where('is_active', false)->count() . "\n";
