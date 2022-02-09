<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table id="datatable_dikirim" class="table table-sm table-bordered datatable text-center">
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
                    foreach ($dikirim as $d) {
                    ?>
                        <tr>
                            <td><?= $no++ ?>.</td>
                            <td><?= $d->nama_produk ?></td>
                            <td>Rp. <?= number_format($d->harga, 2) ?></td>
                            <td><?= $d->ukuran ? $d->ukuran : "---" ?></td>
                            <td><?= $d->jumlah ?></td>
                            <td><?= $d->catatan ?></td>
                            <td><?= $d->created_at ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#datatable_dikirim').DataTable({lengthChange: false, searching: true, paging: true, info: false});
    });

    function batal_pembayaran(id, nama_produk) {
        swal.fire({
            title: 'Batal pembayaran ' + nama_produk,
            text: "Pesanan yang sudah dibatalkan akan masuk ke list barang dibatalkan",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Verifkasi'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('transaksi/belum_bayar/batal_pembayaran') ?>",
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