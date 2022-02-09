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
        <div class="container-fluid">
            <?php foreach ($tagihan as $t) { ?>
                <div class="card bg-light">
                    <a href="<?= base_url('transaksi/tagihan/detail_pemesanan/') . $t->id ?>">
                        <div class="card-body pt-0 pb-0">
                            <div class="row">
                                <div class="col-12 p-3">
                                    <small>ID Tagihan <b>#<?= $t->id ?> </b></small>
                                    <span class="badge badge-pill <?= $t->status == "BELUM_LUNAS" ? "badge-danger" : ($t->status == "BATAL" ? "badge-warning" : "badge-success") ?>"><?= $t->status ?></span>
                                    <div class="d-flex justify-content-between">
                                        <h5><b><?= $t->nama ?></b></h5>
                                        <h5><b>Rp. <?= number_format($t->total, 2) ?></b></h5>
                                    </div>
                                    <hr class="p-0 m-0">

                                    <div class="row">
                                        <ul class="ml-4 mb-0 mt-3 fa-ul text-muted">
                                            <li class="small pb-2"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> <?= $t->alamat_lengkap ?></li>
                                            <li class="small pb-2"><span class="fa-li"><i class="fas fa-envelope"></i></span> Kode Pos : <?= $t->kode_pos ?></li>
                                            <li class="small pb-2"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> <?= $t->telepon ?></li>
                                            <li class="small pb-2"><span class="fa-li"><i class="fas fa-box-open"></i></span> <?= $t->ekspedisi . " - Ongkos Kirim : Rp. " . number_format($t->biaya_ongkir, 2) ?></li>
                                            <li class="small pb-2"><span class="fa-li"><i class="fas fa-credit-card"></i></span> <?= $t->bank . " - " . $t->no_rekening ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php if ($t->status == "BELUM_LUNAS") { ?>
                        <div class="card-footer">
                            <button type="button" title="Batal Pembayaran" onclick="batal_pemesanan('<?= $t->id ?>')" class="btn btn-sm btn-danger"><i class="fas fa-times"></i> BATALKAN PEMESANAN</button>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </section>
</div>
<script>
    function batal_pemesanan(id) {
        swal.fire({
            title: 'Batal pembayaran #' + id + '?',
            text: "Pesanan yang sudah dibatalkan akan masuk ke list barang dibatalkan",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonText: 'Tutup',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('transaksi/tagihan/batal_pemesanan') ?>",
                    data: {
                        "id": id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.response_code == 200) {
                            Swal.fire(
                                'Berhasil',
                                data.response_message,
                                'success'
                            ).then((result) => {
                                location.reload()
                            })
                        } else {
                            Swal.close();
                            Swal.fire("Oops", data.response_message, "error");
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        Swal.fire("Oops", xhr.responseText, "error");
                    }
                })
            }
        });
    }
</script>