<?php
// Menangkap data divisi yang dikirimkan lewat URL
$divisi_key = isset($_GET['divisi']) ? $_GET['divisi'] : '';
$nama_divisi = "Pilihan Divisi";
$pilih_manual = false;

if ($divisi_key == 'agen-sales') {
    $nama_divisi = "Agen Sales";
} elseif ($divisi_key == 'mitra-individu') {
    $nama_divisi = "Mitra Individu";
} elseif ($divisi_key == 'teknisi') {
    $nama_divisi = "Teknisi Aktivasi dan Pemeliharaan";
} else {
    $nama_divisi = "Pendaftaran Terbuka (Pilih Posisi)";
    $pilih_manual = true; // Flag untuk menampilkan dropdown di HTML
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran <?php echo $nama_divisi; ?> - BUMDes Manggis</title>
    <link rel="stylesheet" href="style.css">
    <style>
       body { 
    background-color: #0A2240; /* Latar belakang diubah jadi Biru Navy */
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
    margin: 0; 
    padding: 20px; 
}

.form-container { 
    max-width: 600px; 
    margin: 40px auto; 
    background-color: #ffffff; /* Kotak form tetap putih agar kontras */
    padding: 40px; 
    border-radius: 15px; 
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4); /* Shadow dipertegas karena background gelap */
    border: none; /* Border dihilangkan agar lebih menyatu */
}

.form-header { 
    text-align: center; 
    margin-bottom: 30px; 
}

.form-header h2 { 
    color: #0A2240; 
    margin-bottom: 5px; 
    font-size: 1.7rem; 
}

.badge-divisi { 
    display: inline-block; 
    background-color: #E0F5F4; 
    color: #00A99D; 
    padding: 5px 12px; 
    border-radius: 20px; 
    font-size: 0.85rem; 
    font-weight: bold; 
    margin-top: 8px; 
    border: 1px solid rgba(0, 169, 157, 0.3); 
}

.form-group { 
    margin-bottom: 20px; 
}

.form-group label { 
    display: block; 
    margin-bottom: 8px; 
    font-weight: 600; 
    color: #0A2240; 
    font-size: 0.9rem; 
}

.form-group input, 
.form-group textarea, 
.form-group select { 
    width: 100%; 
    padding: 14px 15px; 
    border: 1px solid #CBD5E1; 
    border-radius: 8px; 
    font-size: 1rem; 
    box-sizing: border-box; 
    transition: all 0.3s ease;
}

.form-group input:focus, 
.form-group textarea:focus, 
.form-group select:focus { 
    border-color: #00A99D; 
    outline: none; 
    box-shadow: 0 0 0 3px rgba(0, 169, 157, 0.15); 
}

.btn-submit { 
    background-color: #0A2240; 
    color: white; 
    padding: 15px; 
    border: none; 
    border-radius: 8px; 
    width: 100%; 
    font-size: 1.1rem; 
    cursor: pointer; 
    font-weight: bold; 
    transition: all 0.3s ease;
}

.btn-submit:hover { 
    background-color: #00A99D; 
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 169, 157, 0.2);
}

.back-link { 
    display: inline-block; 
    margin-top: 20px; 
    color: #0A2240; 
    text-decoration: none; 
    text-align: center; 
    width: 100%; 
    font-size: 0.9rem; 
    transition: color 0.3s ease;
}

.back-link:hover {
    color: #00A99D;
    text-decoration: underline;
}
/* Mengubah Tampilan Scrollbar */
::-webkit-scrollbar {
    width: 12px; /* Lebar scrollbar */
}

::-webkit-scrollbar-track {
    background: #0A2240; /* Warna background jalur scrollbar disamakan dengan background body */
}

::-webkit-scrollbar-thumb {
    background: #00A99D; /* Warna biru toska */
    border-radius: 6px; /* Bikin ujungnya membulat */
}

::-webkit-scrollbar-thumb:hover {
    background: #008C82; /* Warna toska yang sedikit lebih gelap saat disorot mouse */
}
    </style>
</head>
<body>

<div class="form-container">
    <div class="form-header">
        <h2>Formulir Pendaftaran Lowongan</h2>
        <div class="badge-divisi">Posisi: <?php echo $nama_divisi; ?></div>
    </div>

    <form action="proses-lamaran.php" method="POST" enctype="multipart/form-data">
        
        <?php if($pilih_manual): ?>
            <!-- Jika tidak ada parameter URL, beri dropdown pilihan -->
            <div class="form-group">
                <label for="divisi_pilihan">Pilih Posisi yang Dilamar</label>
                <select id="divisi_pilihan" name="divisi_pilihan" required>
                    <option value="">-- Pilih Posisi --</option>
                    <option value="Agen Sales">Agen Sales</option>
                    <option value="Mitra Individu">Mitra Individu</option>
                    <option value="Teknisi Aktivasi dan Pemeliharaan">Teknisi Aktivasi dan Pemeliharaan</option>
                </select>
            </div>
        <?php else: ?>
            <!-- Menyimpan informasi divisi secara tersembunyi jika URL sudah lengkap -->
            <input type="hidden" name="divisi_pilihan" value="<?php echo htmlspecialchars($nama_divisi); ?>">
        <?php endif; ?>

        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap Anda" required>
        </div>

        <div class="form-group">
            <label for="whatsapp">Nomor WhatsApp Aktif</label>
            <input type="tel" id="whatsapp" name="whatsapp" placeholder="Contoh: 081234567890" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat Domisili</label>
            <textarea id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap Anda" required></textarea>
        </div>

        <div class="form-group">
            <label for="berkas">Upload Berkas Lamaran / CV (Format: PDF / JPG)</label>
            <input type="file" id="berkas" name="berkas" accept=".pdf,.jpg,.jpeg,.png" required>
        </div>

        <button type="submit" class="btn-submit">Kirim Berkas Lamaran</button>
        <a href="index.php" class="back-link">← Kembali ke Halaman Utama</a>
    </form>
</div>

</body>
</html>