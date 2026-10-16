<?php
include "../koneksi.php";

$nomor_tiket    = trim($_POST['nomor_tiket']);
$nama_pelanggan = trim($_POST['nama_pelanggan']);
$alamat         = trim($_POST['alamat']);
$jenis_gangguan = trim($_POST['jenis_gangguan']);
$sto             = trim($_POST['sto']);
$tanggal_lapor   = $_POST['tanggal_lapor'];

// Validasi nomor tiket hanya angka
if (!preg_match('/^[0-9]+$/', $nomor_tiket)) {
    echo "<script>
            alert('No Tiket hanya boleh menggunakan angka!');
            window.history.back();
          </script>";
    exit;
}

// Validasi nama pelanggan hanya huruf dan spasi
if (!preg_match('/^[a-zA-ZÀ-ÿ\s]+$/', $nama_pelanggan)) {
    echo "<script>
            alert('Nama pelanggan hanya boleh menggunakan huruf dan spasi!');
            window.history.back();
          </script>";
    exit;
}

// Simpan data
$query = mysqli_query($koneksi, "
    INSERT INTO tb_gangguan
    (nomor_tiket, nama_pelanggan, alamat, jenis_gangguan, sto, tanggal_lapor, status)
    VALUES
    ('$nomor_tiket', '$nama_pelanggan', '$alamat', '$jenis_gangguan', '$sto', '$tanggal_lapor', 'Open')
");

if ($query) {
    echo "<script>
            alert('Tiket berhasil ditambahkan!');
            window.location='monitoring.php';
          </script>";
} else {
    echo "<script>
            alert('Tiket gagal ditambahkan!');
            window.history.back();
          </script>";
}
?>