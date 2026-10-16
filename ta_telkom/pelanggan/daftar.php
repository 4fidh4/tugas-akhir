<?php
session_start();

if (isset($_SESSION['role']) && $_SESSION['role'] == "pelanggan") {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Daftar Pelanggan - Telkom Akses</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        .register-container {
            min-height: 100vh;
            display: flex;
        }

        .left-side {
            width: 50%;
            background: #d71920;
            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 50px;
        }

        .left-content {
            max-width: 500px;
        }

        .icon {
            font-size: 75px;
            margin-bottom: 20px;
        }

        .logo {
            font-size: 50px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .left-content h1 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .left-content p {
            font-size: 17px;
            line-height: 1.7;
        }

        .right-side {
            width: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 40px;
        }

        .register-card {
            width: 100%;
            max-width: 480px;

            background: white;

            padding: 40px;

            border-radius: 18px;

            box-shadow: 0 8px 30px rgba(0,0,0,0.10);
        }

        .title {
            font-size: 28px;
            font-weight: bold;
        }

        .subtitle {
            color: #777;
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
        }

        .form-control {
            height: 48px;
            border-radius: 8px;
        }

        .btn-register {
            width: 100%;
            height: 48px;

            background: #d71920;
            color: white;

            border: none;
            border-radius: 8px;

            font-weight: bold;
        }

        .btn-register:hover {
            background: #b9151b;
            color: white;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #d71920;
            text-decoration: none;
            font-weight: 600;
        }

        .info-box {
            background: #fff3cd;
            border: 1px solid #ffe69c;
            border-radius: 8px;

            padding: 12px;

            font-size: 14px;

            margin-bottom: 20px;
        }

        @media (max-width: 768px) {

            .register-container {
                flex-direction: column;
            }

            .left-side,
            .right-side {
                width: 100%;
            }

            .left-side {
                padding: 35px 25px;
                text-align: center;
            }

            .right-side {
                padding: 25px;
            }

        }

    </style>

</head>

<body>

<div class="register-container">


    <!-- KIRI -->

    <div class="left-side">

        <div class="left-content">

            <div class="icon">
                👤
            </div>

            <div class="logo">
                TELKOM
            </div>

            <h1>
                Daftar Akun Pelanggan
            </h1>

            <p>
                Buat akun untuk melaporkan gangguan
                dan memantau tiket layanan Telkom Anda.
            </p>

            <p>
                Pendaftaran hanya dapat dilakukan oleh
                pelanggan yang memiliki tiket gangguan
                yang terdaftar di sistem.
            </p>

        </div>

    </div>


    <!-- KANAN -->

    <div class="right-side">

        <div class="register-card">

            <div class="title">
                Daftar Pelanggan
            </div>

            <div class="subtitle">
                Buat akun pelanggan baru
            </div>


            <div class="info-box">

                <strong>Perhatian</strong><br>

                Pastikan nomor pelanggan Anda sudah
                terdaftar pada tiket Telkom.

            </div>


            <form action="proses_daftar.php"
                  method="POST">


                <!-- NOMOR PELANGGAN -->

                <div class="mb-3">

                    <label class="form-label">
                        Nomor Pelanggan
                    </label>

                    <input type="text"
                           name="nomor_pelanggan"
                           class="form-control"
                           placeholder="Masukkan nomor pelanggan"
                           required>

                </div>


                <!-- NAMA -->

                <div class="mb-3">

                    <label class="form-label">
                        Nama Pelanggan
                    </label>

                    <input type="text"
                           name="nama"
                           class="form-control"
                           placeholder="Masukkan nama sesuai data Telkom"
                           required>

                </div>


                <!-- USERNAME -->

                <div class="mb-3">

                    <label class="form-label">
                        Username
                    </label>

                    <input type="text"
                           name="username"
                           class="form-control"
                           placeholder="Buat username"
                           required>

                </div>


                <!-- PASSWORD -->

                <div class="mb-4">

                    <label class="form-label">
                        Password
                    </label>

                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Buat password"
                           required>

                </div>


                <button type="submit"
                        class="btn btn-register">

                    Daftar Akun

                </button>


            </form>


            <div class="login-link">

                Sudah memiliki akun?

                <a href="login.php">
                    Login Pelanggan
                </a>

            </div>

        </div>

    </div>

</div>

</body>

</html>