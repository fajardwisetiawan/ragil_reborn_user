<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark"><b><?= $title ?></b></h1>
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

        <div class="row">
            <div class="col-12 col-sm-12">
                <div class="card card-info card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="tabPemesanan" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tabBelum" data-toggle="pill" href="#contentBelum" role="tab" aria-controls="contentBelum">Belum Bayar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tabDikemas" data-toggle="pill" href="#contentDikemas" role="tab" aria-controls="contentDikemas">Dikemas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tabDikirim" data-toggle="pill" href="#contentDikirim" role="tab" aria-controls="contentDikirim">Dikirim</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tabBatal" data-toggle="pill" href="#contentBatal" role="tab" aria-controls="contentBatal">Batal</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" role="tabpanel" id="contentBelum">
                                <?php $this->load->view("transaksi/pemesanan/belum"); ?>
                            </div>

                            <div class="tab-pane fade show" role="tabpanel" id="contentDikemas">
                                <?php $this->load->view("transaksi/pemesanan/dikemas"); ?>
                            </div>

                            <div class="tab-pane fade show" role="tabpanel" id="contentDikirim">
                                <?php $this->load->view("transaksi/pemesanan/dikirim"); ?>
                            </div>

                            <div class="tab-pane fade show" role="tabpanel" id="contentBatal">
                                <?php $this->load->view("transaksi/pemesanan/batal"); ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>