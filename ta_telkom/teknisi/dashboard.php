<?php
session_start();
include "../koneksi.php";

// Cek login teknisi
if (!isset($_SESSION['username']) || $_SESSION['role'] != "teknisi") {
    header("Location: ../index.php");
    exit;
}

$id_teknisi = $_SESSION['id_user'];

// Total tiket
$qTotal = mysqli_query($koneksi, "
SELECT COUNT(*) AS total
FROM tb_gangguan
WHERE id_teknisi='$id_teknisi'
");
$total = mysqli_fetch_assoc($qTotal);

// Tiket On Progress
$qProgress = mysqli_query($koneksi, "
SELECT COUNT(*) AS total
FROM tb_gangguan
WHERE id_teknisi='$id_teknisi'
AND status='On Progress'
");
$progress = mysqli_fetch_assoc($qProgress);

// Tiket Closed
$qClosed = mysqli_query($koneksi, "
SELECT COUNT(*) AS total
FROM tb_gangguan
WHERE id_teknisi='$id_teknisi'
AND status='Closed'
");
$closed = mysqli_fetch_assoc($qClosed);

// Ambil daftar tiket
$tiket = mysqli_query($koneksi, "
SELECT *
FROM tb_gangguan
WHERE id_teknisi='$id_teknisi'
ORDER BY id_tiket DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Dashboard Teknisi</title>

<link rel="stylesheet" href="../assets/css/style.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<?php include "../includes/sidebar_teknisi.php"; ?>

<div class="content">

<?php include "../includes/navbar.php"; ?>

<h3 class="mt-4">
Dashboard Teknisi
</h3>

<p>
Selamat Datang,
<b><?= $_SESSION['nama']; ?></b>
</p>

<div class="row mt-4">

<div class="col-md-4">

<div class="card shadow border-0">

<div class="card-body text-center">

<h5>Total Tiket</h5>

<h1 class="text-primary">
<?= $total['total']; ?>
</h1>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card shadow border-0">

<div class="card-body text-center">

<h5>On Progress</h5>

<h1 class="text-warning">
<?= $progress['total']; ?>
</h1>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card shadow border-0">

<div class="card-body text-center">

<h5>Closed</h5>

<h1 class="text-success">
<?= $closed['total']; ?>
</h1>

</div>

</div>

</div>

</div>

<div class="card shadow mt-5">

<div class="card-header bg-danger text-white">

<h5 class="mb-0">
Daftar Tiket Saya
</h5>

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-striped align-middle">

<thead class="table-danger">

<tr>

<th>No</th>
<th>No Tiket</th>
<th>Pelanggan</th>
<th>Gangguan</th>
<th>STO</th>
<th>Status</th>

</tr>

</thead>

<tbody>

<?php

$no = 1;

while($row = mysqli_fetch_assoc($tiket)){

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $row['nomor_tiket']; ?></td>

<td><?= $row['nama_pelanggan']; ?></td>

<td><?= $row['jenis_gangguan']; ?></td>

<td><?= $row['sto']; ?></td>

<td>

<?php

if($row['status']=="Closed"){

echo "<span class='badge bg-success'>Closed</span>";

}elseif($row['status']=="On Progress"){

echo "<span class='badge bg-warning text-dark'>On Progress</span>";

}else{

echo "<span class='badge bg-danger'>Open</span>";

}

?>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</body>

</html>