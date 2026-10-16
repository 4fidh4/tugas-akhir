<?php
session_start();

// Jika sudah login sebagai pelanggan
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

    <title>Login Pelanggan - Telkom Akses</title>

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


        /* ================================
           HEADER
        ================================= */

        .header {

            background: #d71920;

            color: white;

            text-align: center;

            padding: 35px 20px;

        }

        .header h1 {

            margin: 0;

            font-size: 42px;

            font-weight: bold;

            letter-spacing: 1px;

        }

        .header h2 {

            margin-top: 10px;

            margin-bottom: 5px;

            font-size: 28px;

            font-weight: bold;

        }

        .header p {

            margin: 0;

            font-size: 16px;

        }


        /* ================================
           AREA LOGIN
        ================================= */

        .login-area {

            display: flex;

            justify-content: center;

            align-items: center;

            padding: 50px 20px;

        }


        /* ================================
           CARD LOGIN
        ================================= */

        .login-card {

            width: 100%;

            max-width: 430px;

            background: white;

            padding: 35px;

            border-radius: 12px;

            box-shadow: 0 5px 20px rgba(0,0,0,0.10);

        }


        .login-title {

            text-align: center;

            margin-bottom: 8px;

            font-size: 26px;

            font-weight: bold;

            color: #222;

        }


        .login-subtitle {

            text-align: center;

            color: #777;

            margin-bottom: 30px;

        }


        /* ================================
           FORM
        ================================= */

        .form-label {

            font-weight: 600;

            margin-bottom: 8px;

        }


        .form-control {

            height: 48px;

            border-radius: 7px;

            border: 1px solid #ddd;

        }


        .form-control:focus {

            border-color: #d71920;

            box-shadow: 0 0 0 0.15rem rgba(215,25,32,0.15);

        }


        /* ================================
           BUTTON LOGIN
        ================================= */

        .btn-login {

            width: 100%;

            height: 48px;

            background: #d71920;

            color: white;

            border: none;

            border-radius: 7px;

            font-size: 16px;

            font-weight: bold;

            margin-top: 5px;

        }


        .btn-login:hover {

            background: #b9151b;

            color: white;

        }


        /* ================================
           DAFTAR
        ================================= */

        .register-area {

            text-align: center;

            margin-top: 25px;

            padding-top: 20px;

            border-top: 1px solid #eee;

        }


        .register-area p {

            margin-bottom: 10px;

            color: #555;

        }


        .btn-register {

            width: 100%;

            height: 45px;

            background: white;

            color: #d71920;

            border: 1px solid #d71920;

            border-radius: 7px;

            font-weight: bold;

            text-decoration: none;

            display: flex;

            align-items: center;

            justify-content: center;

        }


        .btn-register:hover {

            background: #d71920;

            color: white;

        }


        /* ================================
           FOOTER
        ================================= */

        .footer {

            text-align: center;

            color: #888;

            font-size: 13px;

            padding: 20px;

        }


        /* ================================
           RESPONSIVE
        ================================= */

        @media (max-width: 576px) {

            .header {

                padding: 28px 15px;

            }

            .header h1 {

                font-size: 32px;

            }

            .header h2 {

                font-size: 23px;

            }

            .login-card {

                padding: 25px 20px;

            }

        }

    </style>

</head>


<body>


<!-- =========================================
     HEADER TELKOM
========================================= -->

<div class="header">

    <h1>
        TELKOM
    </h1>

    <h2>
        Layanan Pelanggan
    </h2>

    <p>
        PT Telkom Akses Serang
    </p>

</div>



<!-- =========================================
     LOGIN
========================================= -->

<div class="login-area">

    <div class="login-card">


        <div class="login-title">

            Login Pelanggan

        </div>


        <div class="login-subtitle">

            Masuk untuk mengakses layanan pengaduan

        </div>


        <form action="proses_login.php"
              method="POST">


            <!-- USERNAME -->

            <div class="mb-3">

                <label class="form-label">

                    Username

                </label>

                <input
                    type="text"
                    name="username"
                    class="form-control"
                    placeholder="Masukkan username"
                    required
                >

            </div>


            <!-- PASSWORD -->

            <div class="mb-4">

                <label class="form-label">

                    Password

                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Masukkan password"
                    required
                >

            </div>


            <!-- LOGIN -->

            <button
                type="submit"
                class="btn-login">

                Masuk

            </button>


        </form>



        <!-- DAFTAR -->

        <div class="register-area">

            <p>

                Belum memiliki akun?

            </p>


            <a
                href="daftar.php"
                class="btn-register">

                Daftar Akun

            </a>

        </div>


    </div>

</div>



<!-- =========================================
     FOOTER
========================================= -->

<div class="footer">

    © <?= date('Y'); ?> PT Telkom Akses Serang

</div>


</body>

</html>