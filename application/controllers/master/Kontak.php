<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kontak extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_user') == '' || $this->session->userdata('status_user') == null) {
            redirect("auth");
        }

        $this->load->model("kontak_model");
    }

    public function index()
    {
        $data = [
            "app_name"  => "TOKO RAGIL 2 REBORN",
            "title"     => ucwords(str_replace("_", " ", $this->router->fetch_class())),
            "toko"      => $this->kontak_model->getAll(),
        ];

        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("master/kontak/index", $data);
        $this->load->view("component/footer", $data);
    }
}
