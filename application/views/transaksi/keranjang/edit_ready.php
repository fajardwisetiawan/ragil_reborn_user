<div class="content-wrapper">
    <section class="content">
        <div class="card card-solid m-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-inline-block d-sm-none"><?= $detail->nama_produk  ?></h3>
                        <div class="col-12">
                            <img src="<?= 'http://localhost/ragil_reborn_admin/images/' . $detail->gambar ?>" class="product-image" alt="Product Image">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <h3 class="my-3"><?= $detail->nama_produk  ?></h3>
                        <p><?= $detail->deskripsi ?></p>

                        <hr>

                        <h4 class="mt-3">Ukuran <small>Silakan pilih salah satu</small></h4>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <?php 
                                $name   = 1;
                                $id     = 1;
                                foreach ($ukuran as $u) { 
                            ?>
                                <label class="btn btn-default text-center">
                                    <input type="radio" name="ukuran_<?= $name++ ?>" id="ukuran_<?= $id++ ?>" onclick="pilih_ukuran('<?= $u->id ?>')" autocomplete="off">
                                    <span class="text-xl"><?= $u->ukuran ?></span>
                                </label>
                            <?php } ?>
                        </div>

                        <?php if ($detail->id_stok != null || $detail->id_stok != '') { ?>
                            <div class="bg-yellow py-2 px-3 mt-4" id="div_stok_h" style="display: block;">
                                <h4 class="mt-0">
                                    <small>Stok</small>
                                </h4>
                                <h2 class="mb-0" id="stok_h"><?= $detail->stok  ?></h2>
                            </div>
                        <?php } else { ?>
                            <div class="bg-yellow py-2 px-3 mt-4" id="div_stok_h" style="display: none;">
                                <h4 class="mt-0">
                                    <small>Stok</small>
                                </h4>
                                <h2 class="mb-0" id="stok_h"></h2>
                            </div>
                        <?php } ?>

                        <div class="bg-gray py-2 px-3 mt-4">
                            <h2 class="mb-0">
                                Rp. <?= number_format($detail->harga, 2) ?>
                            </h2>
                            <h4 class="mt-0">
                                <small>Belum termasuk ongkos kirim</small>
                            </h4>
                        </div>

                        <div class="mt-4">
                            <input value="<?= $detail->id  ?>" type="hidden" class="form-control" name="id" id="id" placeholder="ID">
                            <input type="hidden" class="form-control" name="id_produk" id="id_produk" placeholder="ID Produk" value="<?= $this->uri->segment(5) ?>">
                            <input value="<?= $detail->id_stok  ?>" type="hidden" class="form-control" name="id_stok" id="id_stok" placeholder="ID Stok">
                            <input value="<?= $detail->stok  ?>" type="hidden" class="form-control" name="stok" id="stok" placeholder="Stok">
                            <input value="<?= $detail->jumlah  ?>" type="number" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah yang akan anda beli" required>
                        </div>
                        
                        <div class="mt-4">
                            <textarea class="form-control" name="catatan" id="catatan" cols="3" rows="3"  placeholder="Catatan" required><?= $detail->catatan  ?></textarea>
                        </div>

                        <div class="mt-4">
                            <div class="btn btn-primary btn-lg btn-flat" id="btnTambahKeranjang">
                                <i class="fas fa-cart-plus fa-lg mr-2"></i>
                                Simpan ke Keranjang
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
    function pilih_ukuran(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('transaksi/keranjang/getStok') ?>",
            data: {
                "id": id
            },
            dataType: "json",
            success: function(data) {
                if (data.response_code == 200) {
                    $("#id_stok").val(data.response_data.id)
                    $("#stok").val(data.response_data.stok)

                    $("#stok_h").text(data.response_data.stok)
                    $("#div_stok_h").css("display", "block");
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

    $("#btnTambahKeranjang").click(function() {
        var id          = $("#id").val()
        var id_produk   = $("#id_produk").val()
        var id_stok     = $("#id_stok").val()
        var stok        = parseInt($("#stok").val())
        var jumlah      = parseInt($("#jumlah").val())
        var catatan     = $("#catatan").val()

        if (id_stok == null || id_stok == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oopss..',
                text: `Pilih terlebih dahulu kolom ukuran`,
                confirmButtonText: 'Oke!',
            })
        } else if(isNaN(jumlah)) {
            Swal.fire({
                icon: 'error',
                title: 'Oopss..',
                text: `Isi terlebih dahulu kolom jumlah`,
                confirmButtonText: 'Oke!',
            })
        } else {
            if (jumlah > stok) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oopss..',
                    text: `Jumlah stok tidak memenuhi permintaan, pastikan stok mencukupi permintaan anda`,
                    confirmButtonText: 'Oke!',
                })
            } else {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('transaksi/keranjang/save_keranjang_ready') ?>",
                    data: {
                        "id": id,
                        "id_produk": id_produk,
                        "id_stok": id_stok,
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
        }
    });
</script>