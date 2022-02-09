<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keranjang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') == '' || $this->session->userdata('status') == null) {
            redirect("auth");
        }

        $this->load->model("keranjang_model");
    }

    public function index()
    {
        $data = [
            "app_name"  => "TOKO RAGIL 2 REBORN",
            "title"     => ucwords(str_replace("_", " ", $this->router->fetch_class())),
            "keranjang" => $this->keranjang_model->getAll(),
        ];

        // die(json_encode($data['ukuran']));
        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("transaksi/keranjang/index", $data);
        $this->load->view("component/footer", $data);
    }

    public function getStok()
    {
        $id     = $this->input->post("id", TRUE);
        $cek    = $this->db
            ->get_where("m_stok", ["id" => $id])
            ->row();
        if ($cek) {
            echo json_encode([
                'response_code'     => 200,
                'response_message'  => 'Stok ditemukan',
                'response_data'     => $cek
            ]);
        } else {
            echo json_encode([
                'response_code'     => 400,
                'response_message'  => 'Stok tidak ditemukan',
                'response_data'     => null
            ]);
        }
    }

    public function edit_ready($id = null, $id_produk = null)
    {
        $data = [
            "app_name"  => "TOKO RAGIL 2 REBORN",
            "title"     => ucwords(str_replace("_", " ", $this->router->fetch_class())),
            "detail"    => $this->keranjang_model->getDetail($id),
            "ukuran"    => $this->keranjang_model->getUkuran($id_produk),
        ];

        // die(json_encode($data['ukuran']));
        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("transaksi/keranjang/edit_ready", $data);
        $this->load->view("component/footer", $data);
    }

    public function save_keranjang_ready()
    {
        $id         = $this->input->post("id");
        $id_user    = $this->session->userdata('id');
        $id_produk  = $this->input->post("id_produk");
        $id_stok    = $this->input->post("id_stok");
        $jumlah     = $this->input->post("jumlah");
        $catatan    = $this->input->post("catatan");

        $cekById = $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get_where("tr_keranjang", ["id" => $id, "status" => "BELUM"])
            ->row();
        if ($cekById->id_produk == $id_produk || $cekById->id_stok == $id_stok) {
            $dataUpdate = [
                "id_produk"     => $id_produk,
                "id_stok"       => $id_stok,
                "jumlah"        => $jumlah,
                "catatan"       => $catatan,
                "status"        => "BELUM",
                "updated_at"    => date("Y-m-d H:i:s"),
                "updated_by"    => $this->session->userdata('id'),
            ];

            $update = $this->db->update("tr_keranjang", $dataUpdate, ["id" => $id]);
            if ($update) {
                echo json_encode([
                    'response_code'     => 200,
                    'response_message'  => 'Berhasil mengubah produk ke keranjang'
                ]);
            } else {
                echo json_encode([
                    'response_code'     => 400,
                    'response_message'  => 'Terjadi kesalahan saat mengubah produk ke keranjang'
                ]);
            }
        } else {
            $cekByIdProdukIdStok = $this->db
                ->where('deleted_at IS NULL', null, false)
                ->get_where("tr_keranjang", ["id_user" => $id_user, "id_produk" => $id_produk, "id_stok" => $id_stok, "status" => "BELUM"])
                ->row();
            if (!$cekByIdProdukIdStok) {
                $dataUpdate = [
                    "id_produk"     => $id_produk,
                    "id_stok"       => $id_stok,
                    "jumlah"        => $jumlah,
                    "catatan"       => $catatan,
                    "status"        => "BELUM",
                    "updated_at"    => date("Y-m-d H:i:s"),
                    "updated_by"    => $this->session->userdata('id'),
                ];

                $update = $this->db->update("tr_keranjang", $dataUpdate, ["id" => $id]);
                if ($update) {
                    echo json_encode([
                        'response_code'     => 200,
                        'response_message'  => 'Berhasil mengubah produk ke keranjang'
                    ]);
                } else {
                    echo json_encode([
                        'response_code'     => 400,
                        'response_message'  => 'Terjadi kesalahan saat mengubah produk ke keranjang'
                    ]);
                }
            } else {
                echo json_encode([
                    'response_code'     => 400,
                    'response_message'  => 'Maaf, produk sudah terdaftar dikeranjang'
                ]);
            }
        }
    }

    public function edit_preorder($id = null)
    {
        $data = [
            "app_name"  => "TOKO RAGIL 2 REBORN",
            "title"     => ucwords(str_replace("_", " ", $this->router->fetch_class())),
            "detail"    => $this->keranjang_model->getDetail($id),
        ];

        // die(json_encode($data['ukuran']));
        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("transaksi/keranjang/edit_preorder", $data);
        $this->load->view("component/footer", $data);
    }

    public function save_keranjang_preorder()
    {
        $id         = $this->input->post("id");
        $id_user    = $this->session->userdata('id');
        $id_produk  = $this->input->post("id_produk");
        $jumlah     = $this->input->post("jumlah");
        $catatan    = $this->input->post("catatan");

        $cekById = $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get_where("tr_keranjang", ["id" => $id, "status" => "BELUM"])
            ->row();
        if ($cekById->id_produk == $id_produk) {
            $dataUpdate = [
                "id_produk"     => $id_produk,
                "jumlah"        => $jumlah,
                "catatan"       => $catatan,
                "status"        => "BELUM",
                "updated_at"    => date("Y-m-d H:i:s"),
                "updated_by"    => $this->session->userdata('id'),
            ];

            $update = $this->db->update("tr_keranjang", $dataUpdate, ["id" => $id]);
            if ($update) {
                echo json_encode([
                    'response_code'     => 200,
                    'response_message'  => 'Berhasil mengubah produk ke keranjang'
                ]);
            } else {
                echo json_encode([
                    'response_code'     => 400,
                    'response_message'  => 'Terjadi kesalahan saat mengubah produk ke keranjang'
                ]);
            }
        } else {
            $cekByIdProdukIdStok = $this->db
                ->where('deleted_at IS NULL', null, false)
                ->get_where("tr_keranjang", ["id_user" => $id_user, "id_produk" => $id_produk, "status" => "BELUM"])
                ->row();
            if (!$cekByIdProdukIdStok) {
                $dataUpdate = [
                    "id_produk"     => $id_produk,
                    "jumlah"        => $jumlah,
                    "catatan"       => $catatan,
                    "status"        => "BELUM",
                    "updated_at"    => date("Y-m-d H:i:s"),
                    "updated_by"    => $this->session->userdata('id'),
                ];

                $update = $this->db->update("tr_keranjang", $dataUpdate, ["id" => $id]);
                if ($update) {
                    echo json_encode([
                        'response_code'     => 200,
                        'response_message'  => 'Berhasil mengubah produk ke keranjang'
                    ]);
                } else {
                    echo json_encode([
                        'response_code'     => 400,
                        'response_message'  => 'Terjadi kesalahan saat mengubah produk ke keranjang'
                    ]);
                }
            } else {
                echo json_encode([
                    'response_code'     => 400,
                    'response_message'  => 'Maaf, produk sudah terdaftar dikeranjang'
                ]);
            }
        }
    }

    public function delete()
    {
        $id     = $this->input->post("id", TRUE);
        $cek    = $this->db
            ->get_where("tr_keranjang", ["id" => $id])
            ->row();
        if ($cek) {
            $dataDelete = [
                "deleted_at"    => date("Y-m-d H:i:s"),
                "deleted_by"    => $this->session->userdata('id'),
            ];
            $delete = $this->db->update("tr_keranjang", $dataDelete, ["id" => $id]);
            if ($delete) {
                echo json_encode([
                    'response_code'     => 200,
                    'response_message'  => 'Keranjang berhasil dihapus',
                ]);
            } else {
                echo json_encode([
                    'response_code'     => 400,
                    'response_message'  => 'Keranjang gagal dihapus',
                ]);
            }
        } else {
            echo json_encode([
                'response_code'     => 400,
                'response_message'  => 'Keranjang tidak ditemukan',
            ]);
        }
    }

    public function checkout()
    {
        $data = [
            "app_name"  => "TOKO RAGIL 2 REBORN",
            "title"     => ucwords(str_replace("_", " ", $this->router->fetch_class())),
            "keranjang" => $this->keranjang_model->getKeranjang(),
            "user"      => $this->keranjang_model->getUser(),
            "ekspedisi" => $this->keranjang_model->getEkspedisi(),
            "bank"      => $this->keranjang_model->getBank(),
        ];

        // die(json_encode($data['keranjang']));
        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("transaksi/keranjang/checkout", $data);
        $this->load->view("component/footer", $data);
    }

    public function save_checkout()
    {
        $id_user        = $this->session->userdata('id');
        $nama           = $this->input->post("nama", TRUE);
        $alamat_lengkap = $this->input->post("alamat_lengkap", TRUE);
        $kode_pos       = $this->input->post("kode_pos", TRUE);
        $telepon        = $this->input->post("telepon", TRUE);
        $email          = $this->input->post("email", TRUE);
        $id_ekspedisi   = $this->input->post("ekspedisi", TRUE);
        $total          = $this->input->post("total", TRUE);
        $id_bank        = $this->input->post("bank", TRUE);

        $getEkspedisi = $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get_where("m_ekspedisi", ["id" => $id_ekspedisi])
            ->row();
        if ($getEkspedisi) {
            $getBank = $this->db
                ->where('deleted_at IS NULL', null, false)
                ->get_where("m_bank", ["id" => $id_bank])
                ->row();
            if ($getBank) {

                $dataInsertTagihan = [
                    "id_user"           => $id_user,
                    "nama"              => $nama,
                    "alamat_lengkap"    => $alamat_lengkap,
                    "kode_pos"          => $kode_pos,
                    "telepon"           => $telepon,
                    "email"             => $email,
                    "ekspedisi"         => $getEkspedisi->nama,
                    "biaya_ongkir"      => $getEkspedisi->biaya_ongkir,
                    "bank"              => $getBank->nama,
                    "no_rekening"       => $getBank->no_rekening,
                    "total"             => $total + $getEkspedisi->biaya_ongkir,
                    "status"            => "BELUM_LUNAS",
                    "created_at"        => date("Y-m-d H:i:s"),
                    "created_by"        => $this->session->userdata('id'),
                ];

                $insertTagihan  = $this->db->insert('tr_tagihan', $dataInsertTagihan);
                $lastId         = $this->db->insert_id();
                if ($insertTagihan) {
                    $getKeranjang = $this->db
                        ->where('deleted_at IS NULL', null, false)
                        ->get_where("tr_keranjang", ["id_user" => $id_user, "status" => "BELUM"])
                        ->result();

                    if ($getKeranjang) {
                        foreach ($getKeranjang as $k) {
                            $getProduk = $this->db
                                ->where('deleted_at IS NULL', null, false)
                                ->get_where("m_produk", ["id" => $k->id_produk])
                                ->row();

                            $ukuran = null;
                            if ($k->jenis_barang == "READY") {
                                $getStok = $this->db
                                    ->where('deleted_at IS NULL', null, false)
                                    ->get_where("m_stok", ["id" => $k->id_stok])
                                    ->row();

                                $getUkuran = $this->db
                                    ->where('deleted_at IS NULL', null, false)
                                    ->get_where("m_ukuran", ["id" => $getStok->id_ukuran])
                                    ->row();

                                $ukuran = $getUkuran->ukuran;
                            }

                            $dataInsertPemesanan = [
                                "id_tagihan"        => $lastId,
                                "id_user"           => $id_user,
                                "id_produk"         => $k->id_produk,
                                "harga"             => $getProduk->harga,
                                "id_stok"           => $k->id_stok,
                                "ukuran"            => $ukuran,
                                "jumlah"            => $k->jumlah,
                                "catatan"           => $k->catatan,
                                "jenis_pemesanan"   => $k->jenis_barang,
                                "status_pemesanan"  => "BELUM_BAYAR",
                                "created_at"        => date("Y-m-d H:i:s"),
                                "created_by"        => $this->session->userdata('id'),
                            ];

                            $this->db->insert('tr_pemesanan', $dataInsertPemesanan);
                        }

                        $dataUpdateKeranjang = [
                            "status"        => "PROSES",
                            "updated_at"    => date("Y-m-d H:i:s"),
                            "updated_by"    => $this->session->userdata('id'),
                        ];
                        $updateKeranjang = $this->db->update("tr_keranjang", $dataUpdateKeranjang, ["id_user" => $id_user, "status"  => "BELUM"]);
                        if ($updateKeranjang) {
                            echo json_encode([
                                'response_code'     => 200,
                                'response_message'  => 'Berhasil melakukan checkout, silakan lunasi tagihan terlebih dahulu agar barangmu segera dikirim',
                            ]);
                        } else {
                            echo json_encode([
                                'response_code'     => 400,
                                'response_message'  => 'Terjadi kesalahan saat mengubah status keranjang!',
                            ]);
                        }
                    } else {
                        echo json_encode([
                            'response_code'     => 400,
                            'response_message'  => 'Keranjang tidak ditemukan',
                        ]);
                    }
                } else {
                    echo json_encode([
                        'response_code'     => 400,
                        'response_message'  => 'Terjadi kesalahan saat menambahkan tagihan!',
                    ]);
                }
            } else {
                echo json_encode([
                    'response_code'     => 400,
                    'response_message'  => 'Bank tidak ditemukan',
                ]);
            }
        } else {
            echo json_encode([
                'response_code'     => 400,
                'response_message'  => 'Ekspedisi tidak ditemukan',
            ]);
        }
    }
}
