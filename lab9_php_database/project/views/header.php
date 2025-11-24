<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$current_page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Barang - UPB</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo">
                <h1>📦 Sistem Barang</h1>
            </div>
            <nav class="main-nav">
                <a href="index.php?page=dashboard" class="nav-link <?= $current_page == 'dashboard' ? 'active' : '' ?>">Dashboard</a>
                <a href="index.php?page=barang/list" class="nav-link <?= $current_page == 'barang/list' ? 'active' : '' ?>">Data Barang</a>
                <a href="index.php?page=barang/add" class="nav-link <?= $current_page == 'barang/add' ? 'active' : '' ?>">Tambah Barang</a>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="index.php?page=auth/logout" class="nav-link logout">Logout</a>
                <?php else: ?>
                    <a href="index.php?page=auth/login" class="nav-link login">Login</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main">
        <div class="container">
            <div class="content">