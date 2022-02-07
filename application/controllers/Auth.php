<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function index()
    {
        if ($this->session->userdata('status') == '' || $this->session->userdata('status') == null) {
            $this->load->view('auth/index');
        } else {
            redirect("dashboard");
        }
    }

    public function login_proses()
    {
        $username   = $this->input->post('username', true);
        $password   = md5($this->input->post('password', true));

        $getAdmin = $this->db
                ->get_where("m_admin", [
                    "username"  => $username,
                    "password"  => $password,
                ])
                ->row();
        
        if ($getAdmin) {
            $userData = [
                "id"        => $getAdmin->id,
                "username"  => $getAdmin->username,
                "nama"      => $getAdmin->nama,
                "email"     => $getAdmin->email,
                "telepon"   => $getAdmin->telepon,
                "status"    => "LOGIN",
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
        unset($_SESSION['id']);
        unset($_SESSION['username']);
        unset($_SESSION['nama']);
        unset($_SESSION['email']);
        unset($_SESSION['telepon']);
        unset($_SESSION['status']);
        $this->session->sess_destroy();

        redirect("auth");
    }
}
