<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tagihan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') == '' || $this->session->userdata('status') == null) {
            redirect("auth");
        }

        $this->load->model("tagihan_model");
    }

    public function index()
    {
        $data = [
            "app_name"  => "TOKO RAGIL 2 REBORN",
            "title"     => ucwords(str_replace("_", " ", $this->router->fetch_class())),
            "tagihan"   => $this->tagihan_model->getAll(),
        ];

        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("transaksi/tagihan/index", $data);
        $this->load->view("component/footer", $data);
    }

    public function detail_pemesanan($id_tagihan = null)
    {
        $data = [
            "app_name"  => "TOKO RAGIL 2 REBORN",
            "title"     => ucwords(str_replace("_", " ", $this->router->fetch_class())),
            "pemesanan" => $this->tagihan_model->getPemesanan($id_tagihan),
        ];

        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("transaksi/tagihan/detail_pemesanan", $data);
        $this->load->view("component/footer", $data);
    }

    public function batal_pemesanan()
    {
        $id_user    = $this->session->userdata('id');
        $id         = $this->input->post("id", TRUE);

        $cekTagihan = $this->db
            ->get_where("tr_tagihan", ["id" => $id])
            ->row();
        if ($cekTagihan) {
            $cekPemesanan = $this->db
                ->get_where("tr_pemesanan", ["id_tagihan" => $id])
                ->row();
            if ($cekPemesanan) {
                $cekKeranjang = $this->db
                    ->get_where("tr_keranjang", ["id_user" => $id_user, "status" => "PROSES"])
                    ->row();
                if ($cekKeranjang) {
                    $dataKeranjang = [
                        "status"        => "SUDAH",
                        "updated_at"    => date("Y-m-d H:i:s"),
                        "updated_by"    => $this->session->userdata('id'),
                    ];
                    $updatedKeranjang = $this->db->update("tr_keranjang", $dataKeranjang, ["id_user" => $id_user, "status" => "PROSES"]);
                    if ($updatedKeranjang) {
                        $dataBatalTagihan = [
                            "status"        => "BATAL",
                            "updated_at"    => date("Y-m-d H:i:s"),
                            "updated_by"    => $this->session->userdata('id'),
                        ];
                        $batalTagihan = $this->db->update("tr_tagihan", $dataBatalTagihan, ["id" => $id]);
                        if ($batalTagihan) {
                            $dataBatalPemesanan = [
                                "status_pemesanan"  => "BATAL",
                                "updated_at"        => date("Y-m-d H:i:s"),
                                "updated_by"        => $this->session->userdata('id'),
                            ];
                            $batalPemesanan = $this->db->update("tr_pemesanan", $dataBatalPemesanan, ["id_tagihan" => $id]);
                            if ($batalPemesanan) {
                                echo json_encode([
                                    'response_code'     => 200,
                                    'response_message'  => 'Pemesanan berhasil dibatalkan',
                                ]);
                            } else {
                                echo json_encode([
                                    'response_code'     => 400,
                                    'response_message'  => 'Terjadi kesalahan saat mengubah data pemesanan',
                                ]);
                            }
                        } else {
                            echo json_encode([
                                'response_code'     => 400,
                                'response_message'  => 'Terjadi kesalahan saat mengubah data tagihan',
                            ]);
                        }
                    } else {
                        echo json_encode([
                            'response_code'     => 400,
                            'response_message'  => 'Terjadi kesalahan saat mengubah data keranjang',
                        ]);
                    }
                } else {
                    echo json_encode([
                        'response_code'     => 400,
                        'response_message'  => 'Data keranjang tidak ditemukan',
                    ]);
                }
            } else {
                echo json_encode([
                    'response_code'     => 400,
                    'response_message'  => 'Data pemesanan tidak ditemukan',
                ]);
            }
        } else {
            echo json_encode([
                'response_code'     => 400,
                'response_message'  => 'Data tagihan tidak ditemukan',
            ]);
        }
    }
}
