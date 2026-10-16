<?php

session_start();

include "../koneksi.php";


// ======================================================
// CEK FORM
// ======================================================

if ($_SERVER['REQUEST_METHOD'] != "POST") {

    header("Location: daftar.php");
    exit;

}


// ======================================================
// AMBIL DATA
// ======================================================

$nomor_pelanggan = mysqli_real_escape_string(
    $koneksi,
    trim($_POST['nomor_pelanggan'])
);

$nama = mysqli_real_escape_string(
    $koneksi,
    trim($_POST['nama'])
);

$username = mysqli_real_escape_string(
    $koneksi,
    trim($_POST['username'])
);

$password = mysqli_real_escape_string(
    $koneksi,
    trim($_POST['password'])
);


// ======================================================
// CEK NOMOR PELANGGAN PADA TIKET
// ======================================================

$cek_tiket = mysqli_query($koneksi, "

    SELECT *

    FROM tb_gangguan

    WHERE nomor_pelanggan = '$nomor_pelanggan'

    AND nama_pelanggan = '$nama'

    LIMIT 1

");


if (!$cek_tiket) {

    die("Query error: " . mysqli_error($koneksi));

}


// ======================================================
// JIKA TIDAK MEMILIKI TIKET
// ======================================================

if (mysqli_num_rows($cek_tiket) == 0) {

    echo "<script>

        alert(
            'Pendaftaran ditolak!\\n\\n' +
            'Nomor pelanggan dan nama tidak ditemukan pada data tiket Telkom.'
        );

        window.location='daftar.php';

    </script>";

    exit;
}


// ======================================================
// CEK USERNAME SUDAH ADA
// ======================================================

$cek_username = mysqli_query($koneksi, "

    SELECT *

    FROM tb_user

    WHERE username = '$username'

");


if (mysqli_num_rows($cek_username) > 0) {

    echo "<script>

        alert('Username sudah digunakan! Silakan gunakan username lain.');

        window.location='daftar.php';

    </script>";

    exit;
}


// ======================================================
// CEK NOMOR PELANGGAN SUDAH MEMILIKI AKUN
// ======================================================

$cek_nomor = mysqli_query($koneksi, "

    SELECT *

    FROM tb_user

    WHERE nomor_pelanggan = '$nomor_pelanggan'

    AND role = 'pelanggan'

");


if (mysqli_num_rows($cek_nomor) > 0) {

    echo "<script>

        alert('Nomor pelanggan tersebut sudah memiliki akun!');

        window.location='login.php';

    </script>";

    exit;
}


// ======================================================
// AMBIL ALAMAT DARI TIKET
// ======================================================

$tiket = mysqli_fetch_assoc($cek_tiket);

$alamat = mysqli_real_escape_string(
    $koneksi,
    $tiket['alamat']
);


// ======================================================
// SIMPAN AKUN PELANGGAN
// ======================================================

$query = mysqli_query($koneksi, "

    INSERT INTO tb_user
    (
        username,
        password,
        nama,
        nomor_pelanggan,
        alamat,
        role
    )

    VALUES
    (
        '$username',
        '$password',
        '$nama',
        '$nomor_pelanggan',
        '$alamat',
        'pelanggan'
    )

");


if ($query) {

    echo "<script>

        alert(
            'Pendaftaran berhasil!\\n\\nSilakan login menggunakan akun yang telah dibuat.'
        );

        window.location='login.php';

    </script>";

} else {

    echo "<script>

        alert(
            'Pendaftaran gagal!\\n\\n"
            . mysqli_error($koneksi) .
            "'
        );

        window.location='daftar.php';

    </script>";

}

?>