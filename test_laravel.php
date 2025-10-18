<?php
// Simple Laravel bootstrap test
echo "<h1>Laravel Bootstrap Test</h1>";

try {
    echo "Loading autoloader...<br>";
    require_once 'vendor/autoload.php';
    echo "✅ Autoloader loaded<br>";
    
    echo "Loading Laravel app...<br>";
    $app = require_once 'bootstrap/app.php';
    echo "✅ Laravel app loaded<br>";
    
    echo "Bootstrapping kernel...<br>";
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    echo "✅ Kernel bootstrapped<br>";
    
    echo "<h2>Environment Check:</h2>";
    echo "APP_NAME: " . env('APP_NAME', 'NOT SET') . "<br>";
    echo "APP_ENV: " . env('APP_ENV', 'NOT SET') . "<br>";
    echo "APP_KEY: " . (env('APP_KEY') ? 'SET' : 'NOT SET') . "<br>";
    echo "DB_CONNECTION: " . env('DB_CONNECTION', 'NOT SET') . "<br>";
    echo "DB_HOST: " . env('DB_HOST', 'NOT SET') . "<br>";
    echo "DB_DATABASE: " . env('DB_DATABASE', 'NOT SET') . "<br>";
    
    echo "<h2>✅ Laravel is working!</h2>";
    
} catch (Exception $e) {
    echo "<h2>❌ Error:</h2>";
    echo $e->getMessage();
    echo "<br><br>";
    echo "<h3>Stack Trace:</h3>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
