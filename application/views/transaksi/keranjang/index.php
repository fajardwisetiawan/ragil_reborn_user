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

        <div class="container-fluid">
            <div class="card">
                <div class="card-body table-responsive">
                    <table id="table_data" class="table nowrap table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 3%">No.</th>
                                <th style="width: 8%">Aksi</th>
                                <th>Produk</th>
                                <th>Jenis Barang</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                $total = 0;
                                foreach ($keranjang as $k) {
                                $a = $k->harga * $k->jumlah;
                                $total += $a;
                            ?>
                                <tr>
                                    <td><?= $no++ ?>.</td>
                                    <td>
                                        <?php if ($k->jenis_barang == "READY") {  ?>
                                            <a href="<?= base_url('transaksi/keranjang/edit_ready/') . $k->id . "/" . $k->id_produk ?>" class="btn btn-sm btn-info waves-effect waves-light" title="Edit"><i class="fas fa-edit"></i></a>
                                        <?php } else { ?>
                                            <a href="<?= base_url('transaksi/keranjang/edit_preorder/') . $k->id . "/" . $k->id_produk ?>" class="btn btn-sm btn-info waves-effect waves-light" title="Edit"><i class="fas fa-edit"></i></a>
                                        <?php } ?>
                                        <button type="button" title="Hapus" onclick="hapus('<?= $k->id ?>')" class="btn btn-sm btn-danger waves-effect waves-light" type="button"><span class="btn-label text-white"><i class="fas fa-trash"></i></span></button>
                                    </td>
                                    <td><?= $k->nama_produk ?></td>
                                    <td><?= $k->jenis_barang ?></td>
                                    <td><?= $k->jumlah ?></td>
                                    <td><?= number_format($k->harga,2) ?></td>
                                    <td><?= number_format($k->harga * $k->jumlah,2) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6" class="text-center">Total</th>
                                <th><?= number_format($total,2) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        $('#table_data').DataTable({lengthChange: false, searching: true, paging: true, info: false});
    });

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
</script>