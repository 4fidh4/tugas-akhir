<?php
session_start();
include "../koneksi.php";

// Cek login pelanggan
if (!isset($_SESSION['username']) || $_SESSION['role'] != "pelanggan") {
    header("Location: ../index.php");
    exit;
}

// Ambil id user pelanggan
$id_user = $_SESSION['id_user'];
$nama_pelanggan = $_SESSION['nama'];

// Ambil tiket berdasarkan nama pelanggan
$query = mysqli_query($koneksi, "
    SELECT *
    FROM tb_gangguan
    WHERE nama_pelanggan = '$nama_pelanggan'
    ORDER BY id_tiket DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Tiket Saya - Telkom Akses</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        body {
            background: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .navbar-telkom {
            background: #d71920;
        }

        .content {
            padding: 30px;
        }

        .card {
            border: none;
            border-radius: 12px;
        }

        .card-header {
            background: #d71920;
            color: white;
            font-weight: bold;
        }

        .table th {
            background: #f1f1f1;
            white-space: nowrap;
        }

        .status {
            padding: 6px 10px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: bold;
        }

        .status-open {
            background: #ffc107;
            color: #000;
        }

        .status-progress {
            background: #0d6efd;
            color: white;
        }

        .status-pending {
            background: #fd7e14;
            color: white;
        }

        .status-closed {
            background: #198754;
            color: white;
        }

    </style>

</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-dark navbar-telkom">

    <div class="container-fluid px-4">

        <span class="navbar-brand fw-bold">
            TELKOM AKSES
        </span>

        <div>

            <span class="text-white me-3">
                <?= htmlspecialchars($_SESSION['nama']); ?>
            </span>

            <a href="../logout.php"
               class="btn btn-light btn-sm">
                Logout
            </a>

        </div>

    </div>

</nav>


<!-- CONTENT -->

<div class="content">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3>
                Tiket Saya
            </h3>

            <p class="text-muted mb-0">
                Daftar pengaduan gangguan yang telah Anda laporkan.
            </p>

        </div>

        <a href="dashboard.php"
           class="btn btn-secondary">
            ← Kembali
        </a>

    </div>


    <div class="card shadow-sm">

        <div class="card-header">

            Daftar Tiket Gangguan

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>No Tiket</th>

                            <th>Nama Pelanggan</th>

                            <th>Jenis Gangguan</th>

                            <th>STO</th>

                            <th>Tanggal Lapor</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php

                    $no = 1;

                    if (mysqli_num_rows($query) > 0) {

                        while ($data = mysqli_fetch_assoc($query)) {

                            $status = strtolower(trim($data['status']));

                            ?>

                            <tr>

                                <td>
                                    <?= $no++; ?>
                                </td>

                                <td>
                                    <strong>
                                        <?= htmlspecialchars($data['nomor_tiket']); ?>
                                    </strong>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['nama_pelanggan']); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['jenis_gangguan']); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['sto']); ?>
                                </td>

                                <td>
                                    <?= !empty($data['tanggal_lapor'])
                                        ? date('d-m-Y H:i', strtotime($data['tanggal_lapor']))
                                        : '-'; ?>
                                </td>

                                <td>

                                    <?php if ($status == 'open') { ?>

                                        <span class="status status-open">
                                            Open
                                        </span>

                                    <?php } elseif ($status == 'on progress') { ?>

                                        <span class="status status-progress">
                                            On Progress
                                        </span>

                                    <?php } elseif ($status == 'pending validasi') { ?>

                                        <span class="status status-pending">
                                            Pending Validasi
                                        </span>

                                    <?php } elseif ($status == 'closed') { ?>

                                        <span class="status status-closed">
                                            Closed
                                        </span>

                                    <?php } else { ?>

                                        <span class="badge bg-secondary">
                                            <?= htmlspecialchars($data['status']); ?>
                                        </span>

                                    <?php } ?>

                                </td>

                            </tr>

                            <?php

                        }

                    } else {

                        ?>

                        <tr>

                            <td colspan="7"
                                class="text-center text-muted py-4">

                                Belum ada tiket gangguan.

                            </td>

                        </tr>

                        <?php

                    }

                    ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


</body>
</html>