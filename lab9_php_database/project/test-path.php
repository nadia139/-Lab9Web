<?php
// test-path.php - Check actual file paths
echo "<h2>🔍 Debug Path Information</h2>";

echo "<strong>Current Directory:</strong> " . __DIR__ . "<br>";
echo "<strong>Working Directory:</strong> " . getcwd() . "<br>";

$files_to_check = [
    'views/header.php',
    'views/footer.php',
    'views/dashboard.php',
    'config/database.php',
    'index.php'
];

echo "<h3>📁 File Check:</h3>";
foreach ($files_to_check as $file) {
    $full_path = __DIR__ . '/' . $file;
    if (file_exists($full_path)) {
        echo "✅ $file - EXISTS<br>";
        echo "&nbsp;&nbsp;&nbsp;&nbsp;Path: $full_path<br>";
    } else {
        echo "❌ $file - MISSING<br>";
        echo "&nbsp;&nbsp;&nbsp;&nbsp;Tried: $full_path<br>";
    }
}

echo "<h3>🌐 URL Test Links:</h3>";
echo '<a href="index.php">Test index.php</a><br>';
echo '<a href="index.php?page=dashboard">Test Dashboard</a><br>';

// Test require directly
echo "<h3>🧪 Direct Require Test:</h3>";
try {
    if (file_exists(__DIR__ . '/views/header.php')) {
        require_once __DIR__ . '/views/header.php';
        echo "✅ Header loaded successfully!<br>";
    } else {
        echo "❌ Header file not found at: " . __DIR__ . '/views/header.php<br>';
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}
?>