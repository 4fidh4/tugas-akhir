<?php
session_start();
include "../koneksi.php";

// Cek login admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != "admin") {
    header("Location: ../index.php");
    exit;
}

// Cek parameter ID tiket
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: monitoring.php");
    exit;
}

$id_tiket = intval($_GET['id']);

// Ambil data tiket
$query_tiket = mysqli_query($koneksi, "
    SELECT *
    FROM tb_gangguan
    WHERE id_tiket = '$id_tiket'
");

if (!$query_tiket || mysqli_num_rows($query_tiket) == 0) {
    echo "<script>
            alert('Data tiket tidak ditemukan!');
            window.location='monitoring.php';
          </script>";
    exit;
}

$tiket = mysqli_fetch_assoc($query_tiket);

// Ambil daftar teknisi
$query_teknisi = mysqli_query($koneksi, "
    SELECT id_user, nama
    FROM tb_user
    WHERE role = 'teknisi'
    ORDER BY nama ASC
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

        .plotting-title {
            font-size: 30px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .card-header-tiket {
            background: #ed1c24;
            color: white;
            padding: 15px 20px;
            border-radius: 10px 10px 0 0;
        }

        .card-header-tiket h5 {
            margin: 0;
            font-weight: 600;
        }

        .label-data {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
        }

        .value-data {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 10px 12px;
            min-height: 42px;
        }

        .teknisi-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-top: 20px;
        }

        .teknisi-header {
            background: #f8d7da;
            padding: 15px 20px;
            border-bottom: 1px solid #ddd;
        }

        .teknisi-header h5 {
            margin: 0;
            color: #333;
            font-weight: 600;
        }

        .teknisi-body {
            padding: 20px;
        }

        .btn-danger {
            background-color: #ed1c24;
            border-color: #ed1c24;
        }

        .btn-danger:hover {
            background-color: #c81017;
            border-color: #c81017;
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
        <div class="mt-4">

            <h2 class="plotting-title">
                Plotting Teknisi Gangguan
            </h2>

        </div>


        <!-- INFORMASI TIKET -->
        <div class="card shadow-sm border-0">

            <div class="card-header-tiket">

                <h5>
                    Informasi Tiket
                </h5>

            </div>


            <div class="card-body">

                <div class="row g-4">

                    <!-- Nomor Tiket -->
                    <div class="col-md-6">

                        <div class="label-data">
                            Nomor Tiket
                        </div>

                        <div class="value-data">
                            <?= htmlspecialchars($tiket['nomor_tiket']); ?>
                        </div>

                    </div>


                    <!-- Nama Pelanggan -->
                    <div class="col-md-6">

                        <div class="label-data">
                            Nama Pelanggan
                        </div>

                        <div class="value-data">
                            <?= htmlspecialchars($tiket['nama_pelanggan']); ?>
                        </div>

                    </div>


                    <!-- Alamat -->
                    <div class="col-md-6">

                        <div class="label-data">
                            Alamat
                        </div>

                        <div class="value-data">
                            <?= htmlspecialchars($tiket['alamat']); ?>
                        </div>

                    </div>


                    <!-- Jenis Gangguan -->
                    <div class="col-md-6">

                        <div class="label-data">
                            Jenis Gangguan
                        </div>

                        <div class="value-data">
                            <?= htmlspecialchars($tiket['jenis_gangguan']); ?>
                        </div>

                    </div>


                    <!-- STO -->
                    <div class="col-md-6">

                        <div class="label-data">
                            STO
                        </div>

                        <div class="value-data">
                            <?= htmlspecialchars($tiket['sto']); ?>
                        </div>

                    </div>


                    <!-- Tanggal Lapor -->
                    <div class="col-md-6">

                        <div class="label-data">
                            Tanggal Lapor
                        </div>

                        <div class="value-data">
                            <?= htmlspecialchars($tiket['tanggal_lapor']); ?>
                        </div>

                    </div>


                    <!-- Status -->
                    <div class="col-md-6">

                        <div class="label-data">
                            Status Tiket
                        </div>

                        <div class="value-data">

                            <?php if ($tiket['status'] == 'Open') { ?>

                                <span class="badge bg-danger">
                                    Open
                                </span>

                            <?php } elseif ($tiket['status'] == 'Closed') { ?>

                                <span class="badge bg-success">
                                    Closed
                                </span>

                            <?php } else { ?>

                                <span class="badge bg-warning text-dark">
                                    <?= htmlspecialchars($tiket['status']); ?>
                                </span>

                            <?php } ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- FORM PLOTTING -->
        <div class="teknisi-card shadow-sm">

            <div class="teknisi-header">

                <h5>
                    Pilih Teknisi
                </h5>

            </div>


            <div class="teknisi-body">

                <form action="simpan_plotting.php" method="POST">

                    <!-- ID TIKET -->
                    <input
                        type="hidden"
                        name="id_tiket"
                        value="<?= $tiket['id_tiket']; ?>"
                    >


                    <div class="mb-4">

                        <label
                            for="id_teknisi"
                            class="form-label fw-semibold"
                        >
                            Teknisi yang Ditugaskan
                        </label>


                        <select
                            name="id_teknisi"
                            id="id_teknisi"
                            class="form-select"
                            required
                        >

                            <option value="">
                                -- Pilih Teknisi --
                            </option>


                            <?php while ($t = mysqli_fetch_assoc($query_teknisi)) { ?>

                                <option
                                    value="<?= $t['id_user']; ?>"
                                >
                                    <?= htmlspecialchars($t['nama']); ?>
                                </option>

                            <?php } ?>

                        </select>


                        <div class="form-text">
                            Pilih teknisi yang akan menangani gangguan pelanggan.
                        </div>

                    </div>


                    <!-- Tombol -->
                    <div class="d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-danger"
                        >
                            Simpan Plotting
                        </button>


                        <a
                            href="monitoring.php"
                            class="btn btn-secondary"
                        >
                            Kembali
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>