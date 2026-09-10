<?php
// Menangkap data divisi yang dikirimkan lewat URL
$divisi_key = isset($_GET['divisi']) ? $_GET['divisi'] : '';
$nama_divisi = "Pilihan Divisi";
$pilih_manual = false;

if ($divisi_key == 'mitra-individu') {
    $nama_divisi = "Mitra Individu (Freelance)";
} elseif ($divisi_key == 'agen-sales') {
    $nama_divisi = "Agen Sales";
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
    <link rel="icon" href="logo-iconnet.png" type="image/png">
    <title>Form Pendaftaran Lowongan PLN ICON+ - BUMDes Manggis</title>
    <link rel="stylesheet" href="style.css">
    <style>
       body { 
    background-color: #0A2240; 
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
    margin: 0; 
    padding: 20px; 
}

.form-container { 
    max-width: 600px; 
    margin: 40px auto; 
    background-color: #ffffff; 
    padding: 40px; 
    border-radius: 15px; 
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4); 
    border: none; 
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
    background-color: #E8F5E9; /* Background hijau muda lembut */
    color: #1B5E20; /* Teks warna hijau tua */
    padding: 5px 12px; 
    border-radius: 20px; 
    font-size: 0.85rem; 
    font-weight: bold; 
    margin-top: 8px; 
    border: 1px solid #A5D6A7; 
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

/* Styling Tambahan untuk Info & Peta */
.info-section {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #E2E8F0;
    text-align: center;
}

.info-text {
    font-size: 0.95rem;
    color: #334155;
    line-height: 1.5;
    margin-bottom: 15px;
    font-weight: 500;
}

.map-container {
    width: 100%;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Mengubah Tampilan Scrollbar */
::-webkit-scrollbar {
  width: 10px;
}

::-webkit-scrollbar-track {
  background: #0A2240;
}

::-webkit-scrollbar-thumb {
  background: #1ec8c8;
  border-radius: 5px;
}

::-webkit-scrollbar-thumb:hover {
  background: #139b9b;
}

html {
  scrollbar-width: thin;
  scrollbar-color: #1ec8c8 #0A2240;
}
    </style>
</head>
<body>

<div class="form-container">
    <div class="form-header">
        <h2>Form Pendaftaran Lowongan PLN ICON+</h2>
        <div class="badge-divisi">By Badan Usaha Milik Desa (BUMDes)</div>
    </div>

    <form action="proses-lamaran.php" method="POST" enctype="multipart/form-data">
        
        <?php if($pilih_manual): ?>
            <!-- Jika tidak ada parameter URL, beri dropdown pilihan -->
            <div class="form-group">
                <label for="divisi_pilihan">Pilih Posisi yang Dilamar</label>
                <select id="divisi_pilihan" name="divisi_pilihan" required>
                    <option value="">-- Pilih Posisi --</option>
                    <option value="Mitra Individu (Freelance)">Mitra Individu (Freelance)</option>
                    <option value="Agen Sales">Agen Sales</option>
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
    </form>

    <!-- Bagian Informasi Tambahan dan Google Maps -->
    <div class="info-section">
        <p class="info-text">Jika ingin tahu tentang informasi yg lebih lanjut, bisa datang langsung ke BUMDes Manggis.</p>
        <div class="map-container">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3946.0566037810436!2d115.51649707470683!3d-8.493877691547615!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd20f812bda2193%3A0x8fbaca94cf8e61a8!2sKantor%20BUMDes%20Catur%20Mandala%20Manggis!5e0!3m2!1sid!2sid!4v1785382222868!5m2!1sid!2sid"
                width="100%" 
                height="200" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade"
                title="Peta Lokasi Kantor BUMDes Catur Mandala Manggis">
            </iframe>
        </div>
        <a href="index.html" class="back-link">← Kembali ke Halaman Utama</a>
    </div>
</div>

</body>
</html>