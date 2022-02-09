<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') == '' || $this->session->userdata('status') == null) {
            redirect("auth");
        }

        $this->load->model("dashboard_model");
    }

    public function index()
    {
        $data = [
            "app_name"  => "TOKO RAGIL 2 REBORN",
            "title"     => strtoupper(str_replace("_", " ", $this->router->fetch_class())),
            "produk"    => $this->dashboard_model->getAll(),
        ];

        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("dashboard/index", $data);
        $this->load->view("component/footer", $data);
    }
}
