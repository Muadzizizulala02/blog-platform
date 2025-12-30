<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$post = App\Models\Post::latest()->first();
echo "Post ID: " . $post->id . "\n";
echo "Title: " . $post->title . "\n";
echo "Published At: " . ($post->published_at ? $post->published_at->toDateTimeString() : "NULL") . "\n";
echo "Created At: " . $post->created_at->toDateTimeString() . "\n";
echo "Is Published: " . ($post->published_at && $post->published_at <= now() ? "YES" : "NO") . "\n";
