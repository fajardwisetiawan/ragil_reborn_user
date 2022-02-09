<style>
    .centerr {
        display: block;
        margin-left: auto;
        margin-right: auto;
        margin-top: 20px;
        margin-bottom: 20px;
        width: 50%;
    }
</style>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="brand-link">
        <img src="<?= base_url("assets/dist/img/logo.png") ?>" alt="User Image" class="" width="50">
        <span class="brand-text font-weight-light"> RAGIL DUA REBORN</span>
    </div>

    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Beranda
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('master/kontak') ?>" class="nav-link">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>
                            Kontak
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('transaksi/keranjang') ?>" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <span class="badge badge-danger right">
                            <?php
                                $CI = &get_instance();
                                $CI->load->model('keranjang_model');
                                $result = $CI->keranjang_model->getAll();
                                echo $result != 0 ? count($result) : "0"
                            ?>
                        </span>
                        <p>
                            Keranjang
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('transaksi/tagihan') ?>" class="nav-link">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>
                            Tagihan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('transaksi/pemesanan') ?>" class="nav-link">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p>
                            Pemesanan
                        </p>
                    </a>
                </li>

                <li class="nav-header">Kategori Produk</li>
                <li class="nav-item">
                    <a href="<?= base_url('transaksi/kategori/jaket') ?>" class="nav-link">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            Jaket
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('transaksi/kategori/jersey') ?>" class="nav-link">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            Jersey
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('transaksi/kategori/celana') ?>" class="nav-link">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            Celana
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('transaksi/kategori/lainnya') ?>" class="nav-link">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            Lainnya
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
    </div>
</aside>