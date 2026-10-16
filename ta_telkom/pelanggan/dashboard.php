<?php
session_start();
include "../koneksi.php";

// Cek login pelanggan
if (!isset($_SESSION['username']) || $_SESSION['role'] != "pelanggan") {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Pelanggan - Telkom Akses</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            background: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        .navbar-telkom {
            background: #d71920;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .content {
            padding: 30px;
        }

        .welcome {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .menu-card {
            background: white;
            border: none;
            border-radius: 12px;
            padding: 25px;
            height: 100%;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        .menu-card h5 {
            font-weight: bold;
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

        .icon {
            font-size: 40px;
            margin-bottom: 15px;
        }

        footer {
            margin-top: 50px;
            padding: 20px;
            text-align: center;
            color: #777;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark navbar-telkom">
    <div class="container-fluid px-4">

        <span class="navbar-brand">
            TELKOM AKSES
        </span>

        <div class="d-flex align-items-center">

            <span class="text-white me-3">
                <?= htmlspecialchars($_SESSION['nama']); ?>
            </span>

            <a href="../logout.php" class="btn btn-light btn-sm">
                Logout
            </a>

        </div>

    </div>
</nav>


<!-- CONTENT -->
<div class="content">

    <!-- WELCOME -->
    <div class="welcome">

        <h3>
            Dashboard Pelanggan
        </h3>

        <p class="mb-0">
            Selamat datang,
            <strong><?= htmlspecialchars($_SESSION['nama']); ?></strong>.
            Silakan gunakan layanan pengaduan gangguan.
        </p>

    </div>


    <!-- MENU -->
    <div class="row g-4">

        <!-- PENGADUAN -->
        <div class="col-md-6">

            <div class="menu-card">

                <div class="icon">
                    📢
                </div>

                <h5>
                    Pengaduan Gangguan
                </h5>

                <p>
                    Gunakan menu ini untuk melaporkan
                    gangguan jaringan atau layanan internet
                    yang sedang Anda alami.
                </p>

                <a href="../pengaduan.php"
                   class="btn btn-telkom">

                    Laporkan Gangguan

                </a>

            </div>

        </div>


        <!-- TIKET -->
        <div class="col-md-6">

            <div class="menu-card">

                <div class="icon">
                    🎫
                </div>

                <h5>
                    Tiket Saya
                </h5>

                <p>
                    Lihat tiket gangguan yang telah Anda
                    laporkan beserta status penanganannya.
                </p>

                <a href="tiket_saya.php"
                   class="btn btn-secondary">

                    Lihat Tiket

                </a>

            </div>

        </div>

    </div>

</div>


<footer>
    Sistem Informasi Monitoring dan Closing Tiket Gangguan
    <br>
    PT Telkom Akses Serang
</footer>


</body>
</html>