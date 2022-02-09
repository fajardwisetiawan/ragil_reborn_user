<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table id="datatable_belum" class="table table-sm table-bordered datatable text-center">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 3%">No.</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Ukuran</th>
                        <th>Jumlah</th>
                        <th>Catatan</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($belum as $b) {
                    ?>
                        <tr>
                            <td><?= $no++ ?>.</td>
                            <td><?= $b->nama_produk ?></td>
                            <td>Rp. <?= number_format($b->harga, 2) ?></td>
                            <td><?= $b->ukuran ? $b->ukuran : "---" ?></td>
                            <td><?= $b->jumlah ?></td>
                            <td><?= $b->catatan ?></td>
                            <td><?= $b->created_at ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#datatable_belum').DataTable({lengthChange: false, searching: true, paging: true, info: false});
    });
</script>