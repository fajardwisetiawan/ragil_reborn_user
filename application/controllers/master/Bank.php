<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bank extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') == '' || $this->session->userdata('status') == null) {
            $this->load->view('auth/login');
        }

        $this->load->model("bank_model");
    }

    public function index()
    {
        $data = [
            "app_name"  => "TOKO RAGIL 2 REBORN",
            "title"     => ucwords(str_replace("_", " ", $this->router->fetch_class())),
            "bank"      => $this->bank_model->getAll(),
        ];

        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("master/bank/index", $data);
        $this->load->view("component/footer", $data);
    }

    public function add()
    {
        $nama           = strtoupper($this->input->post("nama"));
        $no_rekening    = strtoupper($this->input->post("no_rekening"));

        $cek = $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get_where("m_bank", ["nama" => $nama])
            ->row();
        if (!$cek) {
            $dataInsert = [
                "nama"          => $nama,
                "no_rekening"   => $no_rekening,
                "created_at"    => date("Y-m-d H:i:s"),
                "created_by"    => $this->session->userdata('id'),
            ];

            $insert = $this->db->insert('m_bank', $dataInsert);

            if ($insert) {
                $this->session->set_flashdata("sukses", "Berhasil menambahkan data bank!");
            } else {
                $this->session->set_flashdata("gagal", "Terjadi kesalahan saat menambahkan bank!");
            }
        } else {
            $this->session->set_flashdata("gagal", "Maaf, bank sudah terdaftar!");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function getById($id = null)
    {
        $data = $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get_where("m_bank", ["id" => $id])
            ->row();
        echo json_encode($data);
    }

    public function update()
    {
        $id             = $this->input->post("id_edit");
        $nama           = strtoupper($this->input->post("nama_edit"));
        $no_rekening    = $this->input->post("no_rekening_edit");

        $cekById = $this->db
                ->where('deleted_at IS NULL', null, false)
                ->get_where("m_bank", ["id" => $id])
                ->row();

        if ($cekById->nama == $nama) {
            $dataUpdate = [
                "nama"          => $nama,
                "no_rekening"   => $no_rekening,
                "updated_at"    => date("Y-m-d H:i:s"),
                "updated_by"    => $this->session->userdata('id'),
            ];

            $update = $this->db->update("m_bank", $dataUpdate, ["id" => $id]);
            if ($update) {
                $this->session->set_flashdata("sukses", "Berhasil memperbaharui data bank!");
            } else {
                $this->session->set_flashdata("gagal", "Terjadi kesalahan saat mengubah data bank");
            }
        } else {
            $cekByNama = $this->db
                ->where('deleted_at IS NULL', null, false)
                ->get_where("m_bank", ["nama" => $nama])
                ->row();
            if (!$cekByNama) {
                $dataUpdate = [
                    "nama"          => $nama,
                    "no_rekening"   => $no_rekening,
                    "updated_at"    => date("Y-m-d H:i:s"),
                    "updated_by"    => $this->session->userdata('id'),
                ];
    
                $update = $this->db->update("m_bank", $dataUpdate, ["id" => $id]);
                if ($update) {
                    $this->session->set_flashdata("sukses", "Berhasil memperbaharui data bank!");
                } else {
                    $this->session->set_flashdata("gagal", "Terjadi kesalahan saat mengubah data bank");
                }
            } else {
                $this->session->set_flashdata("gagal", "Maaf, bank sudah terdaftar!");
            }
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete()
    {
        $id     = $this->input->post("id", TRUE);
        $cek    = $this->db
                ->get_where("m_bank", ["id" => $id])
                ->row();
        if ($cek) {
            $dataDelete = [
                "deleted_at"    => date("Y-m-d H:i:s"),
                "deleted_by"    => $this->session->userdata('id'),
            ];
            $delete = $this->db->update("m_bank", $dataDelete, ["id" => $id]);
            if ($delete) {
                echo json_encode([
                    'response_code'     => 200,
                    'response_message'  => 'Bank berhasil dihapus',
                ]);
            } else {
                echo json_encode([
                    'response_code'     => 400,
                    'response_message'  => 'Bank gagal dihapus',
                ]);
            }
        } else {
            echo json_encode([
                'response_code'     => 400,
                'response_message'  => 'Bank tidak ditemukan',
            ]);
        }
    }
}
