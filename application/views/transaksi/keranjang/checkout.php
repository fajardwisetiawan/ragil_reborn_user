<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark"><b>Checkout</b></h1>
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
            <div class="card">
                <form method="POST" action="<?= base_url("transaksi/keranjang/save_checkout") ?>" id="form_add" enctype='multipart/form-data'>
                    <div class="card-body">
                        <div class="bg-gray py-2 px-3 mt-4 mb-4">
                            <?php
                            $total = 0;
                            foreach ($keranjang as $k) {
                                $total += $k->harga * $k->jumlah;
                            }
                            ?>
                            <h2 class="mb-0">
                                Rp. <?= number_format($total, 2) ?>
                            </h2>
                            <h4 class="mt-0">
                                <small>Belum termasuk ongkos kirim</small>
                            </h4>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="recipient-name" class="control-label">Nama <span class="text-danger">*</span></label>
                                    <input value="<?= $user ? $user->nama : "" ?>" type="text" class="form-control" name="nama" id="nama" placeholder="Nama" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="recipient-name" class="control-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="alamat_lengkap" id="alamat_lengkap" placeholder="Alamat Lengkap" cols="3" rows="3" required><?= $user ? $user->alamat_lengkap : "" ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="recipient-name" class="control-label">Kode Pos <span class="text-danger">*</span></label>
                                    <input value="<?= $user ? $user->kode_pos : "" ?>" type="text" class="form-control" name="kode_pos" id="kode_pos" placeholder="Kode Pos" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="recipient-name" class="control-label">Telepon <span class="text-danger">*</span></label>
                                    <input value="<?= $user ? $user->telepon : "" ?>" type="text" class="form-control" name="telepon" id="telepon" placeholder="Telepon" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="recipient-name" class="control-label">Email <span class="text-danger">*</span></label>
                                    <input value="<?= $user ? $user->email : "" ?>" type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="recipient-name" class="control-label">Ekspedisi <span class="text-danger">*</span></label>
                                    <select class="form-control select2bs4" name="ekspedisi" id="ekspedisi" required>
                                        <option value="" selected disabled>-- PILIH JASA EKSPEDISI --</option>
                                        <?php foreach ($ekspedisi as $e) { ?>
                                            <option value="<?= $e->id ?>"><?= $e->nama . " - Ongkos Kirim : Rp. " . $e->biaya_ongkir ?></option>
                                        <?php } ?>
                                    </select>
                                    <input value="<?= $total ?>" type="hidden" class="form-control number-format" name="total" id="total" placeholder="Total" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="recipient-name" class="control-label">Bank <span class="text-danger">*</span></label>
                                    <select class="form-control select2bs4" name="bank" id="bank" required>
                                        <option value="" selected disabled>-- PILIH BANK --</option>
                                        <?php foreach ($bank as $b) { ?>
                                            <option value="<?= $b->id ?>"><?= $b->nama . " - " . $b->no_rekening ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success ml-1" style="width: 100%;">
                            <i class="fas fa-save"></i> SIMPAN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        $('#table_data').DataTable({
            lengthChange: false,
            searching: true,
            paging: true,
            info: false
        });
    });

    $("#form_add").submit(e => {
        e.preventDefault()
        let _form = $("#form_add")
        let _url = _form.attr('action')
        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: _url,
            data: _form.serialize(),
            success: function(result) {
                // alert(JSON.stringify(result))
                if (result.response_code == 200) {
                    Swal.fire({
                            icon: 'success',
                            title: 'Yeay !',
                            text: `${result.response_message}`,
                            confirmButtonText: 'Okesiap !',
                        })
                        .then((result) => {
                            window.location.href = "<?= base_url("transaksi/tagihan") ?>";
                        })

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopss..',
                        text: `${result.response_message}`,
                        confirmButtonText: 'Okesiap !',
                    })
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                Swal.fire("Oops", xhr.responseText, "error")
            }
        });
    })

    function hapus(id) {
        swal.fire({
            title: 'Hapus keranjang?',
            text: "Data akan terhapus secara permanent",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('transaksi/keranjang/delete') ?>",
                    data: {
                        "id": id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.response_code == 200) {
                            Swal.fire(
                                'Terhapus',
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

    $("#checkout_kosong").click(function() {
        Swal.fire(
            "Oops",
            "Keranjang anda masih kosong, silakan pilih barang-barang menarik kami terlebih dahulu",
            "error"
        );
    });
</script>