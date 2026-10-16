<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Monitoring Tiket Gangguan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center vh-100">

        <div class="col-md-5">

            <div class="card shadow-lg border-0">

                <div class="card-header bg-danger text-white text-center">

                    <img src="assets/img/logo_telkom.png" width="80" class="mb-2">

                    <h3>Monitoring Tiket</h3>

                    <small>PT. Telkom Akses Serang</small>

                </div>

                <div class="card-body p-4">

                    <form action="proses_login.php" method="POST">

                        <div class="mb-3">

                            <label class="form-label">Username</label>

                            <input type="text"
                                   name="username"
                                   class="form-control"
                                   required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">Password</label>

                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   required>

                        </div>

                        <button type="submit"
                                name="login"
                                class="btn btn-danger w-100">

                            Login

                        </button>

                    </form>

                </div>

                <div class="card-footer text-center">

                    <small>
                        Sistem Informasi Monitoring dan Closing Tiket Gangguan
                    </small>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>