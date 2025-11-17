<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\News;

echo "Daftar Berita:\n";
echo "==============\n";

$news = News::all();
foreach($news as $n) {
    echo "Judul: " . $n->title . "\n";
    echo "Published At: " . $n->published_at . "\n";
    echo "Active: " . ($n->is_active ? 'Yes' : 'No') . "\n";
    echo "Published (will appear in news page): " . ($n->published_at <= now() && $n->is_active ? 'Yes' : 'No') . "\n";
    echo "------------------------\n";
}

echo "Total berita: " . $news->count() . "\n";
echo "Total berita aktif: " . $news->where('is_active', true)->count() . "\n";
echo "Total berita yang akan muncul di halaman berita: " . $news->where('is_active', true)->where('published_at', '<=', now())->count() . "\n";