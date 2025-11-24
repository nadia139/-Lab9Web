<?php
require_once('config/database.php');
require_once('views/header.php'); 

// Inisialisasi variabel
$errors = [];
$success = false;

if (isset($_POST['submit']))
{
    // Ambil data dari form
    $nama        = mysqli_real_escape_string($conn, $_POST['nama']);
    $kategori    = mysqli_real_escape_string($conn, $_POST['kategori']);
    $harga_jual  = mysqli_real_escape_string($conn, $_POST['harga_jual']);
    $harga_beli  = mysqli_real_escape_string($conn, $_POST['harga_beli']);
    $stok        = mysqli_real_escape_string($conn, $_POST['stok']);
    $file_gambar = $_FILES['file_gambar'];

    $gambar = null;

    // Validasi form
    if (empty($nama)) {
        $errors[] = "Nama barang harus diisi";
    }
    if (empty($kategori)) {
        $errors[] = "Kategori harus dipilih";
    }
    if (empty($harga_jual) || $harga_jual < 0) {
        $errors[] = "Harga jual harus diisi dan tidak boleh negatif";
    }
    if (empty($harga_beli) || $harga_beli < 0) {
        $errors[] = "Harga beli harus diisi dan tidak boleh negatif";
    }
    if (empty($stok) || $stok < 0) {
        $errors[] = "Stok harus diisi dan tidak boleh negatif";
    }

    // Proses upload gambar
    if ($file_gambar['error'] == 0) {
        // Cek tipe file
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        $file_type = $file_gambar['type'];
        
        if (!in_array($file_type, $allowed_types)) {
            $errors[] = "Hanya file gambar (JPEG, PNG, GIF) yang diizinkan";
        } else {
            $filename = str_replace(' ', '_', $file_gambar['name']);
            $destination = dirname(__DIR__) . '/../gambar/' . $filename; // Path yang diperbaiki

            if(move_uploaded_file($file_gambar['tmp_name'], $destination)) {
                $gambar = $filename;
            } else {
                $errors[] = "Gagal mengupload gambar";
            }
        }
    }

    // Jika tidak ada error, simpan ke database
    if (empty($errors)) {
        $sql = "INSERT INTO data_barang (nama, kategori, harga_jual, harga_beli, stok, gambar)
                VALUES ('$nama', '$kategori', '$harga_jual', '$harga_beli', '$stok', " . ($gambar ? "'$gambar'" : "NULL") . ")";

        if(mysqli_query($conn, $sql)) {
            $success = true;
            $_SESSION['success'] = "Barang berhasil ditambahkan!";
            header('location: index.php?page=barang/list');
            exit();
        } else {
            $errors[] = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<div class="content">
    <div class="page-header">
        <h1>➕ Tambah Barang</h1>
        <p>Tambahkan barang baru ke dalam sistem</p>
    </div>

    <!-- Tampilkan pesan error -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <h4>❌ Terjadi Kesalahan:</h4>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Tampilkan pesan sukses -->
    <?php if ($success): ?>
        <div class="alert alert-success">
            <h4>✅ Berhasil!</h4>
            <p>Barang berhasil ditambahkan ke database.</p>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <form method="post" action="" enctype="multipart/form-data" class="modern-form">
            <div class="form-group">
                <label for="nama">Nama Barang *</label>
                <input type="text" id="nama" name="nama" value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="kategori">Kategori *</label>
                <select id="kategori" name="kategori" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Komputer" <?php echo (isset($_POST['kategori']) && $_POST['kategori'] == 'Komputer') ? 'selected' : ''; ?>>Komputer</option>
                    <option value="Elektronik" <?php echo (isset($_POST['kategori']) && $_POST['kategori'] == 'Elektronik') ? 'selected' : ''; ?>>Elektronik</option>
                    <option value="Hand Phone" <?php echo (isset($_POST['kategori']) && $_POST['kategori'] == 'Hand Phone') ? 'selected' : ''; ?>>Hand Phone</option>
                </select>
            </div>

            <div class="form-group">
                <label for="harga_jual">Harga Jual *</label>
                <input type="number" id="harga_jual" name="harga_jual" value="<?php echo isset($_POST['harga_jual']) ? htmlspecialchars($_POST['harga_jual']) : ''; ?>" min="0" required>
            </div>

            <div class="form-group">
                <label for="harga_beli">Harga Beli *</label>
                <input type="number" id="harga_beli" name="harga_beli" value="<?php echo isset($_POST['harga_beli']) ? htmlspecialchars($_POST['harga_beli']) : ''; ?>" min="0" required>
            </div>

            <div class="form-group">
                <label for="stok">Stok *</label>
                <input type="number" id="stok" name="stok" value="<?php echo isset($_POST['stok']) ? htmlspecialchars($_POST['stok']) : ''; ?>" min="0" required>
            </div>

            <div class="form-group">
                <label for="file_gambar">File Gambar</label>
                <input type="file" id="file_gambar" name="file_gambar" accept="image/*">
                <small class="form-text">Format: JPG, PNG, GIF (Maksimal 2MB)</small>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit" class="btn btn-primary">💾 Simpan Barang</button>
                <a href="index.php?page=barang/list" class="btn btn-outline">❌ Batal</a>
            </div>
        </form>
    </div>
</div>

<?php 
// Tutup koneksi database
mysqli_close($conn);
require_once('views/footer.php'); 
?>