<?php
session_start();
if (!isset($_SESSION['user_token'])) {
    $_SESSION['user_token'] = uniqid('user_', true);
}
$current_user_token = $_SESSION['user_token'];
include 'koneksi.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

// Validasi Kategori dan Tentukan Tabel & Kolom Nama
$tabel = '';
$kolom_nama = '';
$halaman_kembali = '';

switch($kategori) {
    case 'sapi':
        $tabel = 'produk_sapi';
        $kolom_nama = 'jenis_sapi';
        $halaman_kembali = 'sapi.php';
        break;
    case 'tahunan':
        $tabel = 'produk_tahunan';
        $kolom_nama = 'nama_produk';
        $halaman_kembali = 'tahunan.php';
        break;
    case 'minyak':
        $tabel = 'produk_minyak';
        $kolom_nama = 'jenis_minyak';
        $halaman_kembali = 'minyak.php';
        break;
    default:
        echo "<script>alert('Kategori tidak ditemukan!'); window.location.href='index.html';</script>";
        exit;
}

// Logika Hapus Data (Dipindah ke halaman detail)
if (isset($_GET['hapus'])) {
    $cek_kepemilikan = mysqli_query($koneksi, "SELECT * FROM $tabel WHERE id = $id AND user_token = '$current_user_token'");
    
    if (mysqli_num_rows($cek_kepemilikan) > 0) {
        $row_foto = mysqli_fetch_assoc($cek_kepemilikan);
        $file_foto = "uploads/" . $row_foto['foto'];
        if (!empty($row_foto['foto']) && file_exists($file_foto)) {
            unlink($file_foto); 
        }
        
        $query_hapus = "DELETE FROM $tabel WHERE id = $id AND user_token = '$current_user_token'";
        if (mysqli_query($koneksi, $query_hapus)) {
            echo "<script>alert('Produk berhasil dihapus!'); window.location.href='$halaman_kembali';</script>";
        } else {
            echo "<script>alert('Gagal menghapus produk!'); window.location.href='$halaman_kembali';</script>";
        }
    } else {
        echo "<script>alert('Akses ditolak! Ini bukan produk Anda.'); window.location.href='$halaman_kembali';</script>";
    }
    exit;
}

// Ambil Data Produk
$query = "SELECT * FROM $tabel WHERE id = $id";
$result = mysqli_query($koneksi, $query);
$produk = mysqli_fetch_assoc($result);

if (!$produk) {
    echo "<script>alert('Produk tidak ditemukan!'); window.location.href='$halaman_kembali';</script>";
    exit;
}

// Format Nomor WA
$wa = $produk['no_hp'];
if(substr($wa, 0, 1) == '0') {
    $wa = '62' . substr($wa, 1);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - BUMDes Manggis</title>
    <link rel="icon" href="logo website bumdes manggis.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar scrolled" id="navbar">
        <div class="container nav-content">
            <a href="index.html" class="logo">
                <i class="fa-solid fa-leaf"></i>
                <div>
                    <h1>BUMDes<br><span>MANGGIS</span></h1>
                    <p>Karangasem</p>
                </div>
            </a>
            <div class="nav-links">
                <a href="<?php echo $halaman_kembali; ?>" class="nav-item active"><i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog</a>
            </div>
        </div>
    </nav>

    <!-- Detail Section -->
    <!-- Detail Section -->
    <section class="section-padding products-bg" style="margin-top: 50px;">
        <div class="container">
            <div class="detail-container">
                <!-- Foto di Kiri -->
                <div class="detail-left">
                    <img src="uploads/<?php echo $produk['foto'] ? $produk['foto'] : 'default-image.jpg'; ?>" alt="Foto Produk">
                </div>
                
                <!-- Detail di Kanan -->
                <div class="detail-right">
                    <h2 class="detail-title"><?php echo htmlspecialchars($produk[$kolom_nama]); ?></h2>
                    
                    <!-- Deskripsi dengan batasan tinggi & scrollbar -->
                    <div class="detail-description">
                        <?php echo nl2br(htmlspecialchars($produk['keterangan'])); ?>
                    </div>
                    
                    <!-- Area Tombol (Tetap Diam di Bawah) -->
                    <div class="detail-actions">
                        <!-- Tombol Hubungi (Ukuran Diperkecil) -->
                        <a href="https://wa.me/<?php echo $wa; ?>" target="_blank" class="btn-wa-detail">
                            <i class="fa-brands fa-whatsapp"></i> Hubungi Penjual
                        </a>

                        <!-- Tombol Hapus (Warna Merah) -->
                        <?php if (!empty($produk['user_token']) && $produk['user_token'] === $current_user_token) { ?>
                            <a href="detail_produk.php?hapus=1&id=<?php echo $id; ?>&kategori=<?php echo $kategori; ?>" class="btn-delete-small" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                <i class="fa-solid fa-trash"></i> Hapus Produk
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="copyright">
            <p>&copy; 2026 BUMDes Manggis Karangasem. Semua Hak Dilindungi.</p>
        </div>
    </footer>
    
    <script src="script.js"></script>
</body>
</html>