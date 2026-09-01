<?php
session_start();
include 'koneksi.php';

// --- SISTEM PENGUNCI (SESSION GUARD) ---
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// LOGOUT
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: login.php");
    exit;
}

// --- DETERMINASI HALAMAN AKTIF ---
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// --- LOGIKA SIMPAN / UPDATE AKUN ---
$pesan_sukses = "";
if (isset($_POST['simpan_akun'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    
    mysqli_query($koneksi, "CREATE TABLE IF NOT EXISTS akun_admin (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(50) DEFAULT 'Kepala BUMDes'
    )");

    $check_acc = mysqli_query($koneksi, "SELECT * FROM akun_admin WHERE role = 'Kepala BUMDes'");
    if (mysqli_num_rows($check_acc) > 0) {
        $update = mysqli_query($koneksi, "UPDATE akun_admin SET username='$username', password='$password' WHERE role='Kepala BUMDes'");
        if ($update) {
            $_SESSION['admin_username'] = $username;
            $pesan_sukses = "Akun berhasil diperbarui!";
        }
    } else {
        mysqli_query($koneksi, "INSERT INTO akun_admin (username, password, role) VALUES ('$username', '$password', 'Kepala BUMDes')");
        $pesan_sukses = "Akun berhasil dibuat!";
    }
}

// Ambil username Kepala BUMDes
$current_username = "";
$check_table = mysqli_query($koneksi, "SHOW TABLES LIKE 'akun_admin'");
if ($check_table && mysqli_num_rows($check_table) > 0) {
    $get_acc = mysqli_query($koneksi, "SELECT * FROM akun_admin WHERE role = 'Kepala BUMDes' LIMIT 1");
    if ($get_acc && $d_acc = mysqli_fetch_assoc($get_acc)) {
        $current_username = $d_acc['username'];
    }
}

// --- LOGIKA APPROVE / TOLAK ---
if (isset($_GET['id']) && isset($_GET['type']) && isset($_GET['action'])) {
    $id = (int)$_GET['id'];
    $tabel = $_GET['type'];
    $action = $_GET['action'];
    $allowed = ['produk_minyak', 'produk_sapi', 'produk_tahunan'];

    if (in_array($tabel, $allowed)) {
        if ($action == 'approve') {
            mysqli_query($koneksi, "UPDATE $tabel SET status_approve = 'active' WHERE id = '$id'");
        } elseif ($action == 'tolak') {
            mysqli_query($koneksi, "DELETE FROM $tabel WHERE id = '$id'");
        }
        // Redirect kembali ke halaman kategori yang sedang dibuka
        header("Location: admin_dashboard.php?page=" . $tabel);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | BUMDes Manggis</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --brand-primary: #1b5e20;
            --brand-light: #2e7d32;
            --bg-main: #f4f7f6;
            --sidebar-bg: #0f3813;
            --sidebar-hover: #164a1a;
            --text-muted: #6b7280;
        }

        * { box-sizing: border-box; }
        body { background-color: var(--bg-main); font-family: 'Poppins', sans-serif; margin: 0; padding: 0; }

        .admin-layout { display: flex; min-height: 100vh; }

        /* SIDEBAR STYLES */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            top: 0; bottom: 0; left: 0;
            z-index: 100;
            padding: 25px 15px;
            box-shadow: 4px 0 15px rgba(0,0,0,0.05);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px 25px 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .sidebar-brand i { font-size: 1.6rem; color: #81c784; }
        .sidebar-brand h3 { margin: 0; font-size: 1.15rem; font-weight: 700; letter-spacing: 0.5px; }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 25px 0 auto 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #c8e6c9;
            text-decoration: none;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .sidebar-menu li a:hover,
        .sidebar-menu li.active a {
            background-color: var(--sidebar-hover);
            color: #ffffff;
            font-weight: 600;
        }

        .sidebar-footer {
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn-sidebar-action {
            width: 100%;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s ease;
            text-decoration: none;
            box-sizing: border-box;
        }
        .btn-sidebar-settings { background: rgba(255,255,255,0.1); color: #e8f5e9; }
        .btn-sidebar-settings:hover { background: rgba(255,255,255,0.2); }
        .btn-sidebar-logout { background: #d32f2f; color: #ffffff; }
        .btn-sidebar-logout:hover { background: #b71c1c; }

        /* MAIN CONTENT AREA */
        .main-content {
            margin-left: 260px;
            flex: 1;
            padding: 35px 40px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .topbar-title h2 { color: var(--brand-primary); margin: 0; font-size: 1.75rem; font-weight: 700; }
        .topbar-title p { color: var(--text-muted); margin: 4px 0 0 0; font-size: 0.88rem; }
        
        .user-badge {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--brand-primary);
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
            display: flex; align-items: center; gap: 8px;
        }

        /* GRID STATS CARD */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card { 
            background: #ffffff; 
            padding: 20px 24px; 
            border-radius: 18px; 
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); 
            border-left: 5px solid var(--brand-light); 
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.07);
        }
        .stat-info h4 { margin: 0 0 4px 0; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-info h2 { margin: 0; color: var(--brand-primary); font-size: 1.8rem; font-weight: 700; }
        .stat-icon {
            width: 48px; height: 48px;
            background: rgba(46, 125, 50, 0.1);
            color: var(--brand-light);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center; font-size: 1.3rem;
        }

        /* TABLE CONTAINER */
        .table-wrap { 
            background: #ffffff; 
            padding: 24px; 
            border-radius: 18px; 
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); 
            overflow-x: auto; 
            margin-bottom: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .table-wrap:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.07);
        }
        .table-header { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; border-bottom: 2px solid #f3f4f6; padding-bottom: 12px; }
        .table-header h3 { margin: 0; font-weight: 600; color: var(--brand-primary); font-size: 1.1rem; }
        
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 14px 12px; text-align: left; border-bottom: 1px solid #f3f4f6; }
        th { color: var(--brand-primary); font-weight: 600; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; }

        .badge-pending { background: #fff3cd; color: #856404; padding: 5px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 500; }
        .btn-action { padding: 6px 12px; border-radius: 6px; font-size: 0.8rem; font-weight: 500; border: none; cursor: pointer; text-decoration: none; display: inline-block; margin-right: 5px;}
        .btn-approve { background: #28a745; color: white; }
        .btn-reject { background: #dc3545; color: white; }

        /* MODAL POPUP */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
            display: none;
            justify-content: center; align-items: center;
            z-index: 9999;
        }
        .modal-overlay.active { display: flex; }
        .modal-box {
            background: #ffffff; padding: 30px; border-radius: 20px;
            width: 100%; max-width: 420px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            animation: modalFadeIn 0.25s ease-out;
        }
        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .modal-header h3 { margin: 0; color: var(--brand-primary); font-size: 1.2rem; }
        .close-btn { background: none; border: none; font-size: 1.3rem; color: #888; cursor: pointer; }
 
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 6px; font-size: 0.8rem; font-weight: 500; color: #555; }
        .input-wrapper { position: relative; display: flex; align-items: center; }
        .input-wrapper i { position: absolute; left: 14px; color: #888; font-size: 0.85rem; }
        .form-control {
            width: 100%; padding: 10px 12px 10px 40px !important;
            border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.85rem;
            box-sizing: border-box; font-family: inherit;
        }
        .form-control:focus { outline: none; border-color: var(--brand-light); }
        .btn-save-modal {
            width: 100%; padding: 11px; background: var(--brand-light);
            color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 0.85rem; cursor: pointer; margin-top: 10px;
        }
        .btn-save-modal:hover { background: var(--brand-primary); }
        .alert-success { background: #d1e7dd; color: #0f5132; padding: 10px; border-radius: 8px; font-size: 0.8rem; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="admin-layout">
    
    <!-- SIDEBAR NAVIGASI -->
    <aside class="sidebar">
        <div>
            <div class="sidebar-brand">
                <i class="fa-solid fa-leaf"></i>
                <h3>BUMDes Manggis</h3>
            </div>

            <ul class="sidebar-menu">
                <li class="<?php echo ($page == 'dashboard') ? 'active' : ''; ?>">
                    <a href="admin_dashboard.php?page=dashboard">
                        <i class="fa-solid fa-chart-pie"></i> Ringkasan
                    </a>
                </li>
                <li class="<?php echo ($page == 'produk_minyak') ? 'active' : ''; ?>">
                    <a href="admin_dashboard.php?page=produk_minyak">
                        <i class="fa-solid fa-bottle-droplet"></i> Produk Minyak
                    </a>
                </li>
                <li class="<?php echo ($page == 'produk_sapi') ? 'active' : ''; ?>">
                    <a href="admin_dashboard.php?page=produk_sapi">
                        <i class="fa-solid fa-cow"></i> Produk Sapi
                    </a>
                </li>
                <li class="<?php echo ($page == 'produk_tahunan') ? 'active' : ''; ?>">
                    <a href="admin_dashboard.php?page=produk_tahunan">
                        <i class="fa-solid fa-tree"></i> Produk Tahunan
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-footer">
            <button class="btn-sidebar-action btn-sidebar-settings" onclick="openAccountModal()">
                <i class="fa-solid fa-user-gear"></i> Kelola Akun
            </button>
            <a href="admin_dashboard.php?action=logout" class="btn-sidebar-action btn-sidebar-logout" onclick="return confirm('Yakin ingin keluar?')">
                <i class="fa-solid fa-right-from-bracket"></i> Keluar
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <main class="main-content">
        
        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-title">
                <h2>
                    <?php 
                    if ($page == 'dashboard') echo "Dashboard Admin BUMDes";
                    else echo "Kelola " . ucwords(str_replace('_', ' ', $page));
                    ?>
                </h2>
                <p>Selamat datang kembali, <b><?php echo htmlspecialchars($_SESSION['admin_username']); ?></b></p>
            </div>
            <div class="topbar-user">
                <span class="user-badge"><i class="fa-solid fa-user-shield"></i> Administrator</span>
            </div>
        </header>

        <!-- CONDITION 1: HALAMAN DASHBOARD / RINGKASAN -->
        <?php if ($page == 'dashboard') { ?>
            
            <div class="stats-grid">
                <?php
                $tables_info = [
                    'produk_minyak' => ['label' => 'Produk Minyak', 'icon' => 'fa-bottle-droplet'],
                    'produk_sapi'   => ['label' => 'Produk Sapi', 'icon' => 'fa-cow'],
                    'produk_tahunan'=> ['label' => 'Produk Tahunan', 'icon' => 'fa-tree']
                ];
                $total_semua = 0;

                foreach ($tables_info as $tbl => $info) {
                    $q = mysqli_query($koneksi, "SELECT COUNT(*) as c FROM $tbl");
                    $d = mysqli_fetch_array($q);
                    $total_semua += $d['c'];
                ?>
                    <div class="stat-card">
                        <div class="stat-info">
                            <h4><?php echo $info['label']; ?></h4>
                            <h2><?php echo $d['c']; ?></h2>
                        </div>
                        <div class="stat-icon"><i class="fa-solid <?php echo $info['icon']; ?>"></i></div>
                    </div>
                <?php } ?>

                <div class="stat-card" style="border-left-color: #15803d;">
                    <div class="stat-info">
                        <h4>Total Semua Produk</h4>
                        <h2><?php echo $total_semua; ?></h2>
                    </div>
                    <div class="stat-icon" style="background: rgba(21, 128, 61, 0.1); color: #15803d;">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                </div>
            </div>

            <div class="table-wrap">
                <div class="table-header">
                    <i class="fa-solid fa-bell" style="color: #eab308;"></i>
                    <h3>Pemberitahuan / Panduan Admin</h3>
                </div>
                <p style="color: #555; line-height: 1.6; margin: 10px 0;">
                    Gunakan menu di <b>Sidebar Sebelah Kiri</b> untuk berpindah ke masing-masing kategori produk secara spesifik. Anda dapat menyetujui (<i>Approve</i>) atau menolak produk yang dikirimkan oleh warga/penjual melalui halaman kategori terkait.
                </p>
            </div>
 
        <!-- CONDITION 2: HALAMAN KATAGORI PRODUK SPESIFIK -->
        <?php } else { 
            $tabel_name = $page;
        ?>
            <div class="table-wrap">
                <div class="table-header">
                    <i class="fa-solid fa-folder-open" style="color: var(--brand-light);"></i>
                    <h3>Daftar <?php echo ucwords(str_replace('_', ' ', $tabel_name)); ?></h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Nama Produk / Jenis</th>
                            <th>Penjual / Kontak</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM $tabel_name");
                        if (mysqli_num_rows($query) == 0) {
                            echo "<tr><td colspan='4' style='text-align: center; color: #888; padding: 25px;'>Belum ada data produk di kategori ini.</td></tr>";
                        }
                        while($row = mysqli_fetch_array($query)) {
                        ?>
                       <tr>
    <td style="font-weight: 500;">
        <?php 
            // Cek semua kemungkinan nama kolom produk/jenis
            echo $row['nama_produk'] ?? $row['jenis_sapi'] ?? $row['nama_minyak'] ?? $row['jenis_minyak'] ?? $row['nama'] ?? '-'; 
        ?>
    </td>
    <td style="color: #555;">
        <?php 
            // Cek semua kemungkinan nama kolom kontak/penjual
            echo $row['no_hp'] ?? $row['nama_penjual'] ?? $row['penjual'] ?? $row['kontak'] ?? '-'; 
        ?>
    </td>
                            <td>
                                <?php if ($row['status_approve'] == 'active') { ?>
                                    <span style="color: #198754; font-weight: 600; background: #d1e7dd; padding: 5px 10px; border-radius: 6px; font-size: 0.8rem;">Active</span>
                                <?php } else { ?>
                                    <span class="badge-pending">Pending</span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($row['status_approve'] != 'active') { ?>
                                    <a href="admin_dashboard.php?id=<?php echo $row['id']; ?>&type=<?php echo $tabel_name; ?>&action=approve" class="btn-action btn-approve"><i class="fa-solid fa-check"></i> Setujui</a>
                                    <a href="admin_dashboard.php?id=<?php echo $row['id']; ?>&type=<?php echo $tabel_name; ?>&action=tolak" class="btn-action btn-reject" onclick="return confirm('Yakin ingin menolak produk ini?')"><i class="fa-solid fa-xmark"></i> Tolak</a>
                                <?php } else { ?>
                                    <span style="color: #999; font-size: 0.8rem; font-style: italic;">Disetujui</span>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>

    </main>

</div>

<!-- MODAL POPUP KELOLA AKUN -->
<div class="modal-overlay <?php echo !empty($pesan_sukses) ? 'active' : ''; ?>" id="accountModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3><i class="fa-solid fa-user-gear"></i> Kelola Akun Admin</h3>
            <button class="close-btn" onclick="closeAccountModal()">&times;</button>
        </div>

        <?php if (!empty($pesan_sukses)) { ?>
            <div class="alert-success"><i class="fa-solid fa-circle-check"></i> <?php echo $pesan_sukses; ?></div>
        <?php } ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Username Baru</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($current_username); ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>Kata Sandi Baru</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-key"></i>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan kata sandi baru" required>
                </div>
            </div>

            <button type="submit" name="simpan_akun" class="btn-save-modal">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</div>

<script>
    function openAccountModal() {
        document.getElementById('accountModal').classList.add('active');
    }

    function closeAccountModal() {
        document.getElementById('accountModal').classList.remove('active');
    }

    window.onclick = function(event) {
        var modal = document.getElementById('accountModal');
        if (event.target == modal) {
            closeAccountModal();
        }
    }
</script>             

</body>
</html>