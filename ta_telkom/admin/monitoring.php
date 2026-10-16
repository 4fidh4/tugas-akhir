<?php
session_start();
include "../koneksi.php";

// Cek login admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != "admin") {
    header("Location: ../index.php");
    exit;
}

// Ambil data tiket + nama teknisi
$query = mysqli_query($koneksi, "
SELECT 
    tb_gangguan.*,
    tb_user.nama AS teknisi
FROM tb_gangguan
LEFT JOIN tb_user
ON tb_gangguan.id_teknisi = tb_user.id_user
ORDER BY tb_gangguan.id_tiket DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Monitoring Tiket</title>

    <link rel="stylesheet" href="../assets/css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include "../includes/sidebar_admin.php"; ?>

<div class="content">

<?php include "../includes/navbar.php"; ?>

<?php
if(isset($_SESSION['pesan'])){
?>
<div class="alert alert-success alert-dismissible fade show mt-3">
    <?= $_SESSION['pesan']; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php
unset($_SESSION['pesan']);
}
?>

<div class="d-flex justify-content-between align-items-center mt-4 mb-3">

    <h3>Monitoring Tiket Gangguan</h3>

    <a href="tambah_tiket.php" class="btn btn-danger">
        + Tambah Tiket
    </a>

</div>

<div class="card shadow">

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
    <th>Tanggal Lapor</th>
    <th>Status</th>
    <th>Teknisi</th>
    <th>Aksi</th>
</tr>

</thead>

<tbody>

<?php
$no = 1;

while ($data = mysqli_fetch_assoc($query)) {
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
if ($data['status'] == "Closed") {
    echo "<span class='badge bg-success'>Closed</span>";
}
elseif ($data['status'] == "On Progress") {
    echo "<span class='badge bg-warning text-dark'>On Progress</span>";
}
else {
    echo "<span class='badge bg-danger'>Open</span>";
}
?>

</td>

<td>

<?php
if (!empty($data['teknisi'])) {
    echo $data['teknisi'];
} else {
    echo "<span class='text-danger'>Belum Plotting</span>";
}
?>

</td>

<td>

<a href="detail_tiket.php?id=<?= $data['id_tiket']; ?>"
class="btn btn-primary btn-sm">
Detail
</a>

<a href="plotting.php?id=<?= $data['id_tiket']; ?>"
class="btn btn-success btn-sm">
Plotting
</a>

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