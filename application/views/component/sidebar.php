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
        <img src="<?= base_url("assets/dist/img/logo.png") ?>" alt="User Image" class="centerr" width="100">
        <p class="text-center" style="font-size: 0.75em; padding: 0; margin: 0;"><?= $this->session->userdata('username') ?></b>
        <p class="text-center" style="font-size: 0.75em; padding: 0; margin: 0;"><?= $this->session->userdata('nama') ?></b>
        <p class="text-center" style="font-size: 0.75em; padding: 0; margin: 0;"><?= $this->session->userdata('email') ?></b>
        <p class="text-center" style="font-size: 0.75em; padding: 0; margin: 0;"><?= $this->session->userdata('telepon') ?></b>
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
                        <p>
                            Keranjang
                        </p>
                    </a>
                </li>

                <li class="nav-header">Kategori Produk</li>
                <li class="nav-item">
                    <a href="<?= base_url('master/user') ?>" class="nav-link">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>
                            User
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>