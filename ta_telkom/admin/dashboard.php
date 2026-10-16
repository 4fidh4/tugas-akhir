<?php
session_start();

include "../koneksi.php";

// Cek login
if (!isset($_SESSION['username']) || $_SESSION['role'] != "admin") {
    header("Location: ../index.php");
    exit;
}

// Total tiket
$total_tiket = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM tb_gangguan")
)['total'];

// Tiket Open
$tiket_open = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM tb_gangguan WHERE status='Open'")
)['total'];

// Tiket On Progress
$tiket_progress = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM tb_gangguan WHERE status='On Progress'")
)['total'];

// Tiket Closed
$tiket_closed = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM tb_gangguan WHERE status='Closed'")
)['total'];

// Jumlah teknisi
$total_teknisi = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM tb_user WHERE role='teknisi'")
)['total'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Admin</title>

    <link rel="stylesheet" href="../assets/css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include "../includes/sidebar_admin.php"; ?>

<div class="content">

<?php include "../includes/navbar.php"; ?>

<h3 class="mt-4">Dashboard Admin</h3>

<p>
    Selamat Datang,
    <b><?= $_SESSION['nama']; ?></b><br>
    Role : <b><?= $_SESSION['role']; ?></b>
</p>

<div class="row">

    <div class="col-md-3">
        <div class="card shadow p-3">
            <h5>Total Tiket</h5>
            <h2><?= $total_tiket; ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow p-3">
            <h5>Open</h5>
            <h2><?= $tiket_open; ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow p-3">
            <h5>On Progress</h5>
            <h2><?= $tiket_progress; ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow p-3">
            <h5>Closed</h5>
            <h2><?= $tiket_closed; ?></h2>
        </div>
    </div>

</div>

<div class="card shadow mt-4 p-4">
    <h5>Jumlah Teknisi Aktif</h5>
    <h1><?= $total_teknisi; ?></h1>
</div>

</div>

<?php include "../includes/footer.php"; ?>

</body>
</html>