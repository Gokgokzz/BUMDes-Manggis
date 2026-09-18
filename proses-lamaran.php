<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $posisi       = mysqli_real_escape_string($koneksi, $_POST['divisi_pilihan'] ?? '');
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap'] ?? '');
    $whatsapp     = mysqli_real_escape_string($koneksi, $_POST['whatsapp'] ?? '');
    $alamat       = mysqli_real_escape_string($koneksi, $_POST['alamat'] ?? '');

    // Handling Upload Berkas CV
    if (isset($_FILES['berkas']) && $_FILES['berkas']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['berkas']['tmp_name'];
        $fileName    = $_FILES['berkas']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
        if (in_array($fileExtension, $allowedExtensions)) {
            
            // Buat nama file unik agar tidak timpa
            $newFileName = time() . '_' . preg_replace('/[^a-zA-Z0-9\._-]/', '', $fileName);
            $uploadFileDir = './uploads_cv/';

            // Buat folder uploads_cv jika belum ada
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            $dest_path = $uploadFileDir . $newFileName;

            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                // Simpan ke Database
                $query = "INSERT INTO lamaran_kerja (posisi, nama_lengkap, whatsapp, alamat, berkas_cv) 
                          VALUES ('$posisi', '$nama_lengkap', '$whatsapp', '$alamat', '$newFileName')";
                
                if (mysqli_query($koneksi, $query)) {
                    echo "<script>alert('Lamaran berhasil dikirim!'); window.location.href='index.html';</script>";
                } else {
                    echo "Gagal menyimpan ke database: " . mysqli_error($koneksi);
                }
            } else {
                echo "<script>alert('Gagal mengunggah berkas.'); history.back();</script>";
            }
        } else {
            echo "<script>alert('Format berkas tidak diizinkan! Gunakan PDF, JPG, atau PNG.'); history.back();</script>";
        }
    } else {
        echo "<script>alert('Pilih berkas CV terlebih dahulu.'); history.back();</script>";
    }
}
?>