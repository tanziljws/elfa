<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

$user = User::find(3);

echo "Before update:\n";
echo "Name: " . $user->name . "\n";
echo "Profile Photo: " . ($user->profile_photo ?? 'NULL') . "\n\n";

// Simulate update
$user->profile_photo = 'images/profiles/profile_3_1759985093.jpg';
$saved = $user->save();

echo "Save result: " . ($saved ? 'SUCCESS' : 'FAILED') . "\n\n";

// Reload from database
$user = User::find(3);
echo "After update (reloaded from DB):\n";
echo "Name: " . $user->name . "\n";
echo "Profile Photo: " . ($user->profile_photo ?? 'NULL') . "\n";
