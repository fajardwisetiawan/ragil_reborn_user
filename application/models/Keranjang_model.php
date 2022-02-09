<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Keranjang_model extends CI_Model
{
    public function getAll()
    {
        $id_user    = $this->session->userdata('id');
        return $this->db
            ->select([
                "tr_keranjang.*",
                "m_produk.nama AS nama_produk",
                "m_produk.harga",
            ])
            ->join("m_produk", "tr_keranjang.id_produk = m_produk.id", "LEFT")
            ->where('tr_keranjang.deleted_at IS NULL', null, false)
            ->get_where("tr_keranjang", ["tr_keranjang.id_user" => $id_user, "tr_keranjang.status" => "BELUM"])
            ->result();
    }

    public function getDetail($id)
    {
        return $this->db
            ->select([
                "tr_keranjang.*",
                "m_produk.nama AS nama_produk",
                "m_produk.deskripsi",
                "m_produk.gambar",
                "m_produk.harga",
                "m_stok.stok",
            ])
            ->join("m_produk", "tr_keranjang.id_produk = m_produk.id", "LEFT")
            ->join("m_stok", "tr_keranjang.id_stok = m_stok.id", "LEFT")
            ->where('tr_keranjang.deleted_at IS NULL', null, false)
            ->get_where("tr_keranjang", ["tr_keranjang.id" => $id])
            ->row();
    }

    public function getUkuran($id_produk)
    {
        return $this->db
            ->select([
                "m_stok.*",
                "m_ukuran.ukuran"
            ])
            ->join("m_ukuran", "m_stok.id_ukuran = m_ukuran.id", "LEFT")
            ->where(["m_stok.id_produk" => $id_produk])
            ->where('m_stok.deleted_at IS NULL', null, false)
            ->get("m_stok")->result();
    }

    public function getKeranjang()
    {
        $id_user    = $this->session->userdata('id');

        return $this->db
            ->select([
                "tr_keranjang.*",
                "m_produk.nama AS nama_produk",
                "m_produk.harga",
            ])
            ->join("m_produk", "tr_keranjang.id_produk = m_produk.id", "LEFT")
            ->where('tr_keranjang.deleted_at IS NULL', null, false)
            ->get_where("tr_keranjang", ["tr_keranjang.id_user" => $id_user, "tr_keranjang.status" => "BELUM"])
            ->result();
    }

    public function getUser()
    {
        $id_user    = $this->session->userdata('id');

        return $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get_where("m_user", ["id" => $id_user])
            ->row();
    }

    public function getEkspedisi()
    {
        return $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get("m_ekspedisi")->result();
    }

    public function getBank()
    {
        return $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get("m_bank")->result();
    }
}