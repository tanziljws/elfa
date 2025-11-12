<?php
// Script to create placeholder images for gallery seeder

$placeholders = [
    'upacara.jpg' => ['Upacara Bendera', '#667eea'],
    'pramuka.jpg' => ['Kegiatan Pramuka', '#764ba2'],
    'pentas.jpg' => ['Pentas Seni', '#ff6b6b'],
    'perpustakaan.jpg' => ['Perpustakaan', '#4ecdc4'],
    'lab.jpg' => ['Lab Komputer', '#45b7d1'],
    'basket.jpg' => ['Basket', '#96ceb4'],
    'kemerdekaan.jpg' => ['17 Agustus', '#feca57'],
    'kantin.jpg' => ['Kantin', '#ff9ff3']
];

$targetDir = 'public/images/placeholders/';

if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

foreach ($placeholders as $filename => $data) {
    $text = $data[0];
    $color = $data[1];
    
    // Create a simple colored rectangle image
    $width = 400;
    $height = 300;
    
    $image = imagecreate($width, $height);
    
    // Convert hex color to RGB
    $hex = ltrim($color, '#');
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    
    $bgColor = imagecolorallocate($image, $r, $g, $b);
    $textColor = imagecolorallocate($image, 255, 255, 255);
    
    // Fill background
    imagefill($image, 0, 0, $bgColor);
    
    // Add text (if GD supports it)
    if (function_exists('imagettftext')) {
        // Try to use a font if available
        $fontSize = 16;
        $textBox = imagettfbbox($fontSize, 0, __DIR__ . '/arial.ttf', $text);
        if ($textBox === false) {
            // Fallback to imagestring if TTF fails
            $x = ($width - strlen($text) * 10) / 2;
            $y = ($height - 15) / 2;
            imagestring($image, 5, $x, $y, $text, $textColor);
        }
    } else {
        // Simple text placement
        $x = ($width - strlen($text) * 10) / 2;
        $y = ($height - 15) / 2;
        imagestring($image, 5, $x, $y, $text, $textColor);
    }
    
    // Save as JPEG
    $filepath = $targetDir . $filename;
    imagejpeg($image, $filepath, 85);
    imagedestroy($image);
    
    echo "Created: $filepath\n";
}

echo "All placeholder images created successfully!\n";
