<?php
session_start();
include "../koneksi.php";

// Cek login admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != "admin") {
    header("Location: ../index.php");
    exit;
}

// Ambil tiket yang belum memiliki teknisi
$query = mysqli_query($koneksi, "
    SELECT 
        tb_gangguan.*,
        tb_user.nama AS teknisi
    FROM tb_gangguan
    LEFT JOIN tb_user 
        ON tb_gangguan.id_teknisi = tb_user.id_user
    WHERE tb_gangguan.id_teknisi IS NULL
       OR tb_gangguan.id_teknisi = 0
    ORDER BY tb_gangguan.id_tiket DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Plotting Teknisi</title>

    <link rel="stylesheet" href="../assets/css/style.css">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>

        .page-title {
            font-size: 30px;
            font-weight: 600;
            margin-top: 25px;
            margin-bottom: 20px;
        }

        .plotting-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }

        .plotting-header {
            background: #ed1c24;
            color: white;
            padding: 18px 20px;
        }

        .plotting-header h5 {
            margin: 0;
            font-weight: 600;
        }

        .table thead th {
            background: #f8d7da;
            vertical-align: middle;
        }

        .table td {
            vertical-align: middle;
        }

        .btn-plotting {
            background: #198754;
            color: white;
            border: none;
        }

        .btn-plotting:hover {
            background: #157347;
            color: white;
        }

        .empty-box {
            text-align: center;
            padding: 40px;
            color: #666;
        }

    </style>

</head>

<body>

    <!-- Sidebar Admin -->
    <?php include "../includes/sidebar_admin.php"; ?>

    <div class="content">

        <!-- Navbar -->
        <?php include "../includes/navbar.php"; ?>


        <!-- Judul -->
        <h2 class="page-title">
            Plotting Teknisi
        </h2>


        <!-- Card -->
        <div class="card plotting-card shadow-sm">

            <div class="plotting-header">

                <h5>
                    Daftar Tiket Belum Diplotting
                </h5>

            </div>


            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover mb-0">

                        <thead>

                            <tr>

                                <th style="width: 60px;">No</th>

                                <th>No Tiket</th>

                                <th>Nama Pelanggan</th>

                                <th>Alamat</th>

                                <th>Jenis Gangguan</th>

                                <th>STO</th>

                                <th>Tanggal Lapor</th>

                                <th style="width: 130px;">Aksi</th>

                            </tr>

                        </thead>


                        <tbody>

                        <?php

                        $no = 1;

                        if (mysqli_num_rows($query) > 0) {

                            while ($data = mysqli_fetch_assoc($query)) {

                        ?>

                            <tr>

                                <td>
                                    <?= $no++; ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['nomor_tiket']); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['nama_pelanggan']); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['alamat']); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['jenis_gangguan']); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['sto']); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['tanggal_lapor']); ?>
                                </td>

                                <td>

                                    <a
                                        href="plotting.php?id=<?= $data['id_tiket']; ?>"
                                        class="btn btn-plotting btn-sm"
                                    >
                                        Plotting
                                    </a>

                                </td>

                            </tr>

                        <?php

                            }

                        } else {

                        ?>

                            <tr>

                                <td colspan="8">

                                    <div class="empty-box">

                                        <h5>
                                            Tidak Ada Tiket
                                        </h5>

                                        <p class="mb-0">
                                            Semua tiket sudah memiliki teknisi.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>