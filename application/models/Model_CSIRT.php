<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_CSIRT extends CI_Model {

    // Insert a new CSIRT report
    public function insert_csirt_report($data) {
        return $this->db->insert('pelaporan_csirt', $data);
    }

    public function get_csirt_reports_by_user($id_user) {
        $this->db->select('pelaporan_csirt.*, user.nama_lengkap, user.email, user.fakultas, user.prodi, user.keterangan');
        $this->db->from('pelaporan_csirt');
        $this->db->join('user', 'pelaporan_csirt.id_user = user.id_user');
        $this->db->where('pelaporan_csirt.id_user', $id_user);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // Get a single CSIRT report by report ID
    public function get_csirt_report_by_id($report_id) {
        $this->db->select('pelaporan_csirt.*, user.nama_lengkap, user.email, user.fakultas, user.prodi, user.keterangan');
        $this->db->from('pelaporan_csirt');
        $this->db->join('user', 'pelaporan_csirt.id_user = user.id_user'); // Join with 'user' table
        $this->db->where('pelaporan_csirt.id', $report_id); // Filter by 'id'
        $query = $this->db->get();
        return $query->row(); // Return a single row as an object
    }

    // Get CSIRT reports based on user type and status
    public function get_csirt_reports_by_status($user_type, $status) {
        $this->db->select('pelaporan_csirt.*, user.nama_lengkap, user.email, user.fakultas, user.prodi, user.keterangan');
        $this->db->from('pelaporan_csirt');
        $this->db->join('user', 'pelaporan_csirt.id_user = user.id_user');
        $this->db->where('user.keterangan', $user_type); // Filter by user type
        $this->db->where('pelaporan_csirt.status', $status);
        $this->db->order_by('pelaporan_csirt.tanggal_pelaporan', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }


    // Get all CSIRT reports for rekapitulasi based on user type
    public function get_all_csirt_reports($user_type) {
        $this->db->select('pelaporan_csirt.*, user.nama_lengkap, user.email, user.fakultas, user.prodi, user.keterangan');
        $this->db->from('pelaporan_csirt');
        $this->db->join('user', 'pelaporan_csirt.id_user = user.id_user');
        $this->db->where('user.keterangan', $user_type); // Filter by user type
        $this->db->order_by('pelaporan_csirt.tanggal_pelaporan', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Update CSIRT report status with an optional rejection reason
    public function update_report_status($report_id, $status, $reason = null) {
        $this->db->where('id', $report_id);
        $update_data = ['status' => $status];

        if ($status == 'Rejected' && $reason) {
            $update_data['alasan_pelaporan_ditolak'] = $reason;
        }

        return $this->db->update('pelaporan_csirt', $update_data);
    }

    // Save the file path for any report-related documents (e.g., evidence files)
    public function save_file_path($report_id, $file_path) {
        $data = ['bukti_file' => $file_path];
        $this->db->where('id', $report_id);
        return $this->db->update('pelaporan_csirt', $data);
    }

    // Get CSIRT reports by date range and status for rekapitulasi or filtering
    public function get_csirt_reports_by_date_range($user_type, $start_date, $end_date, $status = null) {
        $this->db->select('pelaporan_csirt.*, user.nama_lengkap, user.prodi, user.keterangan');
        $this->db->from('pelaporan_csirt');
        $this->db->join('user', 'pelaporan_csirt.id_user = user.id_user');
    
        // Filter by user type
        $this->db->where('user.keterangan', $user_type);
    
        // Filter by status (only if provided)
        if (!empty($status)) {
            $this->db->where('pelaporan_csirt.status', $status);
        }
    
        // Filter by date range
        if (!empty($start_date) && !empty($end_date)) {
            $this->db->where('pelaporan_csirt.tanggal_pelaporan >=', $start_date);
            $this->db->where('pelaporan_csirt.tanggal_pelaporan <=', $end_date);
        }
    
        return $this->db->get()->result_array();
    }

    public function update_keterangan_pelaporan($report_id) {
        $data = array(
            'keterangan_pelaporan' => 'laporan sudah diselesaikan'
        );
    
        $this->db->where('id', $report_id);
        return $this->db->update('pelaporan_csirt', $data); // Ganti 'nama_tabel' dengan nama tabel yang sesuai
    }
}
?>
