<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keranjang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') == '' || $this->session->userdata('status') == null) {
            $this->load->view('auth/login');
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
            ->get_where("tr_keranjang", ["id" => $id])
            ->row();
        if ($cekById->id_produk == $id_produk || $cekById->id_stok == $id_stok) {
            $dataUpdate = [
                "id_produk"     => $id_produk,
                "id_stok"       => $id_stok,
                "jumlah"        => $jumlah,
                "catatan"       => $catatan,
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
                ->get_where("tr_keranjang", ["id_user" => $id_user, "id_produk" => $id_produk, "id_stok" => $id_stok])
                ->row();
            if (!$cekByIdProdukIdStok) {
                $dataUpdate = [
                    "id_produk"     => $id_produk,
                    "id_stok"       => $id_stok,
                    "jumlah"        => $jumlah,
                    "catatan"       => $catatan,
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
}
