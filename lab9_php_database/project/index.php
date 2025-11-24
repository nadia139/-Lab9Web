<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Define base path
define('BASE_PATH', __DIR__);

// Basic router
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Mapping halaman dengan pengecekan file
$pages = [
    'dashboard' => 'views/dashboard.php',
    'barang/list' => 'modules/barang/list.php',
    'barang/add' => 'modules/barang/add.php',
    'barang/edit' => 'modules/barang/edit.php',
    'barang/delete' => 'modules/barang/delete.php',
    'auth/login' => 'modules/auth/login.php',
    'auth/logout' => 'modules/auth/logout.php'
];

// Debug: Tampilkan informasi path
echo "<!-- Debug: BASE_PATH = " . BASE_PATH . " -->";
echo "<!-- Debug: Requested page = " . $page . " -->";

// Cek apakah header.php ada
$header_path = BASE_PATH . '/views/header.php';
if (!file_exists($header_path)) {
    die("❌ ERROR: Header file not found at: " . $header_path);
}

// Include header
require_once('views/header.php');

// Cek jika halaman ada
if (array_key_exists($page, $pages)) {
    $page_path = BASE_PATH . '/' . $pages[$page];
    
    // Debug
    echo "<!-- Debug: Page path = " . $page_path . " -->";
    
    if (file_exists($page_path)) {
        require_once($pages[$page]);
    } else {
        echo '<div class="content">';
        echo '<h2>❌ File Tidak Ditemukan</h2>';
        echo '<p>File untuk halaman <strong>"' . htmlspecialchars($page) . '"</strong> tidak ditemukan.</p>';
        echo '<p>Path: ' . $page_path . '</p>';
        echo '<a href="index.php?page=dashboard" class="btn btn-primary">Kembali ke Dashboard</a>';
        echo '</div>';
    }
} else {
    // Halaman tidak ditemukan
    echo '<div class="content">';
    echo '<h2>404 - Halaman Tidak Ditemukan</h2>';
    echo '<p>Halaman <strong>"' . htmlspecialchars($page) . '"</strong> tidak ada dalam sistem.</p>';
    echo '<a href="index.php?page=dashboard" class="btn btn-primary">Kembali ke Dashboard</a>';
    echo '</div>';
}

// Cek apakah footer.php ada
$footer_path = BASE_PATH . '/views/footer.php';
if (!file_exists($footer_path)) {
    echo "<p>❌ Footer file missing</p>";
    echo "</div></body></html>";
} else {
    require_once('views/footer.php');
}
?>