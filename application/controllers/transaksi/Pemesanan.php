<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemesanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') == '' || $this->session->userdata('status') == null) {
            redirect('auth');
        }

        $this->load->helper(array('form', 'url', 'file'));

        $this->load->model("pemesanan_model");
    }

    public function index()
    {
        $data = [
            "app_name"      => "TOKO RAGIL 2 REBORN",
            "title"         => ucwords(str_replace("_", " ", $this->router->fetch_class())),
            "belum"         => $this->pemesanan_model->getBelum(),
            "dikemas"       => $this->pemesanan_model->getDikemas(),
            "dikirim"       => $this->pemesanan_model->getDikirim(),
            "batal"         => $this->pemesanan_model->getBatal(),
        ];

        // die(json_encode($data));
        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("transaksi/pemesanan/index", $data);
        $this->load->view("component/footer", $data);
    }
}
