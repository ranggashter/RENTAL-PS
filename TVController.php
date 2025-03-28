<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TVController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // cek status tv apakah harus nyala atau mati
    public function cek_status_tv()
    {
        // cek apakah ada channel aktif sekarang
        $query = $this->db->query("SELECT * FROM tb_sewa WHERE start <= NOW() AND stop > NOW() LIMIT 1");
        $status = $query->num_rows() > 0 ? "on" : "off";

        // kirim response json
        echo json_encode(["status" => $status]);
    }

    // fungsi untuk mematikan tv
    public function matikan_tv($id_chanel)
    {
        // update stop waktu di database
        $this->db->where('id_sewa', $id_chanel); // sesuaikan nama kolom dengan primary key di tb_sewa
        $this->db->update('tb_sewa', ['stop' => date('Y-m-d H:i:s')]);

        // kirim response json
        echo json_encode(["message" => "TV dimatikan untuk channel $id_chanel"]);
    }
}
