<?php
session_start();
include "../koneksi.php";

// Cek login teknisi
if (!isset($_SESSION['username']) || $_SESSION['role'] != "teknisi") {
    header("Location: ../index.php");
    exit;
}

// Pastikan form dikirim
if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("Location: tiket_saya.php");
    exit;
}

$id_tiket = $_POST['id_tiket'];
$hasil_perbaikan = mysqli_real_escape_string($koneksi, $_POST['hasil_perbaikan']);

$tanggal = date("Y-m-d H:i:s");

// Upload foto
$foto = "";

if(isset($_FILES['foto_bukti']) && $_FILES['foto_bukti']['error'] == 0){

    $namaFile = $_FILES['foto_bukti']['name'];
    $tmpFile  = $_FILES['foto_bukti']['tmp_name'];

    $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

    $namaBaru = "closing_" . time() . "." . $ext;

    move_uploaded_file(
        $tmpFile,
        "../assets/upload/" . $namaBaru
    );

    $foto = $namaBaru;
}

// Update database
$query = mysqli_query($koneksi, "

UPDATE tb_gangguan

SET

hasil_perbaikan = '$hasil_perbaikan',
foto_bukti = '$foto',
tgl_closing = '$tanggal',
status = 'Pending Validasi'

WHERE id_tiket='$id_tiket'

");

if($query){

    $_SESSION['pesan'] = "Closing tiket berhasil dikirim.";

    header("Location: tiket_saya.php");
    exit;

}else{

    die("Gagal menyimpan closing : ".mysqli_error($koneksi));

}
?>