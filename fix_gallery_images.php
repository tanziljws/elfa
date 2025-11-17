<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Gallery;

echo "=== FIXING GALLERY IMAGES ===\n\n";

$galleries = Gallery::where('image_path', 'like', 'https://via.placeholder.com%')->get();

$placeholderFiles = [
    'gallery/placeholder1.jpg',
    'gallery/placeholder2.jpg', 
    'gallery/placeholder3.jpg',
    'gallery/placeholder4.jpg',
    'gallery/placeholder5.jpg',
    'gallery/placeholder6.jpg',
    'gallery/placeholder7.jpg'
];

$index = 0;
foreach ($galleries as $gallery) {
    if ($index < count($placeholderFiles)) {
        $oldPath = $gallery->image_path;
        $newPath = $placeholderFiles[$index];
        
        $gallery->update(['image_path' => $newPath]);
        
        echo "✅ Updated: " . $gallery->title . "\n";
        echo "   Old: " . $oldPath . "\n";
        echo "   New: " . $newPath . "\n\n";
        
        $index++;
    }
}

echo "=== VERIFICATION ===\n";
$allGalleries = Gallery::all();
foreach ($allGalleries as $gallery) {
    $fullPath = storage_path('app/public/' . $gallery->image_path);
    $exists = file_exists($fullPath) ? '✅' : '❌';
    echo "$exists " . $gallery->title . " -> " . $gallery->image_path . "\n";
}

echo "\n=== COMPLETED ===\n";
echo "Total galleries: " . $allGalleries->count() . "\n";
echo "All images should now be accessible!\n";
