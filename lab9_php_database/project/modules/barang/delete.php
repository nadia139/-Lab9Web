<?php
require_once('config/database.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Cek apakah barang exists
    $check = mysqli_query($conn, "SELECT id_barang FROM data_barang WHERE id_barang = $id");
    
    if (mysqli_num_rows($check) > 0) {
        // Delete barang
        $query = "DELETE FROM data_barang WHERE id_barang = $id";
        
        if (mysqli_query($conn, $query)) {
            $_SESSION['success'] = "Barang berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Error menghapus barang: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error'] = "Barang tidak ditemukan!";
    }
} else {
    $_SESSION['error'] = "ID barang tidak valid!";
}

header("Location: index.php?page=barang/list");
exit();
?>