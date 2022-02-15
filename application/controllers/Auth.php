<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function index()
    {
        if ($this->session->userdata('status_user') == '' || $this->session->userdata('status_user') == null) {
            $this->load->view('auth/index');
        } else {
            redirect("dashboard");
        }
    }

    public function login_proses()
    {
        $username   = $this->input->post('username', true);
        $password   = md5($this->input->post('password', true));

        $getUser = $this->db
            ->get_where("m_user", [
                "username"  => $username,
                "password"  => $password,
            ])
            ->row();

        if ($getUser) {
            $userData = [
                "id_user"        => $getUser->id,
                "username_user"  => $getUser->username,
                "nama_user"      => $getUser->nama,
                "email_user"     => $getUser->email,
                "telepon_user"   => $getUser->telepon,
                "status_user"    => "LOGIN",
            ];
            $this->session->set_userdata($userData);
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('gagal', 'Username atau password salah');
            redirect("auth");
        }
    }

    public function logout_proses()
    {
        unset($_SESSION['id_user']);
        unset($_SESSION['username_user']);
        unset($_SESSION['nama_user']);
        unset($_SESSION['email_user']);
        unset($_SESSION['telepon_user']);
        unset($_SESSION['status_user']);
        // $this->session->sess_destroy();

        redirect("auth");
    }

    public function registrasi()
    {
        $this->load->view('auth/registrasi');
    }

    public function add_user()
    {
        $uname                  = strtolower($this->input->post("username"));
        $username               = str_replace(" ", "_", $uname);
        $password               = md5($this->input->post("password"));
        $konfirmasi_password    = md5($this->input->post("konfirmasi_password"));
        $nama                   = strtoupper($this->input->post("nama"));
        $alamat_lengkap         = strtoupper($this->input->post("alamat_lengkap"));
        $kode_pos               = $this->input->post("kode_pos");
        $telepon                = $this->input->post("telepon");
        $email                  = $this->input->post("email");

        if ($password == $konfirmasi_password) {
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
                    "created_by"        => $username,
                ];

                $insert = $this->db->insert('m_user', $dataInsert);

                if ($insert) {
                    $this->session->set_flashdata("sukses", "Berhasil menambahkan data user, silakan login menggunakan akun baru anda!");
                    redirect('auth');
                } else {
                    $this->session->set_flashdata("gagal", "Terjadi kesalahan saat menambahkan user!");
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $this->session->set_flashdata("gagal", "Maaf, user sudah terdaftar!");
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $this->session->set_flashdata("gagal", "Konfirmasi password tidak sama, silakan cek kembali!");
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
