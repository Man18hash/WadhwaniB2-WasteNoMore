<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$key = 'base64:' . base64_encode(random_bytes(32));
echo "Your APP_KEY is: " . $key;
?>
