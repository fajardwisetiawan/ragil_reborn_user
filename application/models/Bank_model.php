<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bank_model extends CI_Model
{
    public function getAll()
    {
        return $this->db->where('deleted_at IS NULL', null, false)->get("m_bank")->result();
    }
}