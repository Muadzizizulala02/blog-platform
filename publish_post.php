<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$post = App\Models\Post::latest()->first();
$post->update(['published_at' => now()]);
echo "Post updated! Published At: " . $post->published_at->toDateTimeString() . "\n";
