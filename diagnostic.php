<?php
// Simple diagnostic file to check server status
echo "<h1>Server Diagnostic</h1>";
echo "<h2>PHP Version:</h2>";
echo phpversion();
echo "<br><br>";

echo "<h2>File Permissions:</h2>";
echo "storage/ directory exists: " . (is_dir('storage') ? "YES" : "NO") . "<br>";
echo "storage/ writable: " . (is_writable('storage') ? "YES" : "NO") . "<br>";
echo "bootstrap/cache/ exists: " . (is_dir('bootstrap/cache') ? "YES" : "NO") . "<br>";
echo "bootstrap/cache/ writable: " . (is_writable('bootstrap/cache') ? "YES" : "NO") . "<br>";
echo "<br>";

echo "<h2>Files Check:</h2>";
echo ".env file exists: " . (file_exists('.env') ? "YES" : "NO") . "<br>";
echo "vendor/autoload.php exists: " . (file_exists('vendor/autoload.php') ? "YES" : "NO") . "<br>";
echo "bootstrap/app.php exists: " . (file_exists('bootstrap/app.php') ? "YES" : "NO") . "<br>";
echo "<br>";

echo "<h2>Directory Listing:</h2>";
$files = scandir('.');
foreach($files as $file) {
    if($file != '.' && $file != '..') {
        echo $file . "<br>";
    }
}
?>
