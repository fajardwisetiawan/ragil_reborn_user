<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    public function getAll()
    {
        return $this->db
            ->select([
                "m_produk.id",
                "m_produk.nama",
                "m_produk.deskripsi",
                "m_produk.jenis_barang",
                "m_produk.harga",
                "m_produk.gambar",
                "SUM(stok) as stok",
            ])
            ->join("m_stok", "m_produk.id = m_stok.id_produk", "LEFT")
            ->group_by([
                "m_produk.id",
                "m_produk.nama",
                "m_produk.deskripsi",
                "m_produk.jenis_barang",
                "m_produk.harga",
                "m_produk.gambar",
            ])
            ->where('m_produk.deleted_at IS NULL', null, false)
            ->get("m_produk")
            ->result();
    }
}