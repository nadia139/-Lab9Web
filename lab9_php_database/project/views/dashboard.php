<div class="content">
    <div class="welcome-header">
        <div class="welcome-text">
            <h1 class="welcome-title">📦 Selamat Datang!</h1>
            <p class="welcome-subtitle">Sistem Manajemen Barang - Universitas Pelita Bangsa</p>
            <div class="welcome-info">
                <span class="info-item">📅 <?php echo date('l, d F Y'); ?></span>
                <span class="info-item">🕒 <?php echo date('H:i A'); ?></span>
                <span class="info-item">🌐 PHP <?php echo phpversion(); ?></span>
            </div>
        </div>
        <div class="welcome-icon">
            <div class="icon-circle">📊</div>
        </div>
    </div>
    <div class="stats-grid-modern">
        <div class="stat-card-modern primary">
            <div class="stat-content">
                <div class="stat-icon">📦</div>
                <div class="stat-details">
                    <h3>Total Barang</h3>
                    <span class="stat-number">
                        <?php
                        require_once('config/database.php');
                        $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM data_barang");
                        $row = mysqli_fetch_assoc($result);
                        echo $row['total'];
                        ?>
                    </span>
                    <div class="stat-trend">
                        <span class="trend-up">↗ Tersedia</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card-modern success">
            <div class="stat-content">
                <div class="stat-icon">🏷️</div>
                <div class="stat-details">
                    <h3>Total Kategori</h3>
                    <span class="stat-number">
                        <?php
                        require_once('config/database.php');
                        $result = mysqli_query($conn, "SELECT COUNT(DISTINCT kategori) as total FROM data_barang");
                        $row = mysqli_fetch_assoc($result);
                        echo $row['total'];
                        ?>
                    </span>
                    <div class="stat-trend">
                        <span class="trend-up">+3 jenis</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card-modern warning">
            <div class="stat-content">
                <div class="stat-icon">💰</div>
                <div class="stat-details">
                    <h3>Rata-rata Harga</h3>
                    <span class="stat-number">
                        <?php
                        require_once('config/database.php');
                        $result = mysqli_query($conn, "SELECT AVG(harga_beli) as avg_harga FROM data_barang");
                        $row = mysqli_fetch_assoc($result);
                        echo 'Rp ' . number_format($row['avg_harga'], 0, ',', '.');
                        ?>
                    </span>
                    <div class="stat-trend">
                        <span class="trend-stable">✓ Stabil</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card-modern danger">
            <div class="stat-content">
                <div class="stat-icon">📊</div>
                <div class="stat-details">
                    <h3>Total Stok</h3>
                    <span class="stat-number">
                        <?php
                        $result = mysqli_query($conn, "SELECT SUM(stok) as total_stok FROM data_barang");
                        $row = mysqli_fetch_assoc($result);
                        echo $row['total_stok'];
                        ?>
                    </span>
                    <div class="stat-trend">
                        <span class="trend-up">↑ Ready</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="quick-actions-modern">
        <h2 class="section-title">🚀 Menu Cepat</h2>
        <div class="actions-grid">
            <a href="index.php?page=barang/list" class="action-card">
                <div class="action-icon">📋</div>
                <div class="action-content">
                    <h3>Data Barang</h3>
                    <p>Lihat dan kelola semua data barang</p>
                </div>
                <div class="action-arrow">→</div>
            </a>

            <a href="index.php?page=barang/add" class="action-card">
                <div class="action-icon">➕</div>
                <div class="action-content">
                    <h3>Tambah Barang</h3>
                    <p>Tambahkan barang baru ke sistem</p>
                </div>
                <div class="action-arrow">→</div>
            </a>

            <a href="index.php?page=auth/login" class="action-card">
                <div class="action-icon">🔐</div>
                <div class="action-content">
                    <h3>Login System</h3>
                    <p>Akses kontrol admin sistem</p>
                </div>
                <div class="action-arrow">→</div>
            </a>

            <div class="action-card">
                <div class="action-icon">📈</div>
                <div class="action-content">
                    <h3>Laporan</h3>
                    <p>Analisis data dan generate laporan</p>
                </div>
                <div class="action-arrow">→</div>
            </div>
        </div>
    </div>

    <div class="recent-data">
        <div class="section-header">
            <h2 class="section-title">📦 Data Barang Terbaru</h2>
            <a href="index.php?page=barang/list" class="view-all">Lihat Semua →</a>
        </div>
        <div class="data-table-container">
            <?php
            $result = mysqli_query($conn, "SELECT * FROM data_barang ORDER BY id_barang DESC LIMIT 5");
            
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
                        echo '<img src="gambar/' . $row['gambar'] . '" alt="' . $row['nama'] . '" class="item-image">';
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
                                <a href="index.php?page=barang/edit&id=' . $row['id_barang'] . '" class="btn-edit">✏️</a>
                                <a href="index.php?page=barang/delete&id=' . $row['id_barang'] . '" class="btn-delete" onclick="return confirm(\'Hapus barang?\')">🗑️</a>
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

    <div class="features-section-modern">
        <h2 class="section-title">💫 Fitur Sistem</h2>
        <div class="features-grid-modern">
            <div class="feature-card-modern">
                <div class="feature-icon">📦</div>
                <div class="feature-content">
                    <h3>Manajemen Barang</h3>
                    <p>Kelola data barang dengan fitur CRUD lengkap</p>
                    <span class="feature-status active">Active</span>
                </div>
            </div>

            <div class="feature-card-modern">
                <div class="feature-icon">🏷️</div>
                <div class="feature-content">
                    <h3>Kategori Barang</h3>
                    <p>Organisir barang berdasarkan kategori</p>
                    <span class="feature-status active">Active</span>
                </div>
            </div>

            <div class="feature-card-modern">
                <div class="feature-icon">💰</div>
                <div class="feature-content">
                    <h3>Management Harga</h3>
                    <p>Kelola harga beli dan jual dengan mudah</p>
                    <span class="feature-status active">Active</span>
                </div>
            </div>

            <div class="feature-card-modern">
                <div class="feature-icon">📊</div>
                <div class="feature-content">
                    <h3>Stok Management</h3>
                    <p>Pantau dan kelola stok barang real-time</p>
                    <span class="feature-status active">Active</span>
                </div>
            </div>

            <div class="feature-card-modern">
                <div class="feature-icon">🔄</div>
                <div class="feature-content">
                    <h3>Modular System</h3>
                    <p>Sistem modular dengan routing yang fleksibel</p>
                    <span class="feature-status active">Active</span>
                </div>
            </div>

            <div class="feature-card-modern">
                <div class="feature-icon">📱</div>
                <div class="feature-content">
                    <h3>Responsive Design</h3>
                    <p>Akses dari desktop, tablet, atau mobile</p>
                    <span class="feature-status active">Active</span>
                </div>
            </div>
        </div>
    </div>

    <div class="system-info">
        <div class="info-card">
            <h3>🖥️ Informasi Sistem</h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Server Software:</span>
                    <span class="info-value"><?php echo $_SERVER['SERVER_SOFTWARE']; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">PHP Version:</span>
                    <span class="info-value"><?php echo phpversion(); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Database:</span>
                    <span class="info-value">MySQL - latihan1</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Last Update:</span>
                    <span class="info-value"><?php echo date('d M Y H:i'); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>