<?php
session_start();
include "../koneksi.php";

// Cek login teknisi
if (!isset($_SESSION['username']) || $_SESSION['role'] != "teknisi") {
    header("Location: ../index.php");
    exit;
}

// Cek ID tiket
if (!isset($_GET['id'])) {
    header("Location: tiket_saya.php");
    exit;
}

$id_tiket = $_GET['id'];

// Ambil data tiket
$query = mysqli_query($koneksi,"
SELECT *
FROM tb_gangguan
WHERE id_tiket='$id_tiket'
");

if(mysqli_num_rows($query)==0){
    echo "<script>
    alert('Data tiket tidak ditemukan');
    window.location='tiket_saya.php';
    </script>";
    exit;
}

$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Closing Tiket</title>

<link rel="stylesheet" href="../assets/css/style.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<?php include "../includes/sidebar_teknisi.php"; ?>

<div class="content">

<?php include "../includes/navbar.php"; ?>

<div class="card shadow mt-4">

<div class="card-header bg-danger text-white">

<h4>Closing Tiket Gangguan</h4>

</div>

<div class="card-body">

<form action="simpan_closing.php" method="POST" enctype="multipart/form-data">

<input type="hidden" name="id_tiket" value="<?= $data['id_tiket']; ?>">

<div class="mb-3">

<label>Nomor Tiket</label>

<input
type="text"
class="form-control"
value="<?= $data['nomor_tiket']; ?>"
readonly>

</div>

<div class="mb-3">

<label>Nama Pelanggan</label>

<input
type="text"
class="form-control"
value="<?= $data['nama_pelanggan']; ?>"
readonly>

</div>

<div class="mb-3">

<label>Jenis Gangguan</label>

<input
type="text"
class="form-control"
value="<?= $data['jenis_gangguan']; ?>"
readonly>

</div>

<div class="mb-3">

<label>STO</label>

<input
type="text"
class="form-control"
value="<?= $data['sto']; ?>"
readonly>

</div>

<div class="mb-3">

<label>Hasil Perbaikan</label>

<textarea
name="hasil_perbaikan"
class="form-control"
rows="5"
required></textarea>

</div>

<div class="mb-3">

<label>Upload Foto Bukti</label>

<input
type="file"
name="foto_bukti"
class="form-control"
accept="image/*"
required>

</div>

<button
type="submit"
class="btn btn-danger">

Simpan Closing

</button>

<a
href="tiket_saya.php"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

</body>

</html>