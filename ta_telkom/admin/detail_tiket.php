<?php
session_start();
include "../koneksi.php";

// Cek login admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != "admin") {
    header("Location: ../index.php");
    exit;
}

// Cek apakah ID tiket dikirim
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['pesan'] = "ID tiket tidak ditemukan.";
    header("Location: monitoring.php");
    exit;
}

$id_tiket = intval($_GET['id']);

// Ambil data tiket + nama teknisi
$query = mysqli_query($koneksi, "
    SELECT 
        tb_gangguan.*,
        tb_user.nama AS teknisi
    FROM tb_gangguan
    LEFT JOIN tb_user
        ON tb_gangguan.id_teknisi = tb_user.id_user
    WHERE tb_gangguan.id_tiket = '$id_tiket'
    LIMIT 1
");

// Cek apakah data ditemukan
if (!$query || mysqli_num_rows($query) == 0) {
    $_SESSION['pesan'] = "Data tiket tidak ditemukan.";
    header("Location: monitoring.php");
    exit;
}

$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Tiket</title>

    <link rel="stylesheet" href="../assets/css/style.css">

    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >

</head>

<body>

<?php include "../includes/sidebar_admin.php"; ?>

<div class="content">

<?php include "../includes/navbar.php"; ?>


<!-- JUDUL -->
<div class="d-flex justify-content-between align-items-center mt-4 mb-3">

    <h3>Detail Tiket Gangguan</h3>

    <a href="monitoring.php" class="btn btn-secondary">
        ← Kembali
    </a>

</div>


<!-- DETAIL TIKET -->
<div class="card shadow">

    <div class="card-header bg-danger text-white">

        <h5 class="mb-0">
            Informasi Tiket
        </h5>

    </div>


    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered align-middle">

                <tr>

                    <th width="25%" class="table-danger">
                        Nomor Tiket
                    </th>

                    <td>
                        <?= htmlspecialchars($data['nomor_tiket']); ?>
                    </td>

                </tr>


                <tr>

                    <th class="table-danger">
                        Nama Pelanggan
                    </th>

                    <td>
                        <?= htmlspecialchars($data['nama_pelanggan']); ?>
                    </td>

                </tr>


                <tr>

                    <th class="table-danger">
                        Alamat
                    </th>

                    <td>
                        <?= htmlspecialchars($data['alamat']); ?>
                    </td>

                </tr>


                <tr>

                    <th class="table-danger">
                        Jenis Gangguan
                    </th>

                    <td>
                        <?= htmlspecialchars($data['jenis_gangguan']); ?>
                    </td>

                </tr>


                <tr>

                    <th class="table-danger">
                        STO
                    </th>

                    <td>
                        <?= htmlspecialchars($data['sto']); ?>
                    </td>

                </tr>


                <tr>

                    <th class="table-danger">
                        Tanggal Lapor
                    </th>

                    <td>
                        <?= htmlspecialchars($data['tanggal_lapor']); ?>
                    </td>

                </tr>


                <tr>

                    <th class="table-danger">
                        Status
                    </th>

                    <td>

                        <?php

                        if ($data['status'] == "Closed") {

                            echo '<span class="badge bg-success">
                                    Closed
                                  </span>';

                        } 
                        elseif ($data['status'] == "On Progress") {

                            echo '<span class="badge bg-warning text-dark">
                                    On Progress
                                  </span>';

                        } 
                        else {

                            echo '<span class="badge bg-danger">
                                    Open
                                  </span>';

                        }

                        ?>

                    </td>

                </tr>


                <tr>

                    <th class="table-danger">
                        Teknisi
                    </th>

                    <td>

                        <?php

                        if (!empty($data['teknisi'])) {

                            echo htmlspecialchars($data['teknisi']);

                        } else {

                            echo '<span class="text-danger">
                                    Belum Plotting
                                  </span>';

                        }

                        ?>

                    </td>

                </tr>

            </table>

        </div>

    </div>

</div>


<!-- INFORMASI TEKNISI -->
<div class="card shadow mt-4">

    <div class="card-header bg-danger text-white">

        <h5 class="mb-0">
            Informasi Penanganan
        </h5>

    </div>


    <div class="card-body">

        <div class="row">

            <div class="col-md-6 mb-3">

                <label class="fw-bold">
                    Nomor Tiket
                </label>

                <div class="form-control bg-light">
                    <?= htmlspecialchars($data['nomor_tiket']); ?>
                </div>

            </div>


            <div class="col-md-6 mb-3">

                <label class="fw-bold">
                    Teknisi
                </label>

                <div class="form-control bg-light">

                    <?php

                    if (!empty($data['teknisi'])) {

                        echo htmlspecialchars($data['teknisi']);

                    } else {

                        echo '<span class="text-danger">
                                Belum Plotting
                              </span>';

                    }

                    ?>

                </div>

            </div>


            <div class="col-md-6 mb-3">

                <label class="fw-bold">
                    Status Tiket
                </label>

                <div class="form-control bg-light">

                    <?php

                    if ($data['status'] == "Closed") {

                        echo '<span class="badge bg-success">
                                Closed
                              </span>';

                    } 
                    elseif ($data['status'] == "On Progress") {

                        echo '<span class="badge bg-warning text-dark">
                                On Progress
                              </span>';

                    } 
                    else {

                        echo '<span class="badge bg-danger">
                                Open
                              </span>';

                    }

                    ?>

                </div>

            </div>


            <div class="col-md-6 mb-3">

                <label class="fw-bold">
                    STO
                </label>

                <div class="form-control bg-light">
                    <?= htmlspecialchars($data['sto']); ?>
                </div>

            </div>

        </div>

    </div>

</div>


<!-- TOMBOL -->
<div class="mt-4 mb-4">

    <a 
        href="monitoring.php" 
        class="btn btn-secondary"
    >
        ← Kembali ke Monitoring
    </a>


    <?php if (empty($data['id_teknisi'])) { ?>

        <a 
            href="plotting.php?id=<?= $data['id_tiket']; ?>" 
            class="btn btn-success"
        >
            Plotting Teknisi
        </a>

    <?php } ?>

</div>


</div>

</body>
</html>