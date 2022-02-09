<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark"><b><?= $title ?></b> | <?= $app_name ?></h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
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

        <div class="container-fluid">
            <div class="card bg-light">
                <div class="card-header text-muted border-bottom-0">
                    Contact Person
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-7">
                            <h2><b><?= $toko ? $toko->nama : "---" ?></b></h2>
                            <p class="text-muted text-sm"><?= $toko ? $toko->tentang : "---" ?></p>
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small pb-2"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> <?= $toko ? $toko->alamat_lengkap : "---" ?></li>
                                <li class="small pb-2"><span class="fa-li"><i class="fab fa-whatsapp-square" style="font-size: 20px;"></i></span> <?= $toko ? $toko->nomor_wa : "---" ?></li>
                                <li class="small pb-2"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> <?= $toko ? $toko->telepon : "---" ?></li>
                            </ul>
                        </div>
                        <div class="col-5 text-center">
                            <?= $toko->gambar != null || $toko->gambar != '' ? "<img class='img-circle img-fluid' src='http://localhost/ragil_reborn_admin/images/toko/$toko->gambar' width='180'>" : "<img class='img-circle img-fluid' src='" . base_url("images/not_found/not_found.png") . "'  width='180'>" ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>