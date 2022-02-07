<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ekspedisi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') == '' || $this->session->userdata('status') == null) {
            $this->load->view('auth/login');
        }

        $this->load->model("ekspedisi_model");
    }

    public function index()
    {
        $data = [
            "app_name"  => "TOKO RAGIL 2 REBORN",
            "title"     => ucwords(str_replace("_", " ", $this->router->fetch_class())),
            "ekspedisi" => $this->ekspedisi_model->getAll(),
        ];

        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("master/ekspedisi/index", $data);
        $this->load->view("component/footer", $data);
    }

    public function add()
    {
        $nama           = strtoupper($this->input->post("nama"));
        $biaya_ongkir   = $this->input->post("biaya_ongkir");

        $cek = $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get_where("m_ekspedisi", ["nama" => $nama])
            ->row();
        if (!$cek) {
            $dataInsert = [
                "nama"          => $nama,
                "biaya_ongkir"  => $biaya_ongkir,
                "created_at"    => date("Y-m-d H:i:s"),
                "created_by"    => $this->session->userdata('id'),
            ];

            $insert = $this->db->insert('m_ekspedisi', $dataInsert);

            if ($insert) {
                $this->session->set_flashdata("sukses", "Berhasil menambahkan data ekspedisi!");
            } else {
                $this->session->set_flashdata("gagal", "Terjadi kesalahan saat menambahkan ekspedisi!");
            }
        } else {
            $this->session->set_flashdata("gagal", "Maaf, ekspedisi sudah terdaftar!");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function getById($id = null)
    {
        $data = $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get_where("m_ekspedisi", ["id" => $id])
            ->row();
        echo json_encode($data);
    }

    public function update()
    {
        $id             = $this->input->post("id_edit");
        $nama           = strtoupper($this->input->post("nama_edit"));
        $biaya_ongkir   = $this->input->post("biaya_ongkir_edit");

        $cekById = $this->db
                ->where('deleted_at IS NULL', null, false)
                ->get_where("m_ekspedisi", ["id" => $id])
                ->row();

        if ($cekById->nama == $nama) {
            $dataUpdate = [
                "nama"          => $nama,
                "biaya_ongkir"  => $biaya_ongkir,
                "updated_at"    => date("Y-m-d H:i:s"),
                "updated_by"    => $this->session->userdata('id'),
            ];

            $update = $this->db->update("m_ekspedisi", $dataUpdate, ["id" => $id]);
            if ($update) {
                $this->session->set_flashdata("sukses", "Berhasil memperbaharui data ekspedisi!");
            } else {
                $this->session->set_flashdata("gagal", "Terjadi kesalahan saat mengubah data ekspedisi");
            }
        } else {
            $cekByNama = $this->db
                ->where('deleted_at IS NULL', null, false)
                ->get_where("m_ekspedisi", ["nama" => $nama])
                ->row();
            if (!$cekByNama) {
                $dataUpdate = [
                    "nama"          => $nama,
                    "biaya_ongkir"  => $biaya_ongkir,
                    "updated_at"    => date("Y-m-d H:i:s"),
                    "updated_by"    => $this->session->userdata('id'),
                ];
    
                $update = $this->db->update("m_ekspedisi", $dataUpdate, ["id" => $id]);
                if ($update) {
                    $this->session->set_flashdata("sukses", "Berhasil memperbaharui data ekspedisi!");
                } else {
                    $this->session->set_flashdata("gagal", "Terjadi kesalahan saat mengubah data ekspedisi");
                }
            } else {
                $this->session->set_flashdata("gagal", "Maaf, ekspedisi sudah terdaftar!");
            }
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete()
    {
        $id     = $this->input->post("id", TRUE);
        $cek    = $this->db
                ->get_where("m_ekspedisi", ["id" => $id])
                ->row();
        if ($cek) {
            $dataDelete = [
                "deleted_at"    => date("Y-m-d H:i:s"),
                "deleted_by"    => $this->session->userdata('id'),
            ];
            $delete = $this->db->update("m_ekspedisi", $dataDelete, ["id" => $id]);
            if ($delete) {
                echo json_encode([
                    'response_code'     => 200,
                    'response_message'  => 'Ekspedisi berhasil dihapus',
                ]);
            } else {
                echo json_encode([
                    'response_code'     => 400,
                    'response_message'  => 'Ekspedisi gagal dihapus',
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
