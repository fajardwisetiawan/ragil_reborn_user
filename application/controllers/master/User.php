<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') == '' || $this->session->userdata('status') == null) {
            $this->load->view('auth/login');
        }

        $this->load->model("user_model");
    }

    public function index()
    {
        $data = [
            "app_name"  => "TOKO RAGIL 2 REBORN",
            "title"     => ucwords(str_replace("_", " ", $this->router->fetch_class())),
            "user"      => $this->user_model->getAll(),
        ];

        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("master/user/index", $data);
        $this->load->view("component/footer", $data);
    }

    public function add()
    {
        $uname          = strtolower($this->input->post("username"));
        $username       = str_replace(" ","_", $uname);
        $password       = $this->input->post("password");
        $nama           = strtoupper($this->input->post("nama"));
        $alamat_lengkap = strtoupper($this->input->post("alamat_lengkap"));
        $kode_pos       = $this->input->post("kode_pos");
        $telepon        = $this->input->post("telepon");
        $email          = $this->input->post("email");

        $cek = $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get_where("m_user", ["username" => $username])
            ->row();
        if (!$cek) {
            $dataInsert = [
                "username"          => $username,
                "password"          => $password,
                "nama"              => $nama,
                "alamat_lengkap"    => $alamat_lengkap,
                "kode_pos"          => $kode_pos,
                "telepon"           => $telepon,
                "email"             => $email,
                "created_at"        => date("Y-m-d H:i:s"),
                "created_by"        => $this->session->userdata('id'),
            ];

            $insert = $this->db->insert('m_user', $dataInsert);

            if ($insert) {
                $this->session->set_flashdata("sukses", "Berhasil menambahkan data user!");
            } else {
                $this->session->set_flashdata("gagal", "Terjadi kesalahan saat menambahkan user!");
            }
        } else {
            $this->session->set_flashdata("gagal", "Maaf, user sudah terdaftar!");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function getById($id = null)
    {
        $data = $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get_where("m_user", ["id" => $id])
            ->row();
        echo json_encode($data);
    }

    public function update()
    {
        $id             = $this->input->post("id_edit");
        $username       = $this->input->post("username_edit");
        $nama           = $this->input->post("nama_edit");
        $alamat_lengkap = strtoupper($this->input->post("alamat_lengkap_edit"));
        $kode_pos       = $this->input->post("kode_pos_edit");
        $telepon        = $this->input->post("telepon_edit");
        $email          = $this->input->post("email_edit");


        $cekById = $this->db
                ->where('deleted_at IS NULL', null, false)
                ->get_where("m_user", ["id" => $id])
                ->row();

        if ($cekById->username == $username) {
            $dataUpdate = [
                "nama"              => $nama,
                "alamat_lengkap"    => $alamat_lengkap,
                "kode_pos"          => $kode_pos,
                "telepon"           => $telepon,
                "email"             => $email,
                "updated_at"        => date("Y-m-d H:i:s"),
                "updated_by"        => $this->session->userdata('id'),
            ];

            $update = $this->db->update("m_user", $dataUpdate, ["id" => $id]);
            if ($update) {
                $this->session->set_flashdata("sukses", "Berhasil memperbaharui data user!");
            } else {
                $this->session->set_flashdata("gagal", "Terjadi kesalahan saat mengubah data user");
            }
        } else {
            $cekByUsername = $this->db
                ->where('deleted_at IS NULL', null, false)
                ->get_where("m_user", ["username" => $username])
                ->row();
            if (!$cekByUsername) {
                $dataUpdate = [
                    "nama"              => $nama,
                    "alamat_lengkap"    => $alamat_lengkap,
                    "kode_pos"          => $kode_pos,
                    "telepon"           => $telepon,
                    "email"             => $email,
                    "updated_at"        => date("Y-m-d H:i:s"),
                    "updated_by"        => $this->session->userdata('id'),
                ];
    
                $update = $this->db->update("m_user", $dataUpdate, ["id" => $id]);
                if ($update) {
                    $this->session->set_flashdata("sukses", "Berhasil memperbaharui data user!");
                } else {
                    $this->session->set_flashdata("gagal", "Terjadi kesalahan saat mengubah data user");
                }
            } else {
                $this->session->set_flashdata("gagal", "Maaf, user sudah terdaftar!");
            }
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete()
    {
        $id     = $this->input->post("id", TRUE);
        $cek    = $this->db
                ->get_where("m_user", ["id" => $id])
                ->row();
        if ($cek) {
            $dataDelete = [
                "deleted_at"    => date("Y-m-d H:i:s"),
                "deleted_by"    => $this->session->userdata('id'),
            ];
            $delete = $this->db->update("m_user", $dataDelete, ["id" => $id]);
            if ($delete) {
                echo json_encode([
                    'response_code'     => 200,
                    'response_message'  => 'User berhasil dihapus',
                ]);
            } else {
                echo json_encode([
                    'response_code'     => 400,
                    'response_message'  => 'User gagal dihapus',
                ]);
            }
        } else {
            echo json_encode([
                'response_code'     => 400,
                'response_message'  => 'User tidak ditemukan',
            ]);
        }
    }
}
