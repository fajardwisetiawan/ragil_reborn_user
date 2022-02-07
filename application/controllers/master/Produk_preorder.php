<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk_preorder extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') == '' || $this->session->userdata('status') == null) {
            $this->load->view('auth/login');
        }

        $this->load->helper(array('form', 'url', 'file'));

        $this->load->model("produk_preorder_model");
    }

    public function index()
    {
        $data = [   
            "app_name"      => "TOKO RAGIL 2 REBORN",
            "title"         => ucwords(str_replace("_", " ", $this->router->fetch_class())),
            "produk"        => $this->produk_preorder_model->getAll(),
            "kategori"      => $this->produk_preorder_model->getKategori(),
            "kategori_edit" => $this->produk_preorder_model->getKategori(),
        ];

        // die(json_encode($data['produk']));
        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("master/produk_preorder/index", $data);
        $this->load->view("component/footer", $data);
    }

    public function add()
    {
        $nama       = $this->input->post("nama");
        $deskripsi  = $this->input->post("deskripsi");
        $harga      = $this->input->post("harga");
        $kategori   = $this->input->post("kategori");
        $gambar     = $this->input->post("gambar");

        $cek = $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get_where("m_produk_preorder", ["nama" => $nama])
            ->row();
        if (!$cek) {

            if (!empty($_FILES["gambar"]["name"])) {
                $upload = $this->produk_preorder_model->uploadGambar();

                if ($upload['result'] == "success") {
                    $dataInsert = [
                        "nama"          => $nama,
                        "deskripsi"     => $deskripsi,
                        "harga"         => $harga,
                        "id_kategori"   => $kategori,
                        "gambar"        => $upload['file']['file_name'],
                        "created_at"    => date("Y-m-d H:i:s"),
                        "created_by"    => $this->session->userdata('id'),
                    ];
        
                    $insert = $this->db->insert('m_produk_preorder', $dataInsert);
        
                    if ($insert) {
                        $this->session->set_flashdata("sukses", "Berhasil menambahkan data produk preorder!");
                    } else {
                        $this->session->set_flashdata("gagal", "Terjadi kesalahan saat menambahkan produk preorder!");
                    }
                } else {
                    $this->session->set_flashdata('failed', $upload['error']);
                }
            } else {
                $dataInsert = [
                    "nama"          => $nama,
                    "deskripsi"     => $deskripsi,
                    "harga"         => $harga,
                    "id_kategori"   => $kategori,
                    "created_at"    => date("Y-m-d H:i:s"),
                    "created_by"    => $this->session->userdata('id'),
                ];
    
                $insert = $this->db->insert('m_produk_preorder', $dataInsert);
    
                if ($insert) {
                    $this->session->set_flashdata("sukses", "Berhasil menambahkan data produk preorder!");
                } else {
                    $this->session->set_flashdata("gagal", "Terjadi kesalahan saat menambahkan produk preorder!");
                }
            }
        } else {
            $this->session->set_flashdata("gagal", "Maaf, produk preorder sudah terdaftar!");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function getById($id = null)
    {
        $data = $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get_where("m_produk_preorder", ["id" => $id])
            ->row();
        echo json_encode($data);
    }

    public function update()
    {
        $id         = $this->input->post("id_edit");
        $nama       = $this->input->post("nama_edit");
        $deskripsi  = $this->input->post("deskripsi_edit");
        $harga      = $this->input->post("harga_edit");
        $kategori   = $this->input->post("kategori_edit");

        $cekById = $this->db
                ->where('deleted_at IS NULL', null, false)
                ->get_where("m_produk_preorder", ["id" => $id])
                ->row();

        if ($cekById->nama == $nama) {
            if (!empty($_FILES["gambar_edit"]["name"])) {
                $upload         = $this->produk_preorder_model->uploadGambarEdit();
                $gambar_lama    = $this->input->post('gambar_lama', true);
                $path           = "./images/" . $gambar_lama;
    
                if ($upload['result'] == "success") {
                    $dataUpdate = [
                        "nama"          => $nama,
                        "deskripsi"     => $deskripsi,
                        "harga"         => $harga,
                        "id_kategori"   => $kategori,
                        "gambar"        => $upload['file']['file_name'],
                        "updated_at"    => date("Y-m-d H:i:s"),
                        "updated_by"    => $this->session->userdata('id'),
                    ];
        
                    $update = $this->db->update("m_produk_preorder", $dataUpdate, ["id" => $id]);
                    $delete_file = unlink($path);
    
                    if ($update && $delete_file) {
                        $this->session->set_flashdata("sukses", "Berhasil memperbaharui data produk preorder!");
                    } else {
                        $this->session->set_flashdata("gagal", "Terjadi kesalahan saat mengubah data produk preorder");
                    }
                } else {
                    $this->session->set_flashdata('failed', $upload['error']);
                }
            } else {
                $dataUpdate = [
                    "nama"          => $nama,
                    "deskripsi"     => $deskripsi,
                    "harga"         => $harga,
                    "id_kategori"   => $kategori,
                    "updated_at"    => date("Y-m-d H:i:s"),
                    "updated_by"    => $this->session->userdata('id'),
                ];
    
                $update = $this->db->update("m_produk_preorder", $dataUpdate, ["id" => $id]);
                if ($update) {
                    $this->session->set_flashdata("sukses", "Berhasil memperbaharui data produk preorder!");
                } else {
                    $this->session->set_flashdata("gagal", "Terjadi kesalahan saat mengubah data produk preorder");
                }
            }
        } else {
            $cekByNama = $this->db
                ->where('deleted_at IS NULL', null, false)
                ->get_where("m_produk_preorder", ["nama" => $nama])
                ->row();
            if (!$cekByNama) {
                if (!empty($_FILES["gambar_edit"]["name"])) {
                    $upload         = $this->produk_preorder_model->uploadGambarEdit();
                    $gambar_lama    = $this->input->post('gambar_lama', true);
                    $path           = "./images/" . $gambar_lama;
        
                    if ($upload['result'] == "success") {
                        $dataUpdate = [
                            "nama"          => $nama,
                            "deskripsi"     => $deskripsi,
                            "harga"         => $harga,
                            "id_kategori"   => $kategori,
                            "gambar"        => $upload['file']['file_name'],
                            "updated_at"    => date("Y-m-d H:i:s"),
                            "updated_by"    => $this->session->userdata('id'),
                        ];
            
                        $update = $this->db->update("m_produk_preorder", $dataUpdate, ["id" => $id]);
                        $delete_file = unlink($path);
        
                        if ($update && $delete_file) {
                            $this->session->set_flashdata("sukses", "Berhasil memperbaharui data produk preorder!");
                        } else {
                            $this->session->set_flashdata("gagal", "Terjadi kesalahan saat mengubah data produk preorder");
                        }
                    } else {
                        $this->session->set_flashdata('failed', $upload['error']);
                    }
                } else {
                    $dataUpdate = [
                        "nama"          => $nama,
                        "deskripsi"     => $deskripsi,
                        "harga"         => $harga,
                        "id_kategori"   => $kategori,
                        "updated_at"    => date("Y-m-d H:i:s"),
                        "updated_by"    => $this->session->userdata('id'),
                    ];
        
                    $update = $this->db->update("m_produk_preorder", $dataUpdate, ["id" => $id]);
                    if ($update) {
                        $this->session->set_flashdata("sukses", "Berhasil memperbaharui data produk preorder!");
                    } else {
                        $this->session->set_flashdata("gagal", "Terjadi kesalahan saat mengubah data produk preorder");
                    }
                }
            } else {
                $this->session->set_flashdata("gagal", "Maaf, produk preorder sudah terdaftar!");
            }
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete()
    {
        $id     = $this->input->post("id", TRUE);
        $cek    = $this->db
                ->get_where("m_produk_preorder", ["id" => $id])
                ->row();
        if ($cek) {
            $dataDelete = [
                "deleted_at"    => date("Y-m-d H:i:s"),
                "deleted_by"    => $this->session->userdata('id'),
            ];
            $delete = $this->db->update("m_produk_preorder", $dataDelete, ["id" => $id]);
            if ($delete) {
                echo json_encode([
                    'response_code'     => 200,
                    'response_message'  => 'Produk preorder berhasil dihapus',
                ]);
            } else {
                echo json_encode([
                    'response_code'     => 400,
                    'response_message'  => 'Produk preorder gagal dihapus',
                ]);
            }
        } else {
            echo json_encode([
                'response_code'     => 400,
                'response_message'  => 'Produk preorder tidak ditemukan',
            ]);
        }
    }

    public function detail($id_produk = null)
    {
        $data = [   
            "app_name"      => "TOKO RAGIL 2 REBORN",
            "title"         => ucwords(str_replace("_", " ", $this->router->fetch_class())),
            "produk"        => $this->produk_preorder_model->getStok($id_produk),
            "ukuran"        => $this->produk_preorder_model->getUkuran(),
            "ukuran_edit"   => $this->produk_preorder_model->getUkuran(),
        ];

        // die(json_encode($data));
        $this->load->view("component/header", $data);
        $this->load->view("component/sidebar", $data);
        $this->load->view("master/produk_preorder/detail", $data);
        $this->load->view("component/footer", $data);
    }

    public function add_detail()
    {
        $id_produk  = $this->input->post("id_produk");
        $ukuran     = $this->input->post("ukuran");
        $stok       = $this->input->post("stok");

        $cek = $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get_where("m_stok", ["id_produk" => $id_produk, "id_ukuran" => $ukuran])
            ->row();

        if (!$cek) {
            $dataInsert = [
                "id_produk"     => $id_produk,
                "id_ukuran"     => $ukuran,
                "stok"          => $stok,
                "created_at"    => date("Y-m-d H:i:s"),
                "created_by"    => $this->session->userdata('id'),
            ];

            $insert = $this->db->insert('m_stok', $dataInsert);

            if ($insert) {
                $this->session->set_flashdata("sukses", "Berhasil menambahkan data stok!");
            } else {
                $this->session->set_flashdata("gagal", "Terjadi kesalahan saat menambahkan stok!");
            }
        } else {
            $this->session->set_flashdata("gagal", "Maaf, stok sudah terdaftar!");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function getDetailById($id = null)
    {
        $data = $this->db
            ->where('deleted_at IS NULL', null, false)
            ->get_where("m_stok", ["id" => $id])
            ->row();
        echo json_encode($data);
    }

    public function update_detail()
    {
        $id         = $this->input->post("id_edit");
        $id_produk  = $this->input->post("id_produk_edit");
        $ukuran     = $this->input->post("ukuran_edit");
        $stok       = $this->input->post("stok_edit");

        $cekById = $this->db
                ->where('deleted_at IS NULL', null, false)
                ->get_where("m_stok", ["id" => $id])
                ->row();

        if ($cekById->id_produk == $id_produk && $cekById->id_ukuran == $ukuran) {
            $dataUpdate = [
                "id_produk"     => $id_produk,
                "id_ukuran"     => $ukuran,
                "stok"          => $stok,
                "updated_at"    => date("Y-m-d H:i:s"),
                "updated_by"    => $this->session->userdata('id'),
            ];

            $update = $this->db->update("m_stok", $dataUpdate, ["id" => $id]);
            if ($update) {
                $this->session->set_flashdata("sukses", "Berhasil memperbaharui data stok!");
            } else {
                $this->session->set_flashdata("gagal", "Terjadi kesalahan saat mengubah data stok");
            }
        } else {
            $cekByUkuran = $this->db
                ->where('deleted_at IS NULL', null, false)
                ->get_where("m_stok", ["id_produk" => $id_produk, "id_ukuran" => $ukuran])
                ->row();
            if (!$cekByUkuran) {
                $dataUpdate = [
                    "id_produk"     => $id_produk,
                    "id_ukuran"     => $ukuran,
                    "stok"          => $stok,
                    "updated_at"    => date("Y-m-d H:i:s"),
                    "updated_by"    => $this->session->userdata('id'),
                ];
    
                $update = $this->db->update("m_stok", $dataUpdate, ["id" => $id]);
                if ($update) {
                    $this->session->set_flashdata("sukses", "Berhasil memperbaharui data stok!");
                } else {
                    $this->session->set_flashdata("gagal", "Terjadi kesalahan saat mengubah data stok");
                }
            } else {
                $this->session->set_flashdata("gagal", "Maaf, stok sudah terdaftar!");
            }
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete_detail()
    {
        $id     = $this->input->post("id", TRUE);
        $cek    = $this->db
                ->get_where("m_stok", ["id" => $id])
                ->row();
        if ($cek) {
            $dataDelete = [
                "deleted_at"    => date("Y-m-d H:i:s"),
                "deleted_by"    => $this->session->userdata('id'),
            ];
            $delete = $this->db->update("m_stok", $dataDelete, ["id" => $id]);
            if ($delete) {
                echo json_encode([
                    'response_code'     => 200,
                    'response_message'  => 'Stok berhasil dihapus',
                ]);
            } else {
                echo json_encode([
                    'response_code'     => 400,
                    'response_message'  => 'Stok gagal dihapus',
                ]);
            }
        } else {
            echo json_encode([
                'response_code'     => 400,
                'response_message'  => 'Stok tidak ditemukan',
            ]);
        }
    }
}
