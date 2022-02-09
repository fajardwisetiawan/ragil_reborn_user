<div class="content-wrapper">
    <section class="content">
        <div class="card card-solid m-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-inline-block d-sm-none"><?= $detail->nama  ?></h3>
                        <div class="col-12">
                            <img src="<?= 'http://localhost/ragil_reborn_admin/images/' . $detail->gambar ?>" class="product-image" alt="Product Image">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <h3 class="my-3"><?= $detail->nama  ?></h3>
                        <p><?= $detail->deskripsi ?></p>

                        <hr>

                        <div class="bg-gray py-2 px-3 mt-4">
                            <h2 class="mb-0">
                                Rp. <?= number_format($detail->harga, 2) ?>
                            </h2>
                            <h4 class="mt-0">
                                <small>Belum termasuk ongkos kirim</small>
                            </h4>
                        </div>

                        <div class="mt-4">
                            <input type="hidden" class="form-control" name="id_produk" id="id_produk" placeholder="ID Produk" value="<?= $this->uri->segment(4) ?>">
                            <input type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah yang akan anda beli" required>
                        </div>
                        
                        <div class="mt-4">
                            <textarea class="form-control" name="catatan" id="catatan" cols="3" rows="3"  placeholder="Catatan" required></textarea>
                        </div>

                        <div class="mt-4">
                            <div class="btn btn-primary btn-lg btn-flat" id="btnTambahKeranjang">
                                <i class="fas fa-cart-plus fa-lg mr-2"></i>
                                Tambah ke Keranjang
                            </div>

                            <a href="<?= base_url('transaksi/keranjang') ?>" class="btn btn-success btn-lg btn-flat" title="Lihat Keranjang">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Lihat Keranjang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $("#btnTambahKeranjang").click(function() {
        var id_produk   = $("#id_produk").val()
        var jumlah      = parseInt($("#jumlah").val())
        var catatan     = $("#catatan").val()

        if(isNaN(jumlah)) {
            Swal.fire({
                icon: 'error',
                title: 'Oopss..',
                text: `Isi terlebih dahulu kolom jumlah`,
                confirmButtonText: 'Oke!',
            })
        } else {
            $.ajax({
                type: "POST",
                url: "<?= base_url('transaksi/detail/add_keranjang_preorder') ?>",
                data: {
                    "id_produk": id_produk,
                    "jumlah": jumlah,
                    "catatan": catatan,
                },
                dataType: "json",
                success: function(data) {
                    if (data.response_code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.response_message,
                            confirmButtonText: 'Oke!',
                        })
                        .then((result) => {
                            window.location.href = "<?= base_url("transaksi/keranjang") ?>";
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
</script>