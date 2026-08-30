<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
    public function index() {
        $this->load->view('user/templates_user/header');
        $this->load->view('user/templates_user/sidebar');
        $this->load->view('user/data/dashboard_user');
        $this->load->view('user/templates_user/footer');   
    }

    public function pengajuan() {
        $this->load->view('user/templates_user/header');
        $this->load->view('user/templates_user/sidebar');
        $this->load->view('user/data/form_pengajuan');
        $this->load->view('user/templates_user/footer');   
    }

    public function pelaporan_csirt() {
        $this->load->view('user/templates_user/header');
        $this->load->view('user/templates_user/sidebar');
        $this->load->view('user/data/form_pelaporan');
        $this->load->view('user/templates_user/footer');   
    }
    
    public function submit() {
        $keterangan = $this->session->userdata('keterangan');
        $id_user = $this->session->userdata('id_user');
        $email_tujuan = $this->session->userdata('email');
        $alasan_ganti_kartu = htmlspecialchars($this->input->post('alasan_ganti_kartu'), ENT_QUOTES);
    
        $bukti_path = null;
        $bukti_kartu_path = null;
    
        // Cek apakah file bukti pembayaran diunggah (hanya untuk mahasiswa)
        if ($keterangan == 'mahasiswa') {
            if (isset($_FILES['bukti_pembayaran']) && $_FILES['bukti_pembayaran']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = './uploads/' . $id_user . '/';
    
                // Buat folder jika belum ada
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
    
                // Konfigurasi upload
                $config['upload_path'] = $upload_dir;
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['file_name'] = time() . '_pembayaran_' . preg_replace("/[^a-zA-Z0-9.]/", "", $_FILES['bukti_pembayaran']['name']);
                $config['max_size'] = 2048; // Maksimal ukuran 2MB
    
                // Load dan inisialisasi library upload
                $this->load->library('upload', $config);
    
                if ($this->upload->do_upload('bukti_pembayaran')) {
                    $uploadData = $this->upload->data();
                    $bukti_path = 'uploads/' . $id_user . '/' . $uploadData['file_name'];
                } else {
                    $this->session->set_flashdata('error', 'Gagal mengunggah bukti pembayaran: ' . $this->upload->display_errors());
                    redirect('user/pengajuan');
                }
            } else {
                $this->session->set_flashdata('error', 'Bukti pembayaran wajib diunggah.');
                redirect('user/pengajuan');
            }
        }
    
        // Proses upload file bukti kartu
        if (isset($_FILES['bukti_kartu']) && $_FILES['bukti_kartu']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = './uploads/' . $id_user . '/';
    
            // Buat folder jika belum ada
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
    
            // Konfigurasi upload
            $config['upload_path'] = $upload_dir;
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['file_name'] = time() . '_kartu_' . preg_replace("/[^a-zA-Z0-9.]/", "", $_FILES['bukti_kartu']['name']);
            $config['max_size'] = 2048; // Maksimal ukuran 2MB
    
            // Load dan inisialisasi library upload
            $this->load->library('upload', $config);
    
            if ($this->upload->do_upload('bukti_kartu')) {
                $uploadData = $this->upload->data();
                $bukti_kartu_path = 'uploads/' . $id_user . '/' . $uploadData['file_name'];
            } else {
                $this->session->set_flashdata('error', 'Gagal mengunggah bukti kartu: ' . $this->upload->display_errors());
                redirect('user/pengajuan');
            }
        } else {
            $this->session->set_flashdata('error', 'Bukti kartu wajib diunggah.');
            redirect('user/pengajuan');
        }
    
        // Siapkan data untuk penyimpanan ke database
        $data = [
            'alasan_ganti_kartu' => $alasan_ganti_kartu,
            'tanggal_pengajuan' => date('Y-m-d'),
            'status' => 'Pending',
            'keterangan_kartu' => 'sedang diproses',
            'status_pembayaran' => $keterangan == 'mahasiswa' ? 'Belum Bayar' : 'Tidak Diperlukan',
            'id_user' => $id_user,
            'bukti_kartu' => $bukti_kartu_path,
        ];
    
        if ($keterangan == 'mahasiswa') {
            $data['bukti_pembayaran'] = $bukti_path;
            $data['jumlah_pembayaran'] = 40000.00;
        } elseif ($keterangan == 'dosen' || $keterangan == 'tendik') {
            $data['jumlah_pembayaran'] = 0;
        }
    
        // Memanggil fungsi send_email dan meneruskan parameter yang diperlukan
        $this->send_email($data, $bukti_path, $email_tujuan, $bukti_kartu_path);
        $this->load->model('Model_Pengajuan');
        $this->Model_Pengajuan->insert_pengajuan($data);
    
        redirect('user/thank_you');
    }
    
    
    
    /**
     * Fungsi untuk mengirim email dengan data pengajuan dan bukti pembayaran
     */
    private function send_email($data, $attachment_path, $email_tujuan, $bukti_kartu_path = null) {
        // Load library email
        $this->load->library('email');
        $nama_lengkap = $this->session->userdata('nama_lengkap');
        $fakultas = $this->session->userdata('fakultas');
        $prodi = $this->session->userdata('prodi');
    
        // Konfigurasi email
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp.gmail.com'; 
        $config['smtp_user'] = 'rezasabela28@gmail.com'; // Replace with secure email from environment variable or config file
        $config['smtp_pass'] = 'gkur rgtf pjkz hscg'; // Replace with secure password from environment variable or config file
        $config['smtp_port'] = 587;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['smtp_crypto'] = 'tls';
    
        $this->email->initialize($config);
    
        // Set detail email
        $this->email->from('rezasabela28@gmail.com', 'Admin Pengajuan Kartu Akses');
        $this->email->to($email_tujuan);
        $this->email->subject('Pengajuan Kartu Akses Baru');
    
        // Pesan email
        $message = "<h2>Pengajuan Kartu Akses Baru</h2>";
        $message .= "<p><strong>ID User:</strong> {$data['id_user']}</p>";
        $message .= "<p><strong>Nama Lengkap:</strong> {$nama_lengkap}</p>";
        $message .= "<p><strong>Fakultas:</strong> {$fakultas}</p>";
        $message .= "<p><strong>Program Studi:</strong> {$prodi}</p>";
        $message .= "<p><strong>Alasan Ganti Kartu:</strong> {$data['alasan_ganti_kartu']}</p>";
        $message .= "<p><strong>Tanggal Pengajuan:</strong> " . date('d F Y', strtotime($data['tanggal_pengajuan'])) . "</p>";
        $message .= "<p><strong>Status:</strong> {$data['status']} (proses pengecekan)</p>";
        $message .= "<p><strong>Status Pembayaran:</strong> {$data['status_pembayaran']} (proses pengecekan)</p>";
        $message .= "<p><strong>Keterangan:</strong> {$data['keterangan_kartu']}</p>";
        $message .= "<p><strong>Jumlah Pembayaran:</strong> Rp. " . number_format($data['jumlah_pembayaran'], 2) . "</p>";
    
        $this->email->message($message);
    
        // Lampirkan bukti pembayaran jika ada
        if ($attachment_path && file_exists($attachment_path)) {
            $this->email->attach($attachment_path);
        }
    
        // Lampirkan bukti kartu jika ada
        if ($bukti_kartu_path && file_exists($bukti_kartu_path)) {
            $this->email->attach($bukti_kartu_path);
        }
    
        // Kirim email
        if ($this->email->send()) {
            log_message('info', 'Email berhasil dikirim dengan lampiran.');
        } else {
            log_message('error', 'Gagal mengirim email: ' . $this->email->print_debugger());
        }
    }
    
    
    public function thank_you() {
        $this->load->view('user/templates_user/header');
        $this->load->view('user/templates_user/sidebar');
        $this->load->view('user/data/thank_you');
        $this->load->view('user/templates_user/footer');
    }

    public function thank_you_csirt() {
        $this->load->view('user/templates_user/header');
        $this->load->view('user/templates_user/sidebar');
        $this->load->view('user/data/thank_you_csirt');
        $this->load->view('user/templates_user/footer');
    }

    public function status_pengajuan() {
        $id_user = $this->session->userdata('id_user');
        
        // Pastikan id_user tersedia di session
        if (!$id_user) {
            redirect('auth'); // Redirect ke halaman login jika tidak ada id_user
        }

        $data['pengajuan'] = $this->Model_Pengajuan->get_pengajuan_by_user($id_user);
    
        // Load view dengan data pengajuan
        $this->load->view('user/templates_user/header');
        $this->load->view('user/templates_user/sidebar');
        $this->load->view('user/data/status_pengajuan', $data);
        $this->load->view('user/templates_user/footer');
    }

    public function riwayat_pelaporan() {
        $id_user = $this->session->userdata('id_user');
        
        // Ensure id_user is available in session
        if (!$id_user) {
            redirect('auth'); // Redirect to login page if id_user is not found
        }
    
        // Retrieve CSIRT reports for the logged-in user
        $data['riwayat_pelaporan'] = $this->Model_CSIRT->get_csirt_reports_by_user($id_user);

    
        // Load views with the CSIRT report data
        $this->load->view('user/templates_user/header');
        $this->load->view('user/templates_user/sidebar');
        $this->load->view('user/data/riwayat_pelaporan', $data);
        $this->load->view('user/templates_user/footer');
    }
    

    public function submit_csirt() {
        // Retrieve session data
        $id_user = $this->session->userdata('id_user');
        $email_tujuan = $this->session->userdata('email');
        
        // Capture form data
        $nama_website = htmlspecialchars($this->input->post('nama_website'), ENT_QUOTES);
        $deskripsi_masalah = htmlspecialchars($this->input->post('deskripsi_masalah'), ENT_QUOTES);
    
        $bukti_file_path = null;
    
        // Check if evidence file is uploaded
        if (isset($_FILES['bukti_file']) && $_FILES['bukti_file']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = './uploads/csirt/' . $id_user . '/';
    
            // Create directory if it doesn't exist
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
    
            $config['upload_path'] = $upload_dir;
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['file_name'] = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "", $_FILES['bukti_file']['name']);
            $config['max_size'] = 2048; // Max size of 2MB
    
            $this->load->library('upload', $config);
    
            // Process file upload
            if ($this->upload->do_upload('bukti_file')) {
                $uploadData = $this->upload->data();
                $bukti_file_path = 'uploads/csirt/' . $id_user . '/' . $uploadData['file_name'];
            } else {
                $this->session->set_flashdata('error', 'Gagal mengunggah bukti file: ' . $this->upload->display_errors());
                redirect('user/pelaporan_csirt');
            }
        } else {
            $this->session->set_flashdata('error', 'Bukti file wajib diunggah.');
            redirect('user/pelaporan_csirt');
        }
    
        // Prepare data for database insertion
        $data = [
            'nama_website' => $nama_website,
            'deskripsi_masalah' => $deskripsi_masalah,
            'tanggal_pelaporan' => date('Y-m-d'),
            'status' => 'Pending',
            'id_user' => $id_user,
            'keterangan_pelaporan' => 'laporan sedang diproses',

            'bukti_file' => $bukti_file_path,
        ];
    
        // Load model and save data to database
        $this->load->model('Model_CSIRT');
        $this->Model_CSIRT->insert_csirt_report($data);
    
        // Send email with the report details
        $this->send_csirt_email($data, $bukti_file_path, $email_tujuan);
    
        // Redirect to "Thank You" page
        redirect('user/thank_you_csirt');
    }
    
    /**
     * Function to send email with CSIRT report details and evidence
     */
    private function send_csirt_email($data, $bukti_file_path, $email_tujuan) {
        // Load email library
        $this->load->library('email');
        $nama_lengkap = $this->session->userdata('nama_lengkap');
        $fakultas = $this->session->userdata('fakultas');
        $prodi = $this->session->userdata('prodi');
    
        // Email configuration
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp.gmail.com';
        $config['smtp_user'] = 'rezasabela28@gmail.com'; // Use a secure email or from environment variable
        $config['smtp_pass'] = 'gkur rgtf pjkz hscg'; // Use a secure password or from environment variable
        $config['smtp_port'] = 587;
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['smtp_crypto'] = 'tls';
    
        $this->email->initialize($config);
    
        // Set email details
        $this->email->from('rezasabela28@gmail.com', 'Admin Pelaporan CSIRT');
        $this->email->to($email_tujuan);
        $this->email->subject('Pelaporan CSIRT Baru');
    
        // Email message content
        $message = "<h2>Pelaporan CSIRT Baru</h2>";
        $message .= "<p><strong>ID User:</strong> {$data['id_user']}</p>";
        $message .= "<p><strong>Nama Lengkap:</strong> {$nama_lengkap}</p>";
        $message .= "<p><strong>Fakultas:</strong> {$fakultas}</p>";
        $message .= "<p><strong>Program Studi:</strong> {$prodi}</p>";
        $message .= "<p><strong>Nama Website:</strong> {$data['nama_website']}</p>";
        $message .= "<p><strong>Deskripsi Masalah:</strong> {$data['deskripsi_masalah']}</p>";
        $message .= "<p><strong>Tanggal Pelaporan:</strong> " . date('d F Y', strtotime($data['tanggal_pelaporan'])) . "</p>";
        $message .= "<p><strong>Status:</strong> {$data['status']} (proses pengecekan)</p>";
    
        $this->email->message($message);
    
        // Attach evidence file if it exists
        if ($bukti_file_path && file_exists($bukti_file_path)) {
            $this->email->attach($bukti_file_path);
        }
    
        // Send email
        if ($this->email->send()) {
            log_message('info', 'Email berhasil dikirim untuk laporan CSIRT.');
        } else {
            log_message('error', 'Gagal mengirim email untuk laporan CSIRT: ' . $this->email->print_debugger());
        }
    }
    
    
}
