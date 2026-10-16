<?php
session_start();
include "../koneksi.php";

// ======================================================
// CEK LOGIN ADMIN
// ======================================================

if (!isset($_SESSION['username']) || $_SESSION['role'] != "admin") {
    header("Location: ../index.php");
    exit;
}


// ======================================================
// AMBIL DATA LAPORAN
// ======================================================

$query = mysqli_query($koneksi, "
    SELECT 
        tb_gangguan.*,
        tb_user.nama AS teknisi
    FROM tb_gangguan
    LEFT JOIN tb_user
        ON tb_gangguan.id_teknisi = tb_user.id_user
    ORDER BY tb_gangguan.id_tiket DESC
");


// Cek query
if (!$query) {
    die("Query error: " . mysqli_error($koneksi));
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Laporan Monitoring Tiket</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- CSS Sistem -->
    <link rel="stylesheet"
          href="../assets/css/style.css">


    <style>

        /* ==================================================
           TAMPILAN LAPORAN
        ================================================== */

        .laporan-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
        }


        .judul-laporan {
            text-align: center;
            margin-bottom: 25px;
        }

        .judul-laporan h2 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .judul-laporan h4 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .judul-laporan p {
            margin: 0;
            font-size: 14px;
        }


        .table-laporan {
            width: 100%;
            border-collapse: collapse;
        }

        .table-laporan th,
        .table-laporan td {
            border: 1px solid #333;
            padding: 8px;
            font-size: 13px;
            vertical-align: middle;
        }

        .table-laporan th {
            text-align: center;
            font-weight: bold;
            background: #f2f2f2;
        }


        .tombol-laporan {
            margin-bottom: 20px;
        }


        /* ==================================================
           KHUSUS CETAK
        ================================================== */

        @media print {

            /* Ukuran kertas */
            @page {
                size: landscape;
                margin: 15mm;
            }


            /* Semua elemen disembunyikan */
            body * {
                visibility: hidden;
            }


            /* Hanya laporan yang ditampilkan */
            #printArea,
            #printArea * {
                visibility: visible;
            }


            /* Laporan memenuhi halaman */
            #printArea {
                position: absolute;
                left: 0;
                top: 0;

                width: 100%;

                margin: 0;
                padding: 0;

                background: white;
            }


            /* Hilangkan tombol */
            .no-print {
                display: none !important;
            }


            /* Hilangkan bayangan */
            .card {
                box-shadow: none !important;
                border: none !important;
            }


            .laporan-container {
                padding: 0;
                margin: 0;

                border: none;
                box-shadow: none;
            }


            /* Judul */
            .judul-laporan {
                margin-bottom: 20px;
            }

            .judul-laporan h2 {
                font-size: 20px;
            }

            .judul-laporan h4 {
                font-size: 16px;
            }

            .judul-laporan p {
                font-size: 12px;
            }


            /* Tabel */
            .table-laporan {
                width: 100% !important;
            }

            .table-laporan th,
            .table-laporan td {
                border: 1px solid #000 !important;

                color: #000 !important;

                background: white !important;

                font-size: 10px;

                padding: 6px;
            }


            .table-laporan th {
                font-weight: bold;
                text-align: center;
            }


            /* Jangan memotong baris tabel */
            tr {
                page-break-inside: avoid;
            }

        }

    </style>

</head>


<body>


<!-- ======================================================
     SIDEBAR ADMIN
     Tetap tampil di browser,
     tetapi otomatis hilang ketika dicetak.
====================================================== -->

<?php include "../includes/sidebar_admin.php"; ?>


<!-- ======================================================
     CONTENT
====================================================== -->

<div class="content">


    <!-- NAVBAR -->

    <div class="no-print">

        <?php include "../includes/navbar.php"; ?>

    </div>


    <!-- ==================================================
         AREA LAPORAN
    ================================================== -->

    <div id="printArea">


        <div class="laporan-container shadow-sm">


            <!-- ==================================================
                 JUDUL LAPORAN
            ================================================== -->

            <div class="judul-laporan">

                <h2>
                    TELKOM AKSES
                </h2>

                <h4>
                    LAPORAN MONITORING TIKET
                </h4>

                <p>
                    PT Telkom Akses Serang
                </p>

                <p>
                    Dicetak pada:
                    <?= date('d-m-Y H:i'); ?>
                </p>

            </div>


            <!-- ==================================================
                 TOMBOL CETAK
            ================================================== -->

            <div class="tombol-laporan no-print">

                <button type="button"
                        onclick="window.print()"
                        class="btn btn-danger">

                    🖨 Cetak Laporan

                </button>

            </div>


            <!-- ==================================================
                 TABEL LAPORAN
            ================================================== -->

            <div class="table-responsive">

                <table class="table-laporan">

                    <thead>

                        <tr>

                            <th width="40">
                                No
                            </th>

                            <th>
                                No Tiket
                            </th>

                            <th>
                                Pelanggan
                            </th>

                            <th>
                                Alamat
                            </th>

                            <th>
                                Gangguan
                            </th>

                            <th>
                                STO
                            </th>

                            <th>
                                Tanggal Lapor
                            </th>

                            <th>
                                Teknisi
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Tanggal Closing
                            </th>

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

                            <td class="text-center">

                                <?= $no++; ?>

                            </td>


                            <!-- NOMOR TIKET -->

                            <td>

                                <?= htmlspecialchars(
                                    $data['nomor_tiket']
                                ); ?>

                            </td>


                            <!-- PELANGGAN -->

                            <td>

                                <?= htmlspecialchars(
                                    $data['nama_pelanggan']
                                ); ?>

                            </td>


                            <!-- ALAMAT -->

                            <td>

                                <?= htmlspecialchars(
                                    $data['alamat']
                                ); ?>

                            </td>


                            <!-- GANGGUAN -->

                            <td>

                                <?= htmlspecialchars(
                                    $data['jenis_gangguan']
                                ); ?>

                            </td>


                            <!-- STO -->

                            <td>

                                <?= htmlspecialchars(
                                    $data['sto']
                                ); ?>

                            </td>


                            <!-- TANGGAL LAPOR -->

                            <td>

                                <?php

                                if (!empty($data['tanggal_lapor'])) {

                                    echo date(
                                        'd-m-Y H:i',
                                        strtotime(
                                            $data['tanggal_lapor']
                                        )
                                    );

                                } else {

                                    echo "-";

                                }

                                ?>

                            </td>


                            <!-- TEKNISI -->

                            <td>

                                <?= !empty($data['teknisi'])
                                    ? htmlspecialchars($data['teknisi'])
                                    : '-';
                                ?>

                            </td>


                            <!-- STATUS -->

                            <td class="text-center">

                                <?= htmlspecialchars(
                                    $data['status']
                                ); ?>

                            </td>


                            <!-- TANGGAL CLOSING -->

                            <td>

                                <?php

                                if (!empty($data['tgl_closing'])) {

                                    echo date(
                                        'd-m-Y H:i',
                                        strtotime(
                                            $data['tgl_closing']
                                        )
                                    );

                                } else {

                                    echo "-";

                                }

                                ?>

                            </td>

                        </tr>


                    <?php

                        }

                    } else {

                    ?>

                        <tr>

                            <td colspan="10"
                                class="text-center">

                                Belum ada data tiket.

                            </td>

                        </tr>

                    <?php

                    }

                    ?>

                    </tbody>

                </table>

            </div>


            <!-- ==================================================
                 TANDA TANGAN
            ================================================== -->

            <div class="row mt-5">

                <div class="col-8"></div>

                <div class="col-4 text-center">

                    <p>
                        Serang,
                        <?= date('d-m-Y'); ?>
                    </p>

                    <br>
                    <br>
                    <br>

                    <strong>
                        Admin Helpdesk
                    </strong>

                </div>

            </div>


        </div>

    </div>


</div>


</body>

</html>