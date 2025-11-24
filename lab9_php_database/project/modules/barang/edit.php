<?php
require_once('config/database.php');
require_once('views/header.php');

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
        $destination = dirname(__FILE__) . '/../../gambar/' . $filename;

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
    header('location: index.php?page=barang/list');
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

<div class="content">
    <div class="page-header">
        <h1>✏️ Edit Barang</h1>
        <p>Update data barang yang sudah ada</p>
    </div>

    <div class="form-container">
        <form method="post" action="" enctype="multipart/form-data" class="modern-form">
            <input type="hidden" name="id" value="<?= $data['id_barang']; ?>">

            <div class="form-group">
                <label for="nama">Nama Barang</label>
                <input type="text" id="nama" name="nama" value="<?= $data['nama']; ?>" required>
            </div>

            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select id="kategori" name="kategori" required>
                    <option value="Komputer" <?= is_select('Komputer', $data['kategori']); ?>>Komputer</option>
                    <option value="Elektronik" <?= is_select('Elektronik', $data['kategori']); ?>>Elektronik</option>
                    <option value="Hand Phone" <?= is_select('Hand Phone', $data['kategori']); ?>>Hand Phone</option>
                </select>
            </div>

            <div class="form-group">
                <label for="harga_jual">Harga Jual</label>
                <input type="number" id="harga_jual" name="harga_jual" value="<?= $data['harga_jual']; ?>" required>
            </div>

            <div class="form-group">
                <label for="harga_beli">Harga Beli</label>
                <input type="number" id="harga_beli" name="harga_beli" value="<?= $data['harga_beli']; ?>" required>
            </div>

            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" id="stok" name="stok" value="<?= $data['stok']; ?>" required>
            </div>

            <div class="form-group">
                <label for="file_gambar">File Gambar</label>
                <input type="file" id="file_gambar" name="file_gambar" accept="image/*">
                <?php if ($data['gambar']): ?>
                    <div class="current-image">
                        <small>Gambar saat ini: <?= $data['gambar']; ?></small>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit" class="btn btn-primary">💾 Update Barang</button>
                <a href="index.php?page=barang/list" class="btn btn-outline">❌ Batal</a>
            </div>
        </form>
    </div>
</div>

<?php require_once('views/footer.php'); ?>