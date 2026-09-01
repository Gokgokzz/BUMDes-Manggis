<?php
session_start();
include 'koneksi.php';

// Jika sudah login, langsung lempar ke dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin_dashboard.php");
    exit;
}

// Otomatis buat tabel akun_admin jika belum ada
mysqli_query($koneksi, "CREATE TABLE IF NOT EXISTS akun_admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'Kepala BUMDes'
)");

// Cek jika tabel masih kosong, buat akun bawaan awal (Default: admin / admin123)
$check_empty = mysqli_query($koneksi, "SELECT * FROM akun_admin");
if (mysqli_num_rows($check_empty) == 0) {
    mysqli_query($koneksi, "INSERT INTO akun_admin (username, password, role) VALUES ('admin', 'admin123', 'Kepala BUMDes')");
}

$error = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $query = mysqli_query($koneksi, "SELECT * FROM akun_admin WHERE username='$username' AND password='$password'");

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $data['username'];
        $_SESSION['admin_role'] = $data['role'];

        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Username atau Kata Sandi salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | BUMDes Manggis</title>
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
        .login-card {
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-header h2 {
            color: var(--brand-dark, #1b5e20);
            margin: 0 0 8px 0;
            font-size: 1.6rem;
        }
        .login-header p {
            color: #666;
            font-size: 0.85rem;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 500;
            color: #555;
            margin-bottom: 6px;
        }
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-wrapper i {
            position: absolute;
            left: 14px;
            color: #888;
            font-size: 0.85rem;
            pointer-events: none;
        }
        .form-control {
            width: 100%;
            padding: 12px 12px 12px 40px !important;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.85rem;
            font-family: inherit;
            box-sizing: border-box;
            transition: all 0.2s ease;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--brand, #2e7d32);
            box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.15);
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            background: var(--brand, #2e7d32);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        .btn-login:hover {
            background: var(--brand-dark, #1b5e20);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
        }
        .alert-error {
            background: #f8d7da;
            color: #842029;
            padding: 10px;
            border-radius: 8px;
            font-size: 0.8rem;
            margin-bottom: 20px;
        }
        .forgot-link {
            display: block;
            margin-top: 15px;
            font-size: 0.8rem;
            color: var(--brand, #2e7d32);
            text-decoration: none;
            font-weight: 500;
        }
        .forgot-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <h2>Login Admin BUMDes</h2>
        <p>Masukkan username & kata sandi untuk masuk</p>
    </div>

    <?php if (!empty($error)) { ?>
        <div class="alert-error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?></div>
    <?php } ?>

    <form action="" method="POST">
        <div class="form-group">
            <label>Username</label>
            <div class="input-wrapper">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>
        </div>

        <div class="form-group">
            <label>Kata Sandi</label>
            <div class="input-wrapper">
                <i class="fa-solid fa-key"></i>
                <input type="password" name="password" class="form-control" placeholder="Masukkan kata sandi" required>
            </div>
        </div>

        <button type="submit" name="login" class="btn-login">Masuk Ke Dashboard</button>
    </form>

    <a href="lupa_password.php" class="forgot-link"><i class="fa-solid fa-lock"></i> Lupa Kata Sandi?</a>
</div>

</body>
</html>