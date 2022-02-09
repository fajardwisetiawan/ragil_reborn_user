<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') == '' || $this->session->userdata('status') == null) {
            redirect("auth");
        }

        $this->load->model("kategori_model");
    }

    public function jaket()
    {
        $data = [
            "app_name"  => "TOKO RAGIL 2 REBORN",
            "title"     => strtoupper(str_replace("_", " ", $this->router->fetch_class())),
            "produk"    => $this->kategori_model->getAll(),
        ];

        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("transaksi/kategori/jaket", $data);
        $this->load->view("component/footer", $data);
    }

    public function jersey()
    {
        $data = [
            "app_name"  => "TOKO RAGIL 2 REBORN",
            "title"     => strtoupper(str_replace("_", " ", $this->router->fetch_class())),
            "produk"    => $this->kategori_model->getAll(),
        ];

        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("transaksi/kategori/jersey", $data);
        $this->load->view("component/footer", $data);
    }

    public function celana()
    {
        $data = [
            "app_name"  => "TOKO RAGIL 2 REBORN",
            "title"     => strtoupper(str_replace("_", " ", $this->router->fetch_class())),
            "produk"    => $this->kategori_model->getAll(),
        ];

        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("transaksi/kategori/celana", $data);
        $this->load->view("component/footer", $data);
    }

    public function lainnya()
    {
        $data = [
            "app_name"  => "TOKO RAGIL 2 REBORN",
            "title"     => strtoupper(str_replace("_", " ", $this->router->fetch_class())),
            "produk"    => $this->kategori_model->getAll(),
        ];

        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("transaksi/kategori/lainnya", $data);
        $this->load->view("component/footer", $data);
    }
}
