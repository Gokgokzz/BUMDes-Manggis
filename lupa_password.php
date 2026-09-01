<?php
include 'koneksi.php';

$pesan = "";
$tipe_pesan = "";

if (isset($_POST['reset'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password_baru = mysqli_real_escape_string($koneksi, $_POST['password_baru']);

    $check = mysqli_query($koneksi, "SELECT * FROM akun_admin WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        mysqli_query($koneksi, "UPDATE akun_admin SET password='$password_baru' WHERE username='$username'");
        $pesan = "Kata sandi berhasil diperbarui! Silakan login kembali.";
        $tipe_pesan = "success";
    } else {
        $pesan = "Username tidak ditemukan di sistem!";
        $tipe_pesan = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi | BUMDes Manggis</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: var(--brand-light, #f4f7f6);
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .card {
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 400px;
        }
        h2 { color: var(--brand-dark, #1b5e20); margin: 0 0 8px 0; text-align: center; }
        p { color: #666; font-size: 0.85rem; text-align: center; margin-bottom: 25px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 0.8rem; font-weight: 500; color: #555; margin-bottom: 6px; }
        .input-wrapper { position: relative; display: flex; align-items: center; }
        .input-wrapper i { position: absolute; left: 14px; color: #888; font-size: 0.85rem; pointer-events: none; }
        .form-control {
            width: 100%;
            padding: 12px 12px 12px 40px !important;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.85rem;
            box-sizing: border-box;
        }
        .btn-reset {
            width: 100%;
            padding: 12px;
            background: var(--brand, #2e7d32);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
        }
        .alert { padding: 10px; border-radius: 8px; font-size: 0.8rem; margin-bottom: 20px; text-align: center; }
        .alert-success { background: #d1e7dd; color: #0f5132; }
        .alert-error { background: #f8d7da; color: #842029; }
        .back-link { display: block; text-align: center; margin-top: 15px; font-size: 0.8rem; color: #666; text-decoration: none; }
    </style>
</head>
<body>

<div class="card">
    <h2>Reset Kata Sandi</h2>
    <p>Masukkan username Anda untuk memperbarui kata sandi</p>

    <?php if (!empty($pesan)) { ?>
        <div class="alert alert-<?php echo $tipe_pesan; ?>"><?php echo $pesan; ?></div>
    <?php } ?>

    <form action="" method="POST">
        <div class="form-group">
            <label>Username Anda</label>
            <div class="input-wrapper">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>
        </div>

        <div class="form-group">
            <label>Kata Sandi Baru</label>
            <div class="input-wrapper">
                <i class="fa-solid fa-key"></i>
                <input type="password" name="password_baru" class="form-control" placeholder="Kata sandi baru" required>
            </div>
        </div>

        <button type="submit" name="reset" class="btn-reset">Perbarui Kata Sandi</button>
    </form>

    <a href="login.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Kembali ke Login</a>
</div>

</body>
</html>