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
// AMBIL DATA PELANGGAN DARI DATABASE
// ======================================================

$username = mysqli_real_escape_string(
    $koneksi,
    $_SESSION['username']
);

$query = mysqli_query($koneksi, "
    SELECT *
    FROM tb_user
    WHERE username = '$username'
    AND role = 'pelanggan'
");

if (!$query || mysqli_num_rows($query) == 0) {

    echo "<script>
            alert('Data pelanggan tidak ditemukan!');
            window.location='index.php';
          </script>";
    exit;
}

$pelanggan = mysqli_fetch_assoc($query);


// Data otomatis dari akun
$nama_pelanggan  = $pelanggan['nama'];
$nomor_pelanggan = $pelanggan['nomor_pelanggan'];
$alamat          = $pelanggan['alamat'];

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Pengaduan Gangguan - Telkom Akses</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        body {
            background: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .header {
            background: #d71920;
            color: white;
            padding: 25px;
        }

        .header h2 {
            font-weight: bold;
        }

        .card {
            border: none;
            border-radius: 12px;
        }

        .readonly {
            background-color: #eeeeee !important;
            cursor: not-allowed;
        }

        .btn-telkom {
            background: #d71920;
            color: white;
            border: none;
        }

        .btn-telkom:hover {
            background: #b9151b;
            color: white;
        }

        .info {
            background: #fff3cd;
            border: 1px solid #ffe69c;
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 25px;
        }

    </style>

</head>

<body>


<!-- ======================================================
     HEADER
====================================================== -->

<div class="header">

    <div class="container">

        <h2 class="mb-1">
            Layanan Pengaduan Gangguan
        </h2>

        <p class="mb-0">
            PT Telkom Akses Serang
        </p>

    </div>

</div>


<!-- ======================================================
     CONTENT
====================================================== -->

<div class="container mt-4 mb-5">

    <div class="card shadow-sm">

        <div class="card-body p-4">

            <h4 class="fw-bold mb-3">
                Form Pengaduan Gangguan
            </h4>

            <div class="info">

                <strong>Informasi:</strong>

                Data identitas pelanggan telah terisi
                otomatis berdasarkan akun yang sedang login.

            </div>


            <form action="proses_pengaduan.php"
                  method="POST">


                <!-- ==================================================
                     NAMA PELANGGAN
                =================================================== -->

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Nama Pelanggan
                    </label>

                    <input type="text"
                           class="form-control readonly"
                           value="<?= htmlspecialchars($nama_pelanggan); ?>"
                           readonly>

                </div>


                <!-- ==================================================
                     NOMOR PELANGGAN
                =================================================== -->

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Nomor Pelanggan
                    </label>

                    <input type="text"
                           class="form-control readonly"
                           value="<?= htmlspecialchars($nomor_pelanggan); ?>"
                           readonly>

                </div>


                <!-- ==================================================
                     ALAMAT
                =================================================== -->

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Alamat Pelanggan
                    </label>

                    <textarea class="form-control readonly"
                              rows="3"
                              readonly><?= htmlspecialchars($alamat); ?></textarea>

                </div>


                <!-- ==================================================
                     JENIS GANGGUAN
                =================================================== -->

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Jenis Gangguan
                    </label>

                    <select name="jenis_gangguan"
                            class="form-select"
                            required>

                        <option value="">
                            -- Pilih Gangguan --
                        </option>

                        <option value="Internet Tidak Bisa Digunakan">
                            Internet Tidak Bisa Digunakan
                        </option>

                        <option value="Internet Lambat">
                            Internet Lambat
                        </option>

                        <option value="Tidak Ada Sinyal">
                            Tidak Ada Sinyal
                        </option>

                        <option value="Modem Bermasalah">
                            Modem Bermasalah
                        </option>

                        <option value="Gangguan Jaringan">
                            Gangguan Jaringan
                        </option>

                        <option value="Lainnya">
                            Lainnya
                        </option>

                    </select>

                </div>


                <!-- ==================================================
                     STO
                =================================================== -->

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        STO
                    </label>

                    <input type="text"
                           name="sto"
                           class="form-control"
                           placeholder="Masukkan STO"
                           required>

                </div>


                <!-- ==================================================
                     KETERANGAN
                =================================================== -->

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Keterangan Gangguan
                    </label>

                    <textarea name="keterangan"
                              class="form-control"
                              rows="4"
                              placeholder="Jelaskan gangguan yang dialami"
                              required></textarea>

                </div>


                <!-- ==================================================
                     BUTTON
                =================================================== -->

                <button type="submit"
                        class="btn btn-telkom">

                    📢 Kirim Pengaduan

                </button>

                <a href="pelanggan/dashboard.php"
                   class="btn btn-secondary">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

</body>
</html>