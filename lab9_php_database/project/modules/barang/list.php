<?php
require_once('config/database.php');
require_once('views/header.php'); 
?>

<div class="content">
    <div class="page-header">
        <h1>📋 Data Barang</h1>
        <p>Manajemen semua data barang dalam sistem</p>
    </div>

    <div class="toolbar">
        <a href="index.php?page=barang/add" class="btn btn-primary">➕ Tambah Barang</a>
        <a href="index.php?page=dashboard" class="btn btn-outline">📊 Dashboard</a>
        <span class="total-records">
            <?php
            $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM data_barang");
            $row = mysqli_fetch_assoc($result);
            echo "Total: " . $row['total'] . " barang";
            ?>
        </span>
    </div>

    <div class="data-table-container">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM data_barang ORDER BY id_barang DESC");
        
        if (mysqli_num_rows($result) > 0) {
            echo '<table class="modern-table">';
            echo '<thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Harga Jual</th>
                        <th>Harga Beli</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>';
            
            while ($row = mysqli_fetch_array($result)) {
                echo '<tr>';
                echo '<td>';
                if ($row['gambar']) {
                    echo '<img src="assets/gambar/' . $row['gambar'] . '" alt="' . $row['nama'] . '" class="item-image">';
                } else {
                    echo '<div class="no-image">📷</div>';
                }
                echo '</td>';
                echo '<td><strong>' . $row['nama'] . '</strong></td>';
                echo '<td><span class="badge category">' . $row['kategori'] . '</span></td>';
                echo '<td>Rp ' . number_format($row['harga_jual'], 0, ',', '.') . '</td>';
                echo '<td>Rp ' . number_format($row['harga_beli'], 0, ',', '.') . '</td>';
                echo '<td><span class="stock-badge">' . $row['stok'] . ' pcs</span></td>';
                echo '<td>
                        <div class="action-buttons">
                            <a href="index.php?page=barang/edit&id=' . $row['id_barang'] . '" class="btn-edit" title="Edit">✏️</a>
                            <a href="index.php?page=barang/delete&id=' . $row['id_barang'] . '" class="btn-delete" title="Hapus" onclick="return confirm(\'Yakin hapus barang ini?\')">🗑️</a>
                        </div>
                      </td>';
                echo '</tr>';
            }
            
            echo '</tbody></table>';
        } else {
            echo '<div class="empty-state">
                    <h3>📝 Tidak ada data barang</h3>
                    <p>Belum ada barang yang terdaftar dalam sistem.</p>
                    <a href="index.php?page=barang/add" class="btn btn-primary">Tambah Barang Pertama</a>
                  </div>';
        }
        ?>
    </div>
</div>

<?php require_once('views/footer.php'); ?>