<?php 
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reservasi Wisata</title>
</head>
<body>

<h2>Selamat Datang, <?php echo $_SESSION['user']; ?></h2>

<a href="logout.php">Logout</a>

<hr>

<h3>Halaman Reservasi</h3>
<p>Di sini nanti tampil daftar destinasi wisata + booking.</p>

</body>
</html>
