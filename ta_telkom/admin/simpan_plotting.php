<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] != "admin") {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $id_tiket   = $_POST['id_tiket'];
    $id_teknisi = $_POST['id_teknisi'];

    $query = mysqli_query($koneksi, "
        UPDATE tb_gangguan
        SET
            id_teknisi='$id_teknisi',
            status='On Progress'
        WHERE id_tiket='$id_tiket'
    ");

    if ($query) {

        $_SESSION['pesan'] = "Teknisi berhasil diplotting.";

        header("Location: monitoring.php");
        exit;

    } else {

        die("Gagal plotting : " . mysqli_error($koneksi));

    }

} else {

    header("Location: monitoring.php");
    exit;

}