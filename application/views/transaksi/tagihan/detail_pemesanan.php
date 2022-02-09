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
                    <table id="table_data" class="table nowrap table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 3%">No.</th>
                                <th>Produk</th>
                                <th>Ukuran</th>
                                <th>Catatan</th>
                                <th>Jenis Pemesanan</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                $total = 0;
                                foreach ($pemesanan as $p) {
                                $a = $p->harga * $p->jumlah;
                                $total += $a;
                            ?>
                                <tr>
                                    <td><?= $no++ ?>.</td>
                                    <td><?= $p->nama_produk ?></td>
                                    <td><?= $p->ukuran ? $p->ukuran : "---" ?></td>
                                    <td><?= $p->catatan ?></td>
                                    <td><?= $p->jenis_pemesanan ?></td>
                                    <td><?= $p->jumlah ?></td>
                                    <td><?= number_format($p->harga,2) ?></td>
                                    <td><?= number_format($p->harga * $p->jumlah,2) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="7" class="text-center">Total</th>
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
</script>