<?php
session_start();
include "../koneksi.php";

// Pastikan form dikirim
if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("Location: login.php");
    exit;
}

// Ambil username dan password
$username = mysqli_real_escape_string(
    $koneksi,
    $_POST['username']
);

$password = mysqli_real_escape_string(
    $koneksi,
    $_POST['password']
);

// Cek khusus pelanggan
$query = mysqli_query($koneksi, "
    SELECT *
    FROM tb_user
    WHERE username = '$username'
    AND password = '$password'
    AND role = 'pelanggan'
");

// Jika ditemukan
if (mysqli_num_rows($query) > 0) {

    $data = mysqli_fetch_assoc($query);

    // Simpan session pelanggan
    $_SESSION['id_user']  = $data['id_user'];
    $_SESSION['nama']     = $data['nama'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['role']     = 'pelanggan';

    // Masuk dashboard pelanggan
    header("Location: dashboard.php");
    exit;

} else {

    echo "<script>

        alert('Username atau Password pelanggan salah!');

        window.location='login.php';

    </script>";

    exit;
}
?>