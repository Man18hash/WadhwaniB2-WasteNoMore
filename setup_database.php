<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Run migrations
    Artisan::call('migrate', ['--force' => true]);
    echo "✅ Migrations completed successfully!<br>";
    
    // Run seeders
    Artisan::call('db:seed', ['--force' => true]);
    echo "✅ Database seeded successfully!<br>";
    
    echo "🎉 Database setup complete!";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
