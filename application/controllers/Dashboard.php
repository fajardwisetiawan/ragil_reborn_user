<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') == '' || $this->session->userdata('status') == null) {
            $this->load->view('auth/login');
        }
    }

    public function index()
    {
        $data = [
            "app_name"  => "TOKO RAGIL 2 REBORN",
            "title"     => strtoupper(str_replace("_", " ", $this->router->fetch_class())),
        ];

        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("dashboard/index", $data);
        $this->load->view("component/footer", $data);
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
            $this->session->set_flashdata('failed', 'Username atau password salah');
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
