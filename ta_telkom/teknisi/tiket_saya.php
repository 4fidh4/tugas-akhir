<?php
session_start();
include "../koneksi.php";

// Cek login teknisi
if (!isset($_SESSION['username']) || $_SESSION['role'] != "teknisi") {
    header("Location: ../index.php");
    exit;
}

$id_teknisi = $_SESSION['id_user'];

// Ambil tiket milik teknisi
$query = mysqli_query($koneksi,"
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

<title>Tiket Saya</title>

<link rel="stylesheet" href="../assets/css/style.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<?php include "../includes/sidebar_teknisi.php"; ?>

<div class="content">

<?php include "../includes/navbar.php"; ?>

<h3 class="mt-4">
Tiket Saya
</h3>

<div class="card shadow mt-3">

<div class="card-header bg-danger text-white">

Daftar Tiket Yang Harus Dikerjakan

</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-striped align-middle">

<thead class="table-danger">

<tr>

<th>No</th>
<th>No Tiket</th>
<th>Nama Pelanggan</th>
<th>Alamat</th>
<th>Gangguan</th>
<th>STO</th>
<th>Tanggal</th>
<th>Status</th>
<th>Aksi</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

while($data=mysqli_fetch_assoc($query)){

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $data['nomor_tiket']; ?></td>

<td><?= $data['nama_pelanggan']; ?></td>

<td><?= $data['alamat']; ?></td>

<td><?= $data['jenis_gangguan']; ?></td>

<td><?= $data['sto']; ?></td>

<td><?= $data['tanggal_lapor']; ?></td>

<td>

<?php

if($data['status']=="Closed"){

echo "<span class='badge bg-success'>Closed</span>";

}elseif($data['status']=="On Progress"){

echo "<span class='badge bg-warning text-dark'>On Progress</span>";

}else{

echo "<span class='badge bg-danger'>Open</span>";

}

?>

</td>

<td>

<?php

if($data['status']=="On Progress"){

?>

<a href="closing.php?id=<?= $data['id_tiket']; ?>"
class="btn btn-success btn-sm">

Closing

</a>

<?php

}else{

echo "-";

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