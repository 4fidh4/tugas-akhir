<?php
session_start();
include "../koneksi.php";

// Cek login admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != "admin") {
    header("Location: ../index.php");
    exit;
}

// Ambil semua tiket yang sudah masuk tahap validasi
$query = mysqli_query($koneksi, "
    SELECT 
        tb_gangguan.*,
        tb_user.nama AS teknisi
    FROM tb_gangguan
    LEFT JOIN tb_user 
        ON tb_gangguan.id_teknisi = tb_user.id_user
    WHERE tb_gangguan.status IN ('Pending Validasi', 'Closed')
    ORDER BY tb_gangguan.id_tiket DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Validasi Closing Tiket</title>

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

        .validasi-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }

        .validasi-header {
            background: #ed1c24;
            color: white;
            padding: 16px 20px;
        }

        .validasi-header h5 {
            margin: 0;
            font-weight: 600;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f8d7da;
            vertical-align: middle;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle;
        }

        .btn-validasi {
            background: #198754;
            border-color: #198754;
            color: white;
        }

        .btn-validasi:hover {
            background: #157347;
            border-color: #157347;
            color: white;
        }

        .status-menunggu {
            background: #ffc107;
            color: #212529;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-sudah {
            background: #198754;
            color: white;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
        }

        .foto-bukti {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
        }

        .foto-bukti:hover {
            text-decoration: underline;
        }

        .hasil-perbaikan {
            max-width: 220px;
        }

    </style>

</head>

<body>

    <?php include "../includes/sidebar_admin.php"; ?>

    <div class="content">

        <?php include "../includes/navbar.php"; ?>


        <!-- JUDUL -->
        <h2 class="page-title">
            Validasi Closing Tiket
        </h2>


        <!-- CARD -->
        <div class="card validasi-card shadow-sm">

            <div class="validasi-header">

                <h5>
                    Daftar Tiket Validasi
                </h5>

            </div>


            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead>

                            <tr>

                                <th>No</th>

                                <th>No Tiket</th>

                                <th>Pelanggan</th>

                                <th>Teknisi</th>

                                <th>Hasil Perbaikan</th>

                                <th>Foto Bukti</th>

                                <th>Tanggal Validasi</th>

                                <th>Status</th>

                                <th>Aksi</th>

                            </tr>

                        </thead>


                        <tbody>

                        <?php

                        $no = 1;

                        if (mysqli_num_rows($query) > 0) {

                            while ($data = mysqli_fetch_assoc($query)) {

                        ?>

                            <tr>

                                <!-- NO -->
                                <td>
                                    <?= $no++; ?>
                                </td>


                                <!-- NO TIKET -->
                                <td>
                                    <?= htmlspecialchars($data['nomor_tiket']); ?>
                                </td>


                                <!-- PELANGGAN -->
                                <td>
                                    <?= htmlspecialchars($data['nama_pelanggan']); ?>
                                </td>


                                <!-- TEKNISI -->
                                <td>
                                    <?= htmlspecialchars($data['teknisi'] ?? 'Belum Ada'); ?>
                                </td>


                                <!-- HASIL PERBAIKAN -->
                                <td class="hasil-perbaikan">

                                    <?php

                                    if (!empty($data['hasil_perbaikan'])) {

                                        echo htmlspecialchars($data['hasil_perbaikan']);

                                    } elseif (!empty($data['hasil_kerja'])) {

                                        echo htmlspecialchars($data['hasil_kerja']);

                                    } else {

                                        echo "-";

                                    }

                                    ?>

                                </td>


                                <!-- FOTO BUKTI -->
                                <td>

                                    <?php if (!empty($data['foto_bukti'])) { ?>

                                        <a
                                            href="../uploads/<?= htmlspecialchars($data['foto_bukti']); ?>"
                                            target="_blank"
                                            class="foto-bukti"
                                        >
                                            Lihat Foto
                                        </a>

                                    <?php } else { ?>

                                        <span class="text-muted">
                                            Tidak ada
                                        </span>

                                    <?php } ?>

                                </td>


                                <!-- TANGGAL VALIDASI -->
                                <td>

                                    <?php

                                    if (!empty($data['tgl_validasi'])) {

                                        echo date(
                                            'd-m-Y H:i',
                                            strtotime($data['tgl_validasi'])
                                        );

                                    } else {

                                        echo "-";

                                    }

                                    ?>

                                </td>


                                <!-- STATUS -->
                                <td>

                                    <?php if ($data['status'] == 'Pending Validasi') { ?>

                                        <span class="status-menunggu">
                                            Menunggu Validasi
                                        </span>

                                    <?php } elseif ($data['status'] == 'Closed') { ?>

                                        <span class="status-sudah">
                                            Sudah Validasi
                                        </span>

                                    <?php } else { ?>

                                        <span class="badge bg-secondary">
                                            <?= htmlspecialchars($data['status']); ?>
                                        </span>

                                    <?php } ?>

                                </td>


                                <!-- AKSI -->
                                <td>

                                    <?php if ($data['status'] == 'Pending Validasi') { ?>

                                        <a
                                            href="proses_validasi.php?id=<?= $data['id_tiket']; ?>"
                                            class="btn btn-validasi btn-sm"
                                            onclick="return confirm('Apakah tiket ini sudah benar dan ingin divalidasi?')"
                                        >
                                            Validasi
                                        </a>

                                    <?php } else { ?>

                                        <span class="text-success fw-semibold">
                                            ✓ Selesai
                                        </span>

                                    <?php } ?>

                                </td>

                            </tr>

                        <?php

                            }

                        } else {

                        ?>

                            <tr>

                                <td colspan="9" class="text-center py-4">

                                    Belum ada tiket yang masuk tahap validasi.

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