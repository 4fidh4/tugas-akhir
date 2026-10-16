<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != "admin") {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Tiket</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include "../includes/sidebar_admin.php"; ?>

<div class="content">

<?php include "../includes/navbar.php"; ?>

<div class="card shadow">

    <div class="card-header bg-danger text-white">
        <h4>Tambah Tiket Gangguan</h4>
    </div>

    <div class="card-body">

<form action="simpan_tiket.php" method="POST">

<div class="mb-3">
    <label for="nomor_tiket" class="form-label">No Tiket</label>
    <input type="text"
           name="nomor_tiket"
           id="nomor_tiket"
           class="form-control"
           required
           pattern="[0-9]+"
           title="Nomor tiket hanya boleh menggunakan angka">
</div>

<div class="mb-3">
    <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
    <input type="text"
           name="nama_pelanggan"
           id="nama_pelanggan"
           class="form-control"
           required
           pattern="[A-Za-zÀ-ÿ\s]+"
           title="Nama pelanggan hanya boleh menggunakan huruf dan spasi">
</div>

<div class="mb-3">
<label>Alamat</label>
<textarea name="alamat" class="form-control" required></textarea>
</div>

<div class="mb-3">
    <label class="form-label">Jenis Gangguan</label>

    <select name="jenis_gangguan" class="form-select" required>
        <option value="">-- Pilih Jenis Gangguan --</option>
        <option value="Internet Down">Internet Down</option>
        <option value="Internet Lambat">Internet Lambat</option>
        <option value="LOS Merah">LOS Merah</option>
        <option value="Modem Rusak">Modem Rusak</option>
        <option value="Putus Kabel FO">Putus Kabel FO</option>
        <option value="Gangguan WiFi">Gangguan WiFi</option>
        <option value="Migrasi">Migrasi</option>
        <option value="Lainnya">Lainnya</option>
    </select>
</div>

<div class="mb-3">
    <label class="form-label">STO</label>

    <select name="sto" class="form-select" required>
        <option value="">-- Pilih STO --</option>
        <option value="Serang">Serang</option>
        <option value="Cilegon">Cilegon</option>
        <option value="Pandeglang">Pandeglang</option>
        <option value="Rangkasbitung">Rangkasbitung</option>
        <option value="Labuan">Labuan</option>
    </select>
</div>

<div class="mb-3">
<label>Tanggal Lapor</label>
<input type="date" name="tanggal_lapor" class="form-control" required>
</div>

<button type="submit" class="btn btn-danger">
Simpan Tiket
</button>

<a href="monitoring.php" class="btn btn-secondary">
Kembali
</a>

</form>

    </div>

</div>

</div>

</body>
</html>