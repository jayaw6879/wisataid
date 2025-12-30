<?php
print_r($_POST);
exit;

// backend/simpan_reservasi.php

$host = "localhost";
$user = "root"; // Default XAMPP
$pass = "";     // Default XAMPP kosong
$db   = "wisataid";

// 1. Koneksi ke Database
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// 2. Tangkap data dari form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama    = $_POST['nama'];
    $email   = $_POST['email'];
    $telepon = $_POST['telepon'];
    $paket   = $_POST['paket'];
    $tanggal = $_POST['tanggal'];
    $jumlah  = $_POST['jumlah'];
    $catatan = $_POST['catatan'];

    // Logika perhitungan harga di sisi Server (untuk keamanan)
    $harga_list = [
        "rajaampat" => 7500000,
        "bromo"     => 1800000,
        "toba"      => 2800000,
        "bali"      => 2500000,
        "komodo"    => 5500000,
        "morotai"   => 3200000,
        "baluran"   => 950000,
        "wakatobi"  => 4500000
    ];
    
    $total_harga = $harga_list[$paket] * $jumlah;

    // 3. Query Insert
    $sql = "INSERT INTO reservasi (nama, email, telepon, paket, tanggal, jumlah, catatan, total_harga) 
            VALUES ('$nama', '$email', '$telepon', '$paket', '$tanggal', '$jumlah', '$catatan', '$total_harga')";

    if (mysqli_query($conn, $sql)) {
        // Berhasil simpan, lalu arahkan kembali atau beri respon
        echo "<script>
                alert('Data Reservasi Berhasil Disimpan!');
                window.location.href = 'index.html';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
