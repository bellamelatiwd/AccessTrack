<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require "vendor/autoload.php";
use Dompdf\Dompdf;
use Dompdf\Options;

class Admin extends CI_Controller {
    
    public function index() {
        $this->load->view('admin/templates_admin/header');
        $this->load->view('admin/templates_admin/sidebar');
        
        $data['count_approve'] = $this->Model_Pengajuan->count_pengajuan_by_status('Approved');
        $data['count_pending'] = $this->Model_Pengajuan->count_pengajuan_by_status('Pending');
        $data['count_rejected'] = $this->Model_Pengajuan->count_pengajuan_by_status('Rejected');  
        $this->load->view('admin/data/dashboard_admin', $data);
        $this->load->view('admin/templates_admin/footer');   
    }

    public function persetujuan() {
        $data['title'] = 'Menu Persetujuan';
    
        $data['pengajuan_mahasiswa'] = $this->Model_Pengajuan->get_pengajuan_by_type('mahasiswa', 'Pending');
        $data['pengajuan_dosen'] = $this->Model_Pengajuan->get_pengajuan_by_type('dosen', 'Pending');
        $data['pengajuan_tendik'] = $this->Model_Pengajuan->get_pengajuan_by_type('tendik', 'Pending');
    
        $this->load->view('admin/templates_admin/header');
        $this->load->view('admin/templates_admin/sidebar');
        $this->load->view('admin/data/persetujuan', $data);
        $this->load->view('admin/templates_admin/footer');
    }

    public function Data_Rekapitulasi() {
        $data['title'] = 'Menu Rekapitulasi';
        $data['tab'] = $this->input->get('tab') ?? 'mahasiswa';
    
        $data['pengajuan_mahasiswa'] = $this->Model_Pengajuan->get_pengajuan('mahasiswa');
        $data['pengajuan_dosen'] = $this->Model_Pengajuan->get_pengajuan('dosen');
        $data['pengajuan_tendik'] = $this->Model_Pengajuan->get_pengajuan('tendik');
    
        $this->load->view('admin/templates_admin/header');
        $this->load->view('admin/templates_admin/sidebar');
        $this->load->view('admin/data/rekapitulasi', $data);
        $this->load->view('admin/templates_admin/footer');
    }

    public function approved($id_ka) {
        $status = 'Approved';
        
        if ($this->Model_Pengajuan->update_status($id_ka, $status)) {
            $data['pengajuan'] = $this->Model_Pengajuan->get_pengajuan_by_id($id_ka);
            $html = $this->load->view('admin/data/kwitansi_template', $data, TRUE);

            $options = new Options();
            $options->set('isRemoteEnabled', TRUE);
            $dompdf = new Dompdf($options);

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $user_id = $data['pengajuan']->user_id;
            $pdf_path = 'assets/' . $user_id . '/kwitansi/';
            $full_pdf_path = FCPATH . $pdf_path;
            if (!is_dir($full_pdf_path)) {
                mkdir($full_pdf_path, 0755, TRUE);
            }

            $file_name = 'kwitansi_' . $id_ka . '.pdf';
            file_put_contents($full_pdf_path . $file_name, $dompdf->output());
            
            $this->Model_Pengajuan->save_pdf_path($id_ka, $pdf_path . $file_name);

            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'smtp.gmail.com'; 
            $config['smtp_user'] = 'rezasabela28@gmail.com';
            $config['smtp_pass'] = 'gkur rgtf pjkz hscg';
            $config['smtp_port'] = 587;
            $config['mailtype'] = 'html';
            $config['charset'] = 'utf-8';
            $config['newline'] = "\r\n";
            $config['smtp_crypto'] = 'tls';
        
            $this->email->initialize($config);
    
            $this->email->from('rezasabela28@gmail.com', 'Admin Pengajuan Kartu Akses');
            $this->email->to($data['pengajuan']->email);
            $this->email->subject('Kwitansi Pengajuan Anda');
            $this->email->message('Berikut terlampir kwitansi pengajuan Anda yang telah disetujui.');
            $this->email->attach($full_pdf_path . $file_name);

            if ($this->email->send()) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Pengajuan berhasil disetujui dan kwitansi telah dikirim ke email pengguna.</div>');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-warning" role="alert">Pengajuan berhasil disetujui tetapi gagal mengirim kwitansi ke email.</div>');
            }
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Terjadi kesalahan saat menyetujui pengajuan.</div>');
        }
        
        redirect('admin/Data_Rekapitulasi');
    }
    
    public function rejected($id_ka) {
        $status = 'Rejected';
        $alasan_ditolak = $this->input->post('alasan_ditolak');
    
        if (empty($alasan_ditolak)) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning" role="alert">Alasan penolakan harus diisi.</div>');
            redirect('admin/persetujuan');
        }
    
        if ($this->Model_Pengajuan->update_status($id_ka, $status, $alasan_ditolak)) {
            $data['pengajuan'] = $this->Model_Pengajuan->get_pengajuan_by_id($id_ka);

            $data['keterangan_kartu'] = $this->Model_Pengajuan->update_keterangan_kartu($id_ka);
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'smtp.gmail.com'; 
            $config['smtp_user'] = 'rezasabela28@gmail.com';
            $config['smtp_pass'] = 'gkur rgtf pjkz hscg';
            $config['smtp_port'] = 587;
            $config['mailtype'] = 'html';
            $config['charset'] = 'utf-8';
            $config['newline'] = "\r\n";
            $config['smtp_crypto'] = 'tls';
    
            $this->email->initialize($config);
    
            $this->email->from('rezasabela28@gmail.com', 'Admin Pengajuan Kartu Akses');
            $this->email->to($data['pengajuan']->email);
            $this->email->subject('Pengajuan Anda Ditolak');
            $this->email->message('Pengajuan Anda telah ditolak dengan alasan: ' . $alasan_ditolak);

            if ($this->Model_Pengajuan->update_keterangan_kartu($id_ka)) {
                log_message('info', 'Keterangan kartu berhasil diperbarui menjadi Selesai Diproses untuk id_ka: ' . $id_ka);
            } else {
                log_message('error', 'Gagal memperbarui keterangan kartu untuk id_ka: ' . $id_ka);
            }
            
            if ($this->email->send()) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Pengajuan berhasil ditolak dan alasan penolakan telah dikirim ke email pengguna.</div>');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-warning" role="alert">Pengajuan berhasil ditolak tetapi gagal mengirim alasan penolakan ke email.</div>');
            }
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Terjadi kesalahan saat menolak pengajuan.</div>');
        }
        
        redirect('admin/Data_Rekapitulasi');
    }
    

    public function kartu_bisa_diambil($id_ka) {
        $data['pengajuan'] = $this->Model_Pengajuan->get_pengajuan_by_id($id_ka);

        if ($this->Model_Pengajuan->update_keterangan($id_ka)) {
            // Configure email settings
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'smtp.gmail.com';
            $config['smtp_user'] = 'rezasabela28@gmail.com';
            $config['smtp_pass'] = 'gkur rgtf pjkz hscg';
            $config['smtp_port'] = 587;
            $config['mailtype'] = 'html';
            $config['charset'] = 'utf-8';
            $config['newline'] = "\r\n";
            $config['smtp_crypto'] = 'tls';

            $this->email->initialize($config);

            // Send notification email
            $this->email->from('rezasabela28@gmail.com', 'Admin Pengajuan Kartu Akses');
            $this->email->to($data['pengajuan']->email);
            $this->email->subject('Kartu Akses Bisa Diambil');
            $this->email->message('Pengajuan Anda telah disetujui. Silakan mengambil kartu akses Anda di tempat yang telah ditentukan.');

            if ($this->email->send()) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Pengajuan berhasil disetujui dan notifikasi email telah dikirim ke pengguna.</div>');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-warning" role="alert">Pengajuan berhasil disetujui tetapi gagal mengirim notifikasi email ke pengguna.</div>');
            }
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Terjadi kesalahan saat menyetujui pengajuan.</div>');
        }
        
        redirect('admin/Data_Rekapitulasi');
    }
    public function akun_data_user(){
        $data['pengguna_mahasiswa'] = $this->Model_Pengguna->getUsersByCategory('mahasiswa');
        $data['pengguna_dosen'] = $this->Model_Pengguna->getUsersByCategory('dosen');
        $data['pengguna_tendik'] = $this->Model_Pengguna->getUsersByCategory('tendik');

        $this->load->view('admin/templates_admin/header');
        $this->load->view('admin/templates_admin/sidebar', $data); 
        $this->load->view('admin/data/data_user', $data);
        $this->load->view('admin/templates_admin/footer');
    }

    public function reset_password($id_user) {
        $user = $this->Model_Pengguna->get_user_by_id($id_user);
    
        if ($user) {
            $new_password = $user->id_user; // Set the new password to the user ID
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); // Hash the new password
    
            // Update the password and reset password_changed to 0
            $this->Model_Pengguna->update_password($id_user, $hashed_password, 0); 
    
            $this->session->set_flashdata('pesan', '<div class="alert alert-success">Reset kata sandi berhasil. Kata sandi default adalah NIM/NID/NIP.</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Pengguna tidak ditemukan.</div>');
        }
    
        redirect('admin/akun_data_user');
    }
    
    
    public function hapus_user($id_user) {
        if ($this->Model_Pengguna->delete_user($id_user)) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success">Pengguna berhasil dihapus.</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Gagal menghapus pengguna. Pengguna mungkin tidak ada.</div>');
        }
    
        redirect('admin/akun_data_user');
    }
    
    public function tambah() {
        // Periksa apakah email sudah ada
        $email = $this->input->post('email');
        $existingUserByEmail = $this->Model_Pengguna->getUserByEmail($email);
        
        if ($existingUserByEmail) {
            // Email sudah ada, tampilkan pesan error
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning">Email sudah terdaftar. Silakan gunakan email lain.</div>');
            redirect('admin/akun_data_user');
            return;
        }
        
        // Periksa apakah id_user sudah ada
        $id_user = $this->input->post('id_user');
        $existingUserById = $this->Model_Pengguna->getUserById($id_user);
        
        if ($existingUserById) {
            // ID User sudah ada, tampilkan pesan error
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning">ID User sudah terdaftar. Silakan gunakan ID User lain.</div>');
            redirect('admin/akun_data_user');
            return;
        }
    
        // Lanjutkan menambah user baru jika email dan id_user unik
        $data = [
            'id_user' => $id_user,
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'fakultas' => $this->input->post('fakultas'),
            'prodi' => $this->input->post('prodi'),
            'email' => $email,
            'keterangan' => $this->input->post('keterangan'), 
            'password' => password_hash($this->input->post('id_user'), PASSWORD_BCRYPT),
        ];
    
        $this->Model_Pengguna->insertUser($data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success">User berhasil ditambahkan</div>');
        redirect('admin/akun_data_user');
    }
    
    public function export_pdf_csirt() {
        $start_date = $this->input->get('start_date'); // Get start date from GET input
        $end_date = $this->input->get('end_date'); // Get end date from GET input
    
        // Check if dates are valid
        if (empty($start_date) || empty($end_date)) {
            show_error('Tanggal mulai dan akhir diperlukan untuk melakukan ekspor.');
        }
    
        $data = [];
    
        // Fetch approved and rejected data
        $approved_data = $this->Model_CSIRT->get_csirt_reports_by_date_range('tendik', $start_date, $end_date, 'approved');
        $rejected_data = $this->Model_CSIRT->get_csirt_reports_by_date_range('tendik', $start_date, $end_date, 'rejected');
        
        if (empty($approved_data) && empty($rejected_data)) {
            show_error('Tidak ada data yang dapat diekspor untuk rentang tanggal tersebut.');
        }
    
        $data['pengajuan'] = array_merge($approved_data, $rejected_data);
        $data['keterangan'] = 'tendik';
    
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
    
        // Load the view as HTML
        $html = $this->load->view('admin/data/csirt_pdf_template', $data, true);
    
        // Configure and generate PDF using Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        // Set filename
        $default_filename = 'Rekap_Pelaporan_' . $data['keterangan'] . '' . $start_date . '_to' . $end_date . '.pdf';
    
        // Stream file to browser
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $default_filename . '"');
        echo $dompdf->output();
    }

    

    public function export_pdf() {
        $tab = $this->input->get('tab'); // Mengambil parameter 'tab' dari input GET
        $start_date = $this->input->get('start_date'); // Mengambil tanggal mulai dari input GET
        $end_date = $this->input->get('end_date'); // Mengambil tanggal akhir dari input GET
    
        // Menentukan status berdasarkan judul halaman yang sedang diakses
        $status = '';
        if ($this->input->get('title') === 'Menu Approved') {
            $status = 'approved'; // Jika judul halaman adalah "Menu Approved", set status ke "Approved"
        } elseif ($this->input->get('title') === 'Menu Rejected') {
            $status = 'rejected'; // Jika judul halaman adalah "Menu Rejected", set status ke "Rejected"
        } else {
            show_error("Status diperlukan untuk ekspor ini.", 400); // Jika tidak sesuai, tampilkan error
        }
    
        $data = [];
        // Menentukan data berdasarkan kategori tab yang dipilih
        if ($tab == 'mahasiswa') {
            $data['pengajuan'] = $this->Model_Pengajuan->get_pengajuan_by_tab_and_date_range('mahasiswa', $start_date, $end_date, $status);
            $data['keterangan'] = 'mahasiswa'; // Mengatur keterangan untuk kategori Mahasiswa
        } elseif ($tab == 'dosen') {
            $data['pengajuan'] = $this->Model_Pengajuan->get_pengajuan_by_tab_and_date_range('dosen', $start_date, $end_date, $status);
            $data['keterangan'] = 'dosen'; // Mengatur keterangan untuk kategori Dosen
        } elseif ($tab == 'tendik') {
            $data['pengajuan'] = $this->Model_Pengajuan->get_pengajuan_by_tab_and_date_range('tendik', $start_date, $end_date, $status);
            $data['keterangan'] = 'tendik'; // Mengatur keterangan untuk kategori Tendik
        } else {
            show_error("Tab yang dipilih tidak valid.", 400); // Tampilkan error jika tab tidak valid
        }
    
        $data['start_date'] = $start_date; // Menyimpan tanggal mulai untuk ditampilkan di view
        $data['end_date'] = $end_date; // Menyimpan tanggal akhir untuk ditampilkan di view
    
        // Memuat file view menjadi HTML
        $html = $this->load->view('admin/data/pdf_template', $data, true);
    
        // Konfigurasi dan pembuatan PDF menggunakan Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html); // Memuat HTML yang sudah dirender
        $dompdf->setPaper('A4', 'portrait'); // Mengatur ukuran dan orientasi kertas
        $dompdf->render();
    

        // Stream PDF ke browser
        $dompdf->stream(array("Attachment" => 0));
    }
    
    public function export_pdf_rekap() {
        $tab = $this->input->get('tab'); // Get 'tab' parameter from GET input
        $start_date = $this->input->get('start_date'); // Get start date from GET input
        $end_date = $this->input->get('end_date'); // Get end date from GET input
    
        $data = [];
    
        // Determine data based on selected category tab
        if ($tab == 'mahasiswa') {
            $approved_data = $this->Model_Pengajuan->get_pengajuan_by_tab_and_date_range('mahasiswa', $start_date, $end_date, 'approved');
            $rejected_data = $this->Model_Pengajuan->get_pengajuan_by_tab_and_date_range('mahasiswa', $start_date, $end_date, 'rejected');
            $data['pengajuan'] = array_merge($approved_data, $rejected_data);
            $data['keterangan'] = 'mahasiswa';
        } elseif ($tab == 'dosen') {
            $approved_data = $this->Model_Pengajuan->get_pengajuan_by_tab_and_date_range('dosen', $start_date, $end_date, 'approved');
            $rejected_data = $this->Model_Pengajuan->get_pengajuan_by_tab_and_date_range('dosen', $start_date, $end_date, 'rejected');
            $data['pengajuan'] = array_merge($approved_data, $rejected_data);
            $data['keterangan'] = 'dosen';
        } elseif ($tab == 'tendik') {
            $approved_data = $this->Model_Pengajuan->get_pengajuan_by_tab_and_date_range('tendik', $start_date, $end_date, 'approved');
            $rejected_data = $this->Model_Pengajuan->get_pengajuan_by_tab_and_date_range('tendik', $start_date, $end_date, 'rejected');
            $data['pengajuan'] = array_merge($approved_data, $rejected_data);
            $data['keterangan'] = 'tendik';
        } else {
            show_error("Tab yang dipilih tidak valid.", 400); // Show error if tab is invalid
        }
    
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
    
        // Load the view as HTML
        $html = $this->load->view('admin/data/pdf_template', $data, true);
    
        // Configure and generate PDF using Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        // Tentukan nama file default berdasarkan data atau format yang diinginkan
        $default_filename = 'Rekap_Pengajuan_' . $data['keterangan'] . '_' . $start_date . '_to_' . $end_date . '.pdf';
    
        // Kirimkan header agar file di-stream ke browser tanpa langsung diunduh
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $default_filename . '"');
        echo $dompdf->output();
    }
    
    
    public function persetujuan_csirt() {
        $data['title'] = 'Persetujuan Pelaporan CSIRT';
        $data['csirt_reports'] = $this->Model_CSIRT->get_csirt_reports_by_status('tendik', 'Pending');
    
        $this->load->view('admin/templates_admin/header');
        $this->load->view('admin/templates_admin/sidebar');
        $this->load->view('admin/data/persetujuan_csirt', $data);
        $this->load->view('admin/templates_admin/footer');
    }

    public function data_approved_csirt() {
        $data['title'] = 'Data Approved CSIRT';
        $data['csirt_reports'] = $this->Model_CSIRT->get_csirt_reports_by_status('tendik', 'Approved');
    
        $this->load->view('admin/templates_admin/header');
        $this->load->view('admin/templates_admin/sidebar');
        $this->load->view('admin/data/approved_csirt', $data);
        $this->load->view('admin/templates_admin/footer');
    }

    public function data_rejected_csirt() {
        $data['title'] = 'Data Rejected CSIRT';
        $data['csirt_reports'] = $this->Model_CSIRT->get_csirt_reports_by_status('tendik', 'Rejected');
        
        $this->load->view('admin/templates_admin/header');
        $this->load->view('admin/templates_admin/sidebar');
        $this->load->view('admin/data/approved_csirt', $data);
        $this->load->view('admin/templates_admin/footer');
    }

    public function data_rekapitulasi_csirt() {
        $data['title'] = 'Rekapitulasi Pelaporan CSIRT';
        $data['csirt_reports'] = $this->Model_CSIRT->get_all_csirt_reports('tendik');
    
        $this->load->view('admin/templates_admin/header');
        $this->load->view('admin/templates_admin/sidebar');
        $this->load->view('admin/data/rekapitulasi_csirt', $data);
        $this->load->view('admin/templates_admin/footer');
    }

    public function approve_csirt($report_id) {
        $status = 'Approved';
        $data['keterangan_pelaporan'] = $this->Model_Pengajuan->update_keterangan_kartu($report_id);
        if ($this->Model_CSIRT->update_report_status($report_id, $status)) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success">Pelaporan CSIRT berhasil disetujui.</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Terjadi kesalahan saat menyetujui pelaporan CSIRT.</div>');
        }
        if ($this->Model_CSIRT->update_keterangan_pelaporan($report_id)) {
            log_message('info', 'Keterangan pelaporan berhasil diperbarui menjadi Selesai Diproses untuk id_ka: ' . $report_id);
        } else {
            log_message('error', 'Gagal memperbarui keterangan pelaporan untuk id_ka: ' . $report_id);
        }
        

        redirect('admin/data_approved_csirt');
    }
    
    public function reject_csirt($report_id) {
        $status = 'Rejected';
        $reason = $this->input->post('alasan_ditolak');
    
        if (empty($reason)) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning">Alasan penolakan harus diisi.</div>');
            redirect('admin/persetujuan_csirt');
        }
    
        if ($this->Model_CSIRT->update_report_status($report_id, $status, $reason)) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Pelaporan CSIRT berhasil ditolak dengan alasan yang diberikan.</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Terjadi kesalahan saat menolak pelaporan CSIRT.</div>');
        }

        if ($this->Model_CSIRT->update_keterangan_pelaporan($report_id)) {
            log_message('info', 'Keterangan pelaporan berhasil diperbarui menjadi Selesai Diproses untuk id_ka: ' . $report_id);
        } else {
            log_message('error', 'Gagal memperbarui keterangan pelaporan untuk id_ka: ' . $report_id);
        }
        redirect('admin/data_rejected_csirt');
    }
    
    
}
