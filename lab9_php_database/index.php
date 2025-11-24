<?php
include("koneksi.php");

$sql = "SELECT * FROM data_user";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link href="style.css" rel="stylesheet" type="text/css" />
<title>Data user</title>
</head>
<body>

<div class="container">
    <h1>Data user</h1>
    <a href="tambah.php">Tambah user</a><br><br>

    <div class="main">
        <table>
            <tr>
                <th>Gambar</th>
                <th>Nama user</th>
                <th>Kategori</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>

            <?php if($result): ?>
            <?php while($row = mysqli_fetch_array($result)): ?>
            <tr>
                <td><?= $row['gambar']; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['kategori']; ?></td>

                <!-- urutan harga sesuai gambar -->
                <td><?= $row['harga_jual']; ?></td>
                <td><?= $row['harga_beli']; ?></td>

                <td><?= $row['stok']; ?></td>

                <td>
                    <a href="ubah.php?id=<?= $row['id_user']; ?>">Ubah</a>
                    &nbsp;
                    <a href="hapus.php?id=<?= $row['id_user']; ?>">Hapus</a>
                </td>
            </tr>
            <?php endwhile; else: ?>
            <tr>
                <td colspan="7">Belum ada data</td>
            </tr>
            <?php endif; ?>

        </table>
    </div>
</div>

</body>
</html>
