<?php
session_start();
require 'koneksi.php';

// Pilihan 1: Masuk sebagai Pengunjung
if (isset($_POST['as_guest'])) {
    $_SESSION['role'] = 'guest';
    $_SESSION['username'] = 'Pengunjung / Tamu';
    header("Location: index.php");
    exit();
}

// Pilihan 2: Login Admin terkoneksi Database
$error = "";
if (isset($_POST['as_admin'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM akun_admin WHERE username = '$username' LIMIT 1");
    if ($admin = mysqli_fetch_assoc($query)) {
        // Mendukung teks biasa (sesuai SQL dump Anda) maupun password_hash
        if ($password === $admin['password'] || password_verify($password, $admin['password'])) {
            $_SESSION['role'] = 'admin';
            $_SESSION['username'] = $admin['username'] . " (" . $admin['role'] . ")";
            header("Location: index.php");
            exit();
        } else {
            $error = "Password Admin salah!";
        }
    } else {
        $error = "Username Admin tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BUMDes Manggis Karangasem</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .login-wrapper { min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(46,111,60,0.1), rgba(30,70,41,0.2)); padding: 20px; }
        .login-card { background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); max-width: 450px; width: 100%; text-align: center; }
        .login-card h2 { color: var(--brand-dark); margin-bottom: 10px; }
        .login-card p { color: var(--text-muted); margin-bottom: 30px; font-size: 0.9rem; }
        .divider { margin: 25px 0; border-top: 1px solid var(--border-color); position: relative; }
        .divider span { position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: #fff; padding: 0 15px; font-size: 0.8rem; color: #888; }
        .admin-form { display: none; text-align: left; margin-top: 20px; }
        .admin-form.active { display: block; }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <i class="fa-solid fa-leaf" style="font-size: 3rem; color: var(--brand); margin-bottom: 15px;"></i>
            <h2>BUMDes Manggis</h2>
            <p>Silakan pilih akses masuk ke dalam website resmi kami.</p>

            <?php if($error): ?>
                <div style="background: #ffebee; color: #c62828; padding: 10px; border-radius: 8px; margin-bottom: 20px; font-size: 0.85rem;"><?= $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <button type="submit" name="as_guest" class="btn btn-brand" style="width: 100%; margin-bottom: 15px;">
                    <i class="fa-solid fa-user"></i> Masuk sebagai Pengunjung (Tamu)
                </button>
            </form>

            <div class="divider"><span>ATAU</span></div>

            <button type="button" id="btnToggleAdmin" class="btn btn-outline" style="width: 100%; border-color: var(--brand); color: var(--brand);">
                <i class="fa-solid fa-lock"></i> Login sebagai Admin
            </button>

            <form method="POST" class="admin-form" id="adminForm">
                <div class="form-group" style="margin-top: 15px;">
                    <label>Username Admin</label>
                    <input type="text" name="username" required placeholder="Masukkan username...">
                </div>
                <div class="form-group">
                    <label>Password Admin</label>
                    <input type="password" name="password" required placeholder="Masukkan password...">
                </div>
                <button type="submit" name="as_admin" class="btn btn-brand" style="width: 100%; background: var(--brand-dark);">
                    <i class="fa-solid fa-right-to-bracket"></i> Masuk Dashboard Admin
                </button>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('btnToggleAdmin').addEventListener('click', function() {
            document.getElementById('adminForm').classList.toggle('active');
        });
    </script>
</body>
</html>