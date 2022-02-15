<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>REGISTRASI | TOKO RAGIL 2 REBORN</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url("assets/plugins/fontawesome-free/css/all.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/dist/css/adminlte.min.css") ?>">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url("assets/plugins/select2/css/select2.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css") ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url("assets/intanmas/img/simpus.png") ?>">
</head>


<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary m-3">
            <div class="card-header text-center">
                <h1><b>REGISTRASI</b></h1>
            </div>
            <div class="card-body">
                <?php if ($this->session->flashdata("gagal")) : ?>
                    <div class="alert bg-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal !</strong> <?= $this->session->flashdata("gagal") ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php unset($_SESSION["gagal"]);
                endif; ?>

                <?php if ($this->session->flashdata("sukses")) : ?>
                    <div class="alert bg-success alert-dismissible fade show" role="alert">
                        <strong>Sukses !</strong> <?= $this->session->flashdata("sukses") ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php unset($_SESSION["sukses"]);
                endif; ?>
                <form action="<?= base_url('auth/add_user') ?>" method="POST">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="recipient-name" class="control-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="recipient-name" class="control-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="recipient-name" class="control-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="konfirmasi_password" id="konfirmasi_password" placeholder="Konfirmasi Password" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="recipient-name" class="control-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="recipient-name" class="control-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="alamat_lengkap" id="alamat_lengkap" placeholder="Alamat Lengkap" cols="3" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="recipient-name" class="control-label">Kode Pos <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="kode_pos" id="kode_pos" placeholder="Kode Pos" required>
                            </div>
                            <div class="col-md-6">
                                <label for="recipient-name" class="control-label">Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="telepon" id="telepon" placeholder="Telepon" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="recipient-name" class="control-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">LOGIN</button>
                        </div>
                    </div>
                </form>
                <p class="mt-3">
                    <a href="<?= base_url() ?> " class="text-center">Sudah punya akun? Daftar</a>
                </p>
            </div>
        </div>
    </div>

    <script src="<?= base_url("assets/plugins/jquery/jquery.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/bootstrap/js/bootstrap.bundle.min.js") ?>"></script>
    <script src="<?= base_url("assets/dist/js/adminlte.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/select2/js/select2.full.min.js") ?>"></script>

    <script>
        $(function() {
            $('.select2').select2()
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
</body>

</html>