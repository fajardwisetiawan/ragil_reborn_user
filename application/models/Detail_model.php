<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_model extends CI_Model
{
    public function getDetail($id, $jenis)
    {
        return $this->db->where(["id" => $id, "jenis_barang" => $jenis])->where('deleted_at IS NULL', null, false)->get("m_produk")->row();
    }

    public function getUkuran($id)
    {
        return $this->db
            ->select([
                "m_stok.*",
                "m_ukuran.ukuran"
            ])
            ->join("m_ukuran", "m_stok.id_ukuran = m_ukuran.id", "LEFT")
            ->where(["m_stok.id_produk" => $id])
            ->where('m_stok.deleted_at IS NULL', null, false)
            ->get("m_stok")->result();
    }
}