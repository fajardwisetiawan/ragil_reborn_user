<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') == '' || $this->session->userdata('status') == null) {
            redirect("auth");
        }

        $this->load->model("detail_model");
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

    public function detail_ready($id = null, $jenis = null)
    {
        $data = [
            "app_name"  => "TOKO RAGIL 2 REBORN",
            "title"     => ucwords(str_replace("_", " ", $this->router->fetch_class())),
            "detail"    => $this->detail_model->getDetail($id, $jenis),
            "ukuran"    => $this->detail_model->getUkuran($id),
        ];

        // die(json_encode($data['ukuran']));
        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("transaksi/detail_ready/index", $data);
        $this->load->view("component/footer", $data);
    }

    public function detail_preorder($id = null, $jenis = null)
    {
        $data = [
            "app_name"  => "TOKO RAGIL 2 REBORN",
            "title"     => ucwords(str_replace("_", " ", $this->router->fetch_class())),
            "detail"    => $this->detail_model->getDetail($id, $jenis),
        ];

        // die(json_encode($data));
        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("transaksi/detail_preorder/index", $data);
        $this->load->view("component/footer", $data);
    }

    public function add_keranjang_ready()
    {
        $id_user    = $this->session->userdata('id');
        $id_produk  = $this->input->post("id_produk");
        $id_stok    = $this->input->post("id_stok");
        $jumlah     = $this->input->post("jumlah");
        $catatan    = $this->input->post("catatan");

        $cek = $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get_where("tr_keranjang", ["id_user" => $id_user, "id_produk" => $id_produk, "id_stok" => $id_stok])
            ->row();
        if (!$cek) {
            $dataInsert = [
                "id_user"       => $this->session->userdata('id'),
                "id_produk"     => $id_produk,
                "id_stok"       => $id_stok,
                "jenis_barang"  => "READY",
                "jumlah"        => $jumlah,
                "catatan"       => $catatan,
                "created_at"    => date("Y-m-d H:i:s"),
                "created_by"    => $this->session->userdata('id'),
            ];

            $insert = $this->db->insert('tr_keranjang', $dataInsert);

            if ($insert) {
                echo json_encode([
                    'response_code'     => 200,
                    'response_message'  => 'Berhasil menambahkan produk ke keranjang'
                ]);
            } else {
                echo json_encode([
                    'response_code'     => 400,
                    'response_message'  => 'Terjadi kesalahan saat menambahkan produk ke keranjang'
                ]);
            }
        } else {
            echo json_encode([
                'response_code'     => 400,
                'response_message'  => 'Maaf, produk sudah terdaftar dikeranjang'
            ]);
        }
    }

    public function add_keranjang_preorder()
    {
        $id_user    = $this->session->userdata('id');
        $id_produk  = $this->input->post("id_produk");
        $jumlah     = $this->input->post("jumlah");
        $catatan    = $this->input->post("catatan");

        $cek = $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get_where("tr_keranjang", ["id_user" => $id_user, "id_produk" => $id_produk])
            ->row();
        if (!$cek) {
            $dataInsert = [
                "id_user"       => $this->session->userdata('id'),
                "id_produk"     => $id_produk,
                "jenis_barang"  => "PREORDER",
                "jumlah"        => $jumlah,
                "catatan"       => $catatan,
                "created_at"    => date("Y-m-d H:i:s"),
                "created_by"    => $this->session->userdata('id'),
            ];

            $insert = $this->db->insert('tr_keranjang', $dataInsert);

            if ($insert) {
                echo json_encode([
                    'response_code'     => 200,
                    'response_message'  => 'Berhasil menambahkan produk ke keranjang'
                ]);
            } else {
                echo json_encode([
                    'response_code'     => 400,
                    'response_message'  => 'Terjadi kesalahan saat menambahkan produk ke keranjang'
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
