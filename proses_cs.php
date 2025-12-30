<?php
// 1. Koneksi ke Database
$conn = mysqli_connect("localhost", "root", "", "db_wisata");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// 2. Tangkap Data Form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $nohp     = mysqli_real_escape_string($conn, $_POST['nohp']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $pesan    = mysqli_real_escape_string($conn, $_POST['pesan']);

    // 3. Masukkan ke Database
    $sql = "INSERT INTO pesan_cs (nama, email, nohp, kategori, pesan) 
            VALUES ('$nama', '$email', '$nohp', '$kategori', '$pesan')";

    if (mysqli_query($conn, $sql)) {
        // Tampilan Sukses Sederhana
        echo "
        <div style='background: #0f172a; color: white; height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; font-family: sans-serif; text-align: center;'>
            <h1 style='color: #3bffb3;'>Pesan Terkirim!</h1>
            <p>Terima kasih <strong>$nama</strong>, tim kami akan segera menghubungi Anda.</p>
            <br>
            <a href='customer.html' style='background: #3bffb3; color: #0f172a; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;'>Kembali</a>
        </div>";
    } else {
        echo "Gagal mengirim pesan: " . mysqli_error($conn);
    }
}
?>
