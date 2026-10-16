<?php
session_start();
include "koneksi.php";

// Cek apakah form dikirim
if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("Location: index.php");
    exit;
}

// Ambil data dari form
$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = mysqli_real_escape_string($koneksi, $_POST['password']);

// Cek username dan password
$query = mysqli_query($koneksi, "
    SELECT *
    FROM tb_user
    WHERE username = '$username'
    AND password = '$password'
");

// Cek apakah user ditemukan
if (mysqli_num_rows($query) > 0) {

    $data = mysqli_fetch_assoc($query);

    // Bersihkan role dari spasi dan huruf besar/kecil
    $role = strtolower(trim($data['role']));

    // Simpan session
    $_SESSION['id_user']  = $data['id_user'];
    $_SESSION['nama']     = $data['nama'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['role']     = $role;

    // ==========================
    // REDIRECT SESUAI ROLE
    // ==========================

    if ($role == "admin") {

        header("Location: admin/dashboard.php");
        exit;

    } elseif ($role == "teknisi") {

        header("Location: teknisi/dashboard.php");
        exit;

    } elseif ($role == "pelanggan") {

        header("Location: pelanggan/dashboard.php");
        exit;

    } else {

        // Jika role tidak dikenali
        session_destroy();

        echo "<script>
                alert('Role tidak dikenali: $role');
                window.location='index.php';
              </script>";
        exit;
    }

} else {

    // Username atau password salah
    echo "<script>
            alert('Username atau Password salah!');
            window.location='index.php';
          </script>";
    exit;
}
?>