<?php
$photoPath = __DIR__ . '/images/profiles/profile_3_1759985093.jpg';

echo "<h2>Testing Profile Photo Access</h2>";
echo "<p><strong>Photo Path:</strong> " . $photoPath . "</p>";
echo "<p><strong>File Exists:</strong> " . (file_exists($photoPath) ? 'YES' : 'NO') . "</p>";

if (file_exists($photoPath)) {
    echo "<p><strong>File Size:</strong> " . filesize($photoPath) . " bytes</p>";
    echo "<p><strong>Is Readable:</strong> " . (is_readable($photoPath) ? 'YES' : 'NO') . "</p>";
    echo "<hr>";
    echo "<h3>Photo Preview:</h3>";
    echo "<img src='/images/profiles/profile_3_1759985093.jpg' alt='Profile Photo' style='max-width: 200px; border: 2px solid #ccc;'>";
}
?>
