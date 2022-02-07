<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') == '' || $this->session->userdata('status') == null) {
            $this->load->view('auth/login');
        }

        $this->load->model("kategori_model");
    }

    public function index()
    {
        $data = [
            "app_name"  => "TOKO RAGIL 2 REBORN",
            "title"     => ucwords(str_replace("_", " ", $this->router->fetch_class())),
            "kategori"  => $this->kategori_model->getAll(),
        ];

        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("master/kategori/index", $data);
        $this->load->view("component/footer", $data);
    }

    public function add()
    {
        $kategori = strtoupper($this->input->post("kategori"));

        $cek = $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get_where("m_kategori", ["kategori" => $kategori])
            ->row();
        if (!$cek) {
            $dataInsert = [
                "kategori"      => $kategori,
                "created_at"    => date("Y-m-d H:i:s"),
                "created_by"    => $this->session->userdata('id'),
            ];

            $insert = $this->db->insert('m_kategori', $dataInsert);

            if ($insert) {
                $this->session->set_flashdata("sukses", "Berhasil menambahkan data kategori!");
            } else {
                $this->session->set_flashdata("gagal", "Terjadi kesalahan saat menambahkan kategori!");
            }
        } else {
            $this->session->set_flashdata("gagal", "Maaf, kategori sudah terdaftar!");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function getById($id = null)
    {
        $data = $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get_where("m_kategori", ["id" => $id])
            ->row();
        echo json_encode($data);
    }

    public function update()
    {
        $id         = $this->input->post("id_edit");
        $kategori   = strtoupper($this->input->post("kategori_edit"));

        $cekById = $this->db
                ->where('deleted_at IS NULL', null, false)
                ->get_where("m_kategori", ["id" => $id])
                ->row();

        if ($cekById->kategori == $kategori) {
            $dataUpdate = [
                "kategori"      => $kategori,
                "updated_at"    => date("Y-m-d H:i:s"),
                "updated_by"    => $this->session->userdata('id'),
            ];

            $update = $this->db->update("m_kategori", $dataUpdate, ["id" => $id]);
            if ($update) {
                $this->session->set_flashdata("sukses", "Berhasil memperbaharui data kategori!");
            } else {
                $this->session->set_flashdata("gagal", "Terjadi kesalahan saat mengubah data kategori");
            }
        } else {
            $cekByNama = $this->db
                ->where('deleted_at IS NULL', null, false)
                ->get_where("m_kategori", ["kategori" => $kategori])
                ->row();
            if (!$cekByNama) {
                $dataUpdate = [
                    "kategori"      => $kategori,
                    "updated_at"    => date("Y-m-d H:i:s"),
                    "updated_by"    => $this->session->userdata('id'),
                ];
    
                $update = $this->db->update("m_kategori", $dataUpdate, ["id" => $id]);
                if ($update) {
                    $this->session->set_flashdata("sukses", "Berhasil memperbaharui data kategori!");
                } else {
                    $this->session->set_flashdata("gagal", "Terjadi kesalahan saat mengubah data kategori");
                }
            } else {
                $this->session->set_flashdata("gagal", "Maaf, kategori sudah terdaftar!");
            }
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete()
    {
        $id     = $this->input->post("id", TRUE);
        $cek    = $this->db
                ->get_where("m_kategori", ["id" => $id])
                ->row();
        if ($cek) {
            $dataDelete = [
                "deleted_at"    => date("Y-m-d H:i:s"),
                "deleted_by"    => $this->session->userdata('id'),
            ];
            $delete = $this->db->update("m_kategori", $dataDelete, ["id" => $id]);
            if ($delete) {
                echo json_encode([
                    'response_code'     => 200,
                    'response_message'  => 'Kategori berhasil dihapus',
                ]);
            } else {
                echo json_encode([
                    'response_code'     => 400,
                    'response_message'  => 'Kategori gagal dihapus',
                ]);
            }
        } else {
            echo json_encode([
                'response_code'     => 400,
                'response_message'  => 'Kategori tidak ditemukan',
            ]);
        }
    }
}
