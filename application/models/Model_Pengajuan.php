<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Pengajuan extends CI_Model {
   
    public function insert_pengajuan($data) {
        return $this->db->insert('pengajuan_kartu_akses', $data);
    }

    public function get_pengajuan_by_user($id_user) {
        $this->db->select('pengajuan_kartu_akses.*, user.nama_lengkap, user.email, user.fakultas, user.prodi, user.keterangan'); // Added 'keterangan' column
        $this->db->from('pengajuan_kartu_akses');
        $this->db->join('user', 'pengajuan_kartu_akses.id_user = user.id_user'); // Join with 'user' table
        $this->db->where('pengajuan_kartu_akses.id_user', $id_user);
        $query = $this->db->get();
        return $query->result_array(); // Return result as an array
    }

    public function get_pengajuan_by_id($id_ka) {
        $this->db->select('pengajuan_kartu_akses.*, user.nama_lengkap, user.email, user.fakultas, user.prodi, user.keterangan'); // Added 'keterangan' column
        $this->db->from('pengajuan_kartu_akses');
        $this->db->join('user', 'pengajuan_kartu_akses.id_user = user.id_user'); // Join with 'user' table
        $this->db->where('pengajuan_kartu_akses.id_ka', $id_ka); // Filter by 'id_ka'
        $query = $this->db->get();
        return $query->row(); // Return a single row as an object
    }

    public function count_pengajuan_by_status($status) {
        $this->db->where('status', $status);
        $this->db->from('pengajuan_kartu_akses');
        return $this->db->count_all_results();
    }

    public function get_pengajuan_by_type($type, $status) {
        $this->db->select('pengajuan_kartu_akses.*, user.nama_lengkap, user.email, user.fakultas, user.prodi, user.keterangan'); // Added 'keterangan' column
        $this->db->from('pengajuan_kartu_akses');
        $this->db->join('user', 'pengajuan_kartu_akses.id_user = user.id_user');
        $this->db->where('user.keterangan', $type); // Filter by user type
        $this->db->where('pengajuan_kartu_akses.status', $status);
        $this->db->order_by('pengajuan_kartu_akses.tanggal_pengajuan', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_pengajuan($type) {
        $this->db->select('pengajuan_kartu_akses.*, user.nama_lengkap, user.email, user.fakultas, user.prodi, user.keterangan'); // Added 'keterangan' column
        $this->db->from('pengajuan_kartu_akses');
        $this->db->join('user', 'pengajuan_kartu_akses.id_user = user.id_user');
        $this->db->where('user.keterangan', $type); // Filter by user type
        $this->db->where_in('pengajuan_kartu_akses.status', ["Approved", "Rejected"]); // Show both Approved and Rejected statuses
    
        $this->db->order_by('pengajuan_kartu_akses.tanggal_pengajuan', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_keterangan_kartu($id_ka) {
        $data = array(
            'keterangan_kartu' => 'selesai diproses'
        );
    
        $this->db->where('id_ka', $id_ka);
        return $this->db->update('pengajuan_kartu_akses', $data); // Ganti 'nama_tabel' dengan nama tabel yang sesuai
    }
    
    public function update_status($id, $status, $alasan_ditolak = null) {
        $this->db->where('id_ka', $id);
        $update_data = ['status' => $status];
    
        if ($status == 'Rejected' && $alasan_ditolak) {
            $update_data['alasan_ditolak'] = $alasan_ditolak;
        }
    
        if ($status == 'Approved') {
            $update_data['status_pembayaran'] = 'Lunas';
        }
    
        return $this->db->update('pengajuan_kartu_akses', $update_data);
    }

    public function update_keterangan($id) {
        $this->db->where('id_ka', $id);
        $update_data = ['keterangan_kartu' => "kartu bisa diambil"];
        return $this->db->update('pengajuan_kartu_akses', $update_data);
    }
    

    public function save_pdf_path($id_ka, $pdf_path) {
        $data = array(
            'kwitansi' => $pdf_path
        );
        $this->db->where('id_ka', $id_ka);
        return $this->db->update('pengajuan_kartu_akses', $data);
    }
   
    public function get_pengajuan_by_tab_and_date_range($tab, $start_date, $end_date, $status) {
        $this->db->select('pengajuan_kartu_akses.*, user.nama_lengkap, user.prodi, user.keterangan');
        $this->db->from('pengajuan_kartu_akses');
        
        // Join dengan tabel user
        $this->db->join('user', 'pengajuan_kartu_akses.id_user = user.id_user', 'left');
        
        // Filter berdasarkan tab
        if ($tab == 'mahasiswa') {
            $this->db->where('user.keterangan', 'mahasiswa');
        } elseif ($tab == 'dosen') {
            $this->db->where('user.keterangan', 'dosen');
        } elseif ($tab == 'tendik') {
            $this->db->where('user.keterangan', 'tendik');
        }
    
        // Filter berdasarkan status
        if ($status) {
            $this->db->where('pengajuan_kartu_akses.status', $status);
        }
    
        // Filter berdasarkan rentang tanggal
        if ($start_date && $end_date) {
            $this->db->where('tanggal_pengajuan >=', $start_date);
            $this->db->where('tanggal_pengajuan <=', $end_date);
        }
    
        return $this->db->get()->result_array();
    }
    
    
}
?>
