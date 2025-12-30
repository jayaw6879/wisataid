<?php
// 1. KONEKSI KE DATABASE
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_wisata"; // Pastikan nama database ini sesuai di phpMyAdmin Anda

$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// 2. PROSES DATA JIKA FORM DISUBMIT
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Mengambil data dari input 'name' di HTML
    $nama    = mysqli_real_escape_string($conn, $_POST['nama']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $paket   = $_POST['paket'];
    $tanggal = $_POST['tanggal'];
    $jumlah  = (int)$_POST['jumlah'];
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan']);

    // 3. LOGIKA PERHITUNGAN HARGA (Sisi Server)
    $hargaSatuan = 0;
    switch ($paket) {
        case 'rajaampat': $hargaSatuan = 7500000; break;
        case 'bromo':     $hargaSatuan = 1800000; break;
        case 'toba':      $hargaSatuan = 2800000; break;
        case 'bali':      $hargaSatuan = 2500000; break;
        case 'komodo':    $hargaSatuan = 5500000; break;
        case 'morotai':   $hargaSatuan = 3200000; break;
        case 'baluran':   $hargaSatuan = 950000;  break;
        case 'wakatobi':  $hargaSatuan = 4500000; break;
    }

    $total_bayar = $hargaSatuan * $jumlah;

    // 4. INSERT DATA KE TABEL RESERVASI
    $sql = "INSERT INTO reservasi (nama, email, telepon, paket, tanggal, jumlah, catatan, total_bayar) 
            VALUES ('$nama', '$email', '$telepon', '$paket', '$tanggal', '$jumlah', '$catatan', '$total_bayar')";

    if (mysqli_query($conn, $sql)) {
        // Jika berhasil, tampilkan halaman pembayaran (menggantikan modal JS)
        ?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>Pembayaran - Wisata.id</title>
            <link rel="stylesheet" href="reservasi.css">
            <style>
                body { background: #0f172a; color: white; font-family: 'Segoe UI', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
                .payment-container { background: #1e293b; padding: 40px; border-radius: 20px; text-align: center; border: 1px solid #334155; box-shadow: 0 15px 35px rgba(0,0,0,0.5); max-width: 450px; }
                .qr-img { width: 250px; border: 4px solid #3bffb3; border-radius: 15px; margin: 20px 0; box-shadow: 0 0 20px rgba(59, 255, 179, 0.2); }
                .total-box { background: #0f172a; padding: 15px; border-radius: 10px; margin: 20px 0; }
                .total-price { color: #3bffb3; font-size: 24px; font-weight: bold; }
                .btn-finish { background: #3bffb3; color: #0f172a; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block; transition: 0.3s; }
                .btn-finish:hover { background: #2ecc91; transform: translateY(-2px); }
            </style>
        </head>
        <body>
            <div class="payment-container">
                <h2 style="margin-top:0;">Terima Kasih, <?php echo htmlspecialchars($nama); ?>!</h2>
                <p style="color: #94a3b8;">Data reservasi Anda telah kami simpan. Silakan selesaikan pembayaran melalui QRIS di bawah ini:</p>
                
                <img src="qr.jpeg" alt="QRIS" class="qr-img">
                
                <div class="total-box">
                    <p style="margin:0; font-size: 14px; color: #94a3b8;">Total Tagihan:</p>
                    <div class="total-price">IDR <?php echo number_format($total_bayar, 0, ',', '.'); ?></div>
                </div>

                <a href="index.html" class="btn-finish">Saya Sudah Bayar</a>
                <p style="font-size: 12px; color: #64748b; margin-top: 20px;">E-Tiket akan dikirim ke <?php echo htmlspecialchars($email); ?> setelah verifikasi.</p>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Gagal menyimpan: " . mysqli_error($conn);
    }
}
?>
