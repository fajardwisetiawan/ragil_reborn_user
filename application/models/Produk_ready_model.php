<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_ready_model extends CI_Model
{
    public function getAll()
    {
        $data = $this->db
                ->select([
                    "m_produk_ready.*",
                    "m_kategori.kategori"
                ])
                ->join("m_kategori", "m_produk_ready.id_kategori = m_kategori.id", "LEFT")
                ->where('m_produk_ready.deleted_at IS NULL', null, false)
                ->get("m_produk_ready")
                ->result();
        return $data;
    }

    public function getKategori()
    {
        return $this->db->where('deleted_at IS NULL', null, false)->get("m_kategori")->result();
    }

    public function getUkuran()
    {
        return $this->db->where('deleted_at IS NULL', null, false)->get("m_ukuran")->result();
    }

    public function getStok($id_produk)
    {
        $data = $this->db
                ->select([
                    "m_stok.*",
                    "m_ukuran.ukuran"
                ])
                ->join("m_ukuran", "m_ukuran.id = m_stok.id_ukuran", "LEFT")
                ->where('m_stok.deleted_at IS NULL', null, false)
                ->get_where("m_stok", ["m_stok.id_produk" => $id_produk])
                ->result();
        return $data;
    }

    public function uploadGambar()
    {
        $id_admin   = $this->session->userdata('id');
        $newName    = time() . "_" . $id_admin;

        $config['upload_path']      = './images/';
        $config['allowed_types']    = 'jpg|png|jpeg';
        $config['file_name']        = $newName;
        $config['max_size']         = '2048';
        $config['remove_space']     = TRUE;

        $this->load->library('upload', $config); // Load konfigurasi uploadnya
        if ($this->upload->do_upload('gambar')) { // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
            return $return;
        } else {
            // Jika gagal :
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
            return $return;
        }
    }

    public function uploadGambarEdit()
    {
        $id_admin   = $this->session->userdata('id');
        $newName    = time() . "_" . $id_admin;

        $config['upload_path']      = './images/';
        $config['allowed_types']    = 'jpg|png|jpeg';
        $config['file_name']        = $newName;
        $config['max_size']         = '2048';
        $config['remove_space']     = TRUE;

        $this->load->library('upload', $config); // Load konfigurasi uploadnya
        if ($this->upload->do_upload('gambar_edit')) { // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
            return $return;
        } else {
            // Jika gagal :
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
            return $return;
        }
    }
}