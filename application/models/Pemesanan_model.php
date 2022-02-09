<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pemesanan_model extends CI_Model
{
    public function getBelum()
    {
        $data = $this->db
                ->select([
                    "tr_pemesanan.*",
                    "m_produk.nama AS nama_produk"
                ])
                ->join("m_produk", "tr_pemesanan.id_produk = m_produk.id", "LEFT")
                ->where('tr_pemesanan.deleted_at IS NULL', null, false)
                ->get_where("tr_pemesanan", ["tr_pemesanan.status_pemesanan" => "BELUM_BAYAR"])
                ->result();
        return $data;
    }

    public function getDikemas()
    {
        $data = $this->db
                ->select([
                    "tr_pemesanan.*",
                    "m_produk.nama AS nama_produk"
                ])
                ->join("m_produk", "tr_pemesanan.id_produk = m_produk.id", "LEFT")
                ->where('tr_pemesanan.deleted_at IS NULL', null, false)
                ->get_where("tr_pemesanan", ["tr_pemesanan.status_pemesanan" => "DIKEMAS"])
                ->result();
        return $data;
    }

    public function getDikirim()
    {
        $data = $this->db
                ->select([
                    "tr_pemesanan.*",
                    "m_produk.nama AS nama_produk"
                ])
                ->join("m_produk", "tr_pemesanan.id_produk = m_produk.id", "LEFT")
                ->where('tr_pemesanan.deleted_at IS NULL', null, false)
                ->get_where("tr_pemesanan", ["tr_pemesanan.status_pemesanan" => "DIKIRIM"])
                ->result();
        return $data;
    }

    public function getBatal()
    {
        $data = $this->db
                ->select([
                    "tr_pemesanan.*",
                    "m_produk.nama AS nama_produk"
                ])
                ->join("m_produk", "tr_pemesanan.id_produk = m_produk.id", "LEFT")
                ->where('tr_pemesanan.deleted_at IS NULL', null, false)
                ->get_where("tr_pemesanan", ["tr_pemesanan.status_pemesanan" => "BATAL"])
                ->result();
        return $data;
    }
}