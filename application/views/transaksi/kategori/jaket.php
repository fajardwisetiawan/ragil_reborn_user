<div class="content-wrapper">
    <div class="row text-center m-3">
        <?php
        foreach ($produk as $p) {
            if ($p->id_kategori == 1) {
        ?>
                <div class="card ml-3" style="width: 16rem;">
                    <div class="card-body p-1">
                        <img src="<?= 'http://localhost/ragil_reborn_admin/images/' . $p->gambar ?>" class="card-img-top">
                    </div>
                    <div class="card-footer">
                        <h5 class="text-center mb-0"><?= $p->nama  ?></h5>
                        <small><?= substr($p->deskripsi, 0, 50) . "..." ?></small>
                        <br>
                        <span class="badge badge-pill badge-danger"><?= $p->jenis_barang ?></span>
                        <span class="badge badge-pill badge-success mb-2">Rp. <?= number_format($p->harga, 2) ?></span>
                        <br>
                        <?php if ($p->jenis_barang == "READY") { ?>
                            <a href="<?= base_url('transaksi/detail/detail_ready/') . $p->id . '/' . $p->jenis_barang ?>" class="btn btn-sm btn-info">DETAIL</a>
                        <?php } else { ?>
                            <a href="<?= base_url('transaksi/detail/detail_preorder/') . $p->id . '/' . $p->jenis_barang ?>" class="btn btn-sm btn-info">DETAIL</a>
                        <?php } ?>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
</div>