<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ukuran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') == '' || $this->session->userdata('status') == null) {
            $this->load->view('auth/login');
        }

        $this->load->model("ukuran_model");
    }

    public function index()
    {
        $data = [
            "app_name"  => "TOKO RAGIL 2 REBORN",
            "title"     => ucwords(str_replace("_", " ", $this->router->fetch_class())),
            "ukuran"    => $this->ukuran_model->getAll(),
        ];

        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("master/ukuran/index", $data);
        $this->load->view("component/footer", $data);
    }

    public function add()
    {
        $ukuran   = strtoupper($this->input->post("ukuran"));

        $cek = $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get_where("m_ukuran", ["ukuran" => $ukuran])
            ->row();
        if (!$cek) {
            $dataInsert = [
                "ukuran"        => $ukuran,
                "created_at"    => date("Y-m-d H:i:s"),
                "created_by"    => $this->session->userdata('id'),
            ];

            $insert = $this->db->insert('m_ukuran', $dataInsert);

            if ($insert) {
                $this->session->set_flashdata("sukses", "Berhasil menambahkan data ukuran!");
            } else {
                $this->session->set_flashdata("gagal", "Terjadi kesalahan saat menambahkan ukuran!");
            }
        } else {
            $this->session->set_flashdata("gagal", "Maaf, ukuran sudah terdaftar!");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function getById($id = null)
    {
        $data = $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get_where("m_ukuran", ["id" => $id])
            ->row();
        echo json_encode($data);
    }

    public function update()
    {
        $id             = $this->input->post("id_edit");
        $ukuran         = strtoupper($this->input->post("ukuran_edit"));

        $cekById = $this->db
                ->where('deleted_at IS NULL', null, false)
                ->get_where("m_ukuran", ["id" => $id])
                ->row();

        if ($cekById->ukuran == $ukuran) {
            $dataUpdate = [
                "ukuran"        => $ukuran,
                "updated_at"    => date("Y-m-d H:i:s"),
                "updated_by"    => $this->session->userdata('id'),
            ];

            $update = $this->db->update("m_ukuran", $dataUpdate, ["id" => $id]);
            if ($update) {
                $this->session->set_flashdata("sukses", "Berhasil memperbaharui data ukuran!");
            } else {
                $this->session->set_flashdata("gagal", "Terjadi kesalahan saat mengubah data ukuran");
            }
        } else {
            $cekByNama = $this->db
                ->where('deleted_at IS NULL', null, false)
                ->get_where("m_ukuran", ["ukuran" => $ukuran])
                ->row();
            if (!$cekByNama) {
                $dataUpdate = [
                    "ukuran"        => $ukuran,
                    "updated_at"    => date("Y-m-d H:i:s"),
                    "updated_by"    => $this->session->userdata('id'),
                ];
    
                $update = $this->db->update("m_ukuran", $dataUpdate, ["id" => $id]);
                if ($update) {
                    $this->session->set_flashdata("sukses", "Berhasil memperbaharui data ukuran!");
                } else {
                    $this->session->set_flashdata("gagal", "Terjadi kesalahan saat mengubah data ukuran");
                }
            } else {
                $this->session->set_flashdata("gagal", "Maaf, ukuran sudah terdaftar!");
            }
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete()
    {
        $id     = $this->input->post("id", TRUE);
        $cek    = $this->db
                ->get_where("m_ukuran", ["id" => $id])
                ->row();
        if ($cek) {
            $dataDelete = [
                "deleted_at"    => date("Y-m-d H:i:s"),
                "deleted_by"    => $this->session->userdata('id'),
            ];
            $delete = $this->db->update("m_ukuran", $dataDelete, ["id" => $id]);
            if ($delete) {
                echo json_encode([
                    'response_code'     => 200,
                    'response_message'  => 'Ukuran berhasil dihapus',
                ]);
            } else {
                echo json_encode([
                    'response_code'     => 400,
                    'response_message'  => 'Ukuran gagal dihapus',
                ]);
            }
        } else {
            echo json_encode([
                'response_code'     => 400,
                'response_message'  => 'Ukuran tidak ditemukan',
            ]);
        }
    }
}
