<?php
error_reporting(E_ALL);
include_once 'koneksi.php';

if (isset($_POST['submit'])) {

    $id         = $_POST['id'];
    $nama       = $_POST['nama'];
    $kategori   = $_POST['kategori'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok       = $_POST['stok'];
    $file_gambar = $_FILES['file_gambar'];

    $gambar = null;

    if ($file_gambar['error'] == 0) {
        $filename    = str_replace(' ', '_', $file_gambar['name']);
        $destination = dirname(__FILE__) . '/gambar/' . $filename;

        if (move_uploaded_file($file_gambar['tmp_name'], $destination)) {
            $gambar = $filename;
        }
    }

    $sql  = "UPDATE data_barang SET ";
    $sql .= "nama = '{$nama}', kategori = '{$kategori}', ";
    $sql .= "harga_jual = '{$harga_jual}', harga_beli = '{$harga_beli}', ";
    $sql .= "stok = '{$stok}' ";

    if (!empty($gambar)) {
        $sql .= ", gambar = '{$gambar}' ";
    }

    $sql .= "WHERE id_barang = '{$id}'";

    mysqli_query($conn, $sql);
    header('location: index.php');
}

$id  = $_GET['id'];
$sql = "SELECT * FROM data_barang WHERE id_barang = '{$id}'";
$result = mysqli_query($conn, $sql);

if (!$result) die('Error: Data tidak tersedia');

$data = mysqli_fetch_array($result);

function is_select($val, $current) {
    return ($val == $current) ? 'selected="selected"' : '';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link href="style.css" rel="stylesheet" type="text/css" />
<title>Ubah Barang</title>

<style>
    .input { margin-bottom: 12px; }
    label { display: inline-block; width: 120px; }
    input[type="text"], select {
        width: 200px;
        padding: 4px;
    }
    .submit input {
        background: blue;
        color: white;
        padding: 6px 16px;
        border: none;
        cursor: pointer;
    }
</style>

</head>
<body>

<div class="container">
    <h1>Ubah Barang</h1>
    <div class="main">

        <form method="post" action="ubah.php" enctype="multipart/form-data">

            <div class="input">
                <label>Nama Barang</label>
                <input type="text" name="nama" value="<?= $data['nama']; ?>" />
            </div>

            <div class="input">
                <label>Kategori</label>
                <select name="kategori">
                    <option value="Komputer"   <?= is_select('Komputer', $data['kategori']); ?>>Komputer</option>
                    <option value="Elektronik" <?= is_select('Elektronik', $data['kategori']); ?>>
