<?php
session_start();
include "../koneksi.php";

// Cek login admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != "admin") {
    header("Location: ../index.php");
    exit;
}

// Cek ID tiket
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: validasi.php");
    exit;
}

$id_tiket = intval($_GET['id']);

// Update status dan tanggal validasi
$query = mysqli_query($koneksi, "
    UPDATE tb_gangguan
    SET 
        status = 'Closed',
        tgl_validasi = NOW()
    WHERE id_tiket = '$id_tiket'
");

// Cek apakah query berhasil
if ($query) {

    echo "<script>
        alert('Tiket berhasil divalidasi!');
        window.location='validasi.php';
    </script>";

} else {

    echo "<script>
        alert('Gagal melakukan validasi: " . mysqli_error($koneksi) . "');
        window.location='validasi.php';
    </script>";
}

exit;
?>