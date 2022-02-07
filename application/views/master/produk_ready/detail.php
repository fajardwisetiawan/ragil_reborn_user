<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark"><b>Detail <?= $title ?></b> | <?= $app_name ?></h1>
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
                <div class="card-header">
                    <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#modal_tambah"><i class="fas fa-plus"></i> Tambah Detail <?= $title ?></button>
                </div>
                <div class="modal fade myModal" id="modal_tambah">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Form Tambah Detail <?= $title ?></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="<?= base_url("master/produk_ready/add_detail") ?>" id="form_add" enctype='multipart/form-data'>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="recipient-name" class="control-label">Ukuran <span class="text-danger">*</span></label>
                                                <input value="<?= $this->uri->segment(4) ?>" type="hidden" class="form-control" name="id_produk" id="id_produk" placeholder="ID Produk" required>
                                                <select class="form-control select2bs4" name="ukuran" id="ukuran" required>
                                                    <option value="" selected disabled>-- PILIH UKURAN --</option>
                                                    <?php foreach ($ukuran as $u) { ?>
                                                        <option value="<?= $u->id ?>"><?= $u->ukuran ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="recipient-name" class="control-label">Stok <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="stok" id="stok" placeholder="Stok" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary add-btn">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="table_data" class="table nowrap table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 3%">No.</th>
                                <th style="width: 8%">Aksi</th>
                                <th>Ukuran</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($produk as $p) { ?>
                                <tr>
                                    <td><?= $no++ ?>.</td>
                                    <td>
                                        <button type="button" title="Edit" onclick="modal_edit('<?= $p->id ?>')" data-toggle="modal" data-target="#modal_ubah" class="btn btn-sm btn-info waves-effect waves-light" type="button"><span class="btn-label text-white"><i class="fas fa-edit"></i></span></button>
                                        <button type="button" title="Hapus" onclick="hapus('<?= $p->id ?>')" class="btn btn-sm btn-danger waves-effect waves-light" type="button"><span class="btn-label text-white"><i class="fas fa-trash"></i></span></button>
                                    </td>
                                    <td><?= $p->ukuran ?></td>
                                    <td><?= $p->stok ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade myModal" id="modal_ubah">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Ubah Detail <?= $title ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="<?= base_url("master/produk_ready/update_detail") ?>" id="form_add" enctype='multipart/form-data'>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="recipient-name" class="control-label">Ukuran <span class="text-danger">*</span></label>
                                <input type="hidden" class="form-control" name="id_edit" id="id_edit" placeholder="ID" required>
                                <input value="<?= $this->uri->segment(4) ?>" type="hidden" class="form-control" name="id_produk_edit" id="id_produk_edit" placeholder="ID Produk" required>
                                <select class="form-control select2bs4" name="ukuran_edit" id="ukuran_edit" required>
                                    <option value="" selected disabled>-- PILIH UKURAN --</option>
                                    <?php foreach ($ukuran as $u) { ?>
                                        <option value="<?= $u->id ?>"><?= $u->ukuran ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="recipient-name" class="control-label">Stok <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="stok_edit" id="stok_edit" placeholder="Stok" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary add-btn">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#table_data').DataTable();
    });

    function modal_edit(id) {
        $.ajax({
            url: "<?= base_url('master/produk_ready/getDetailById/') ?>" + id,
            type: "GET",
            dataType: "JSON",
            contentType: "application/json; charset=utf-8",
            success: function(result) {
                $('#id_edit').val(result.id);
                $("#ukuran_edit").val(result.id_ukuran)
                $("#ukuran_edit").trigger('change.select2')
                $("#stok_edit").val(result.stok)
            }
        });
    }

    function hapus(id) {
        swal.fire({
            title: 'Hapus Data ?',
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
                    url: "<?= base_url('master/produk_ready/delete_detail') ?>",
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

    function check_level() {
        var level = $("#level").val()
        if (level == 'DOKTER' || level == 'PERAWAT' || level == 'BIDAN') {
            $("#div_poli").show()
            $("#poli").prop('required', true);
        } else {
            $("#div_poli").hide()
            $("#poli").val("").change();
            $("#poli").prop('required', false);
        }
    }

    function check_level_edit() {
        var level = $("#level_edit").val()
        if (level == 'DOKTER' || level == 'PERAWAT' || level == 'BIDAN') {
            $("#div_poli_edit").show()
            $("#poli_edit").prop('required', true);
        } else {
            $("#div_poli_edit").hide()
            $("#poli_edit").val("").change();
            $("#poli_edit").prop('required', false);
        }
    }
</script>
<script>   
    window.addEventListener('load', function() {

        // $(".admin_select2").select2({
        //     dropdownParent: $("#modal_tambah"),
        //     closeOnSelect: true,
        //     theme: 'bootstrap4',
        //     ajax: {
        //         url: '<?= base_url('master/admin/searchAdmin') ?>',
        //         type: "post",
        //         dataType: 'json',
        //         delay: 250,
        //         data: function(params) {
        //             return {
        //                 searchTerm: params.term
        //             };
        //         },
        //         processResults: function(response) {
        //             console.log(response)
        //             return {
        //                 results: response
        //             };
        //         },
        //         cache: true,
        //     },
        // })

        // $(".admin_select2_edit").select2({
        //     dropdownParent: $("#modal_ubah"),
        //     closeOnSelect: true,
        //     theme: 'bootstrap4',
        //     ajax: {
        //         url: '<?= base_url('master/admin/searchAdmin') ?>',
        //         type: "post",
        //         dataType: 'json',
        //         delay: 250,
        //         data: function(params) {
        //             return {
        //                 searchTerm: params.term
        //             };
        //         },
        //         processResults: function(response) {
        //             console.log(response)
        //             return {
        //                 results: response
        //             };
        //         },
        //         cache: true,
        //     },
        // })

        $('#level').on('change', function() {
            $(".poli").select2({
                ajax: {
                    url: '<?= base_url('master/admin/searchPoli/') ?>' + this.value,
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            searchTerm: params.term
                        };
                    },
                    processResults: function(response) {

                        return {
                            results: response
                        };
                    },
                    cache: true,
                },
                'theme': 'bootstrap4'
            });
        });

        $('#level_edit').on('change', function() {
            $(".poli_edit").select2({
                ajax: {
                    url: '<?= base_url('master/admin/searchPoli/') ?>' + this.value,
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            searchTerm: params.term
                        };
                    },
                    processResults: function(response) {

                        return {
                            results: response
                        };
                    },
                    cache: true,
                },
                'theme': 'bootstrap4'
            });
        });

    });
</script>
<script>
    $(document).ready(function() {
        $("#provinsi").change(function() {
            var kec = $(this).find(":selected").text();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url("Welcome/getKabupatenByIdProvinsi"); ?>",
                data: {
                    id_prov: $("#provinsi").val()
                },
                dataType: "json",
                beforeSend: function(e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function(response) {
                    $("#kabupaten").html(response.list_kabupaten).show();
                    $("#kabupaten").change(function() {
                        var kabupaten = $(this).find(":selected").text();
                    });
                    $("#kecamatan").html('<option value="">--- Pilih Kabupaten Terlebih Dahulu</option> ---').show();
                    $("#kelurahan").html('<option value="">--- Pilih Kecamatan Terlebih Dahulu</option> ---').show();
                },
                error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
                }
            });
        });

        $("#kabupaten").change(function() {
            var kec = $(this).find(":selected").text();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url("Welcome/getKecamatanByIdKabupaten"); ?>",
                data: {
                    id_kab: $("#kabupaten").val()
                },
                dataType: "json",
                beforeSend: function(e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function(response) {
                    $("#kecamatan").html(response.list_kecamatan).show();
                    $("#kecamatan").change(function() {
                        var kecamatan = $(this).find(":selected").text();
                    });
                    $("#kelurahan").html('<option value="">--- Pilih Kecamatan Terlebih Dahulu</option> ---').show();
                },
                error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
                }
            });
        });

        $("#kecamatan").change(function() {
            var kec = $(this).find(":selected").text();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url("Welcome/getKelurahanByIdKecamatan"); ?>",
                data: {
                    kecamatan_id: $("#kecamatan").val()
                },
                dataType: "json",
                beforeSend: function(e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function(response) {
                    $("#kelurahan").html(response.list_kelurahan).show();
                    $("#kelurahan").change(function() {
                        var kelurahan = $(this).find(":selected").text();
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
                }
            });
        });

        $("#provinsi_edit").change(function() {
            var kec = $(this).find(":selected").text();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url("Welcome/getKabupatenByIdProvinsi"); ?>",
                data: {
                    id_prov: $("#provinsi_edit").val()
                },
                dataType: "json",
                beforeSend: function(e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function(response) {
                    $("#kabupaten_edit").html(response.list_kabupaten).show();
                    $("#kabupaten_edit").change(function() {
                        var kabupaten = $(this).find(":selected").text();
                    });
                    $("#kecamatan_edit").html('<option value="">--- Pilih Kabupaten Terlebih Dahulu</option> ---').show();
                    $("#kelurahan_edit").html('<option value="">--- Pilih Kecamatan Terlebih Dahulu</option> ---').show();
                },
                error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
                }
            });
        });

        $("#kabupaten_edit").change(function() {
            var kec = $(this).find(":selected").text();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url("Welcome/getKecamatanByIdKabupaten"); ?>",
                data: {
                    id_kab: $("#kabupaten_edit").val()
                },
                dataType: "json",
                beforeSend: function(e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function(response) {
                    $("#kecamatan_edit").html(response.list_kecamatan).show();
                    $("#kecamatan_edit").change(function() {
                        var kecamatan = $(this).find(":selected").text();
                    });
                    $("#kelurahan_edit").html('<option value="">--- Pilih Kecamatan Terlebih Dahulu</option> ---').show();
                },
                error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
                }
            });
        });

        $("#kecamatan_edit").change(function() {
            var kec = $(this).find(":selected").text();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url("Welcome/getKelurahanByIdKecamatan"); ?>",
                data: {
                    kecamatan_id: $("#kecamatan_edit").val()
                },
                dataType: "json",
                beforeSend: function(e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function(response) {
                    $("#kelurahan_edit").html(response.list_kelurahan).show();
                    $("#kelurahan_edit").change(function() {
                        var kelurahan = $(this).find(":selected").text();
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
                }
            });
        });
    });
</script>