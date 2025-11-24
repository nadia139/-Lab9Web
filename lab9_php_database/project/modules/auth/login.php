<?php
require_once('views/header.php');

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validasi sederhana
    if (empty($username) || empty($password)) {
        $error = "Username dan password harus diisi!";
    } else {
        // Simulasi login (dalam real application, gunakan database)
        if ($username === 'admin' && $password === 'admin123') {
            $_SESSION['user_id'] = 1;
            $_SESSION['username'] = $username;
            $_SESSION['logged_in'] = true;
            
            $_SESSION['success'] = "Login berhasil! Selamat datang, $username";
            header("Location: index.php?page=dashboard");
            exit();
        } else {
            $error = "Username atau password salah!";
        }
    }
}
?>

<div class="content">
    <div class="login-container">
        <div class="login-form">
            <div class="login-header">
                <h1>🔐 Login</h1>
                <p>Masuk ke Sistem Manajemen Barang</p>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <h4>❌ Login Gagal:</h4>
                    <p><?php echo $error; ?></p>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" name="submit" class="btn btn-primary btn-block">🚀 Login</button>
            </form>

            <div class="login-info">
                <p><strong>Demo Account:</strong></p>
                <p>Username: <code>admin</code></p>
                <p>Password: <code>admin123</code></p>
            </div>
        </div>
    </div>
</div>

<?php require_once('views/footer.php'); ?>