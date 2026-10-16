<?php

session_start();
include "koneksi.php";


// ======================================================
// CEK LOGIN PELANGGAN
// ======================================================

if (!isset($_SESSION['username']) || $_SESSION['role'] != "pelanggan") {

    header("Location: index.php");
    exit;

}


// ======================================================
// CEK METHOD
// ======================================================

if ($_SERVER['REQUEST_METHOD'] != "POST") {

    header("Location: pengaduan.php");
    exit;

}


// ======================================================
// AMBIL DATA PELANGGAN DARI SESSION
// ======================================================

$username = mysqli_real_escape_string(
    $koneksi,
    $_SESSION['username']
);


$query_pelanggan = mysqli_query($koneksi, "
    SELECT *
    FROM tb_user
    WHERE username = '$username'
    AND role = 'pelanggan'
");


if (!$query_pelanggan || mysqli_num_rows($query_pelanggan) == 0) {

    echo "<script>
            alert('Data pelanggan tidak ditemukan!');
            window.location='index.php';
          </script>";

    exit;
}


$pelanggan = mysqli_fetch_assoc($query_pelanggan);


// Identitas pelanggan dari database
$nama_pelanggan  = $pelanggan['nama'];
$nomor_pelanggan = $pelanggan['nomor_pelanggan'];
$alamat          = $pelanggan['alamat'];


// ======================================================
// DATA PENGADUAN
// ======================================================

$jenis_gangguan = mysqli_real_escape_string(
    $koneksi,
    $_POST['jenis_gangguan']
);

$sto = mysqli_real_escape_string(
    $koneksi,
    $_POST['sto']
);

$keterangan = mysqli_real_escape_string(
    $koneksi,
    $_POST['keterangan']
);


// ======================================================
// GABUNG JENIS GANGGUAN DAN KETERANGAN
// ======================================================

$gangguan = $jenis_gangguan . " - " . $keterangan;


// ======================================================
// GENERATE NOMOR TIKET
// ======================================================

$nomor_tiket = "TA" . date("YmdHis");


// ======================================================
// SIMPAN TIKET
// ======================================================

$query = mysqli_query($koneksi, "

    INSERT INTO tb_gangguan
    (
        nomor_tiket,
        nama_pelanggan,
        alamat,
        jenis_gangguan,
        sto,
        tanggal_lapor,
        status,
        id_teknisi
    )

    VALUES
    (
        '$nomor_tiket',
        '$nama_pelanggan',
        '$alamat',
        '$gangguan',
        '$sto',
        NOW(),
        'Open',
        NULL
    )

");


// ======================================================
// HASIL
// ======================================================

if ($query) {

    echo "<script>

            alert(
                'Pengaduan berhasil dikirim!\\n\\nNomor Tiket: $nomor_tiket'
            );

            window.location='pelanggan/tiket_saya.php';

          </script>";

} else {

    echo "<script>

            alert('Pengaduan gagal dikirim!');

            window.history.back();

          </script>";

}

?>