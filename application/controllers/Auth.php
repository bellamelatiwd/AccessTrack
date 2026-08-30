<?php 
class Auth extends CI_Controller{

    public function index() {
        $this->form_validation->set_rules('id_user', 'ID User', 'required', ['required' => 'ID User wajib diisi']);
        $this->form_validation->set_rules('password', 'Password', 'required', ['required' => 'Password wajib diisi']);
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('user/templates_user/header');
            $this->load->view('user/data/login');
        } else {
            $auth = $this->Model_Auth->cek_login();
    
            if ($auth == FALSE) {
                $this->handleLoginError();
            } elseif($auth == "Password Salah") {
                $this->handlepasswordsalah();
            } elseif ($auth == "Password Belum Diubah") {
                // Redirect to change password page if this is the first login or after reset
                $this->session->set_userdata('id_user', $this->input->post('id_user'));
                redirect('auth/change_password');
            } else {
                $this->handleLoginSuccess($auth, "User");
            }
        }
    }
    

    public function admin(){
        $this->form_validation->set_rules('id_user', 'ID User', 'required', ['required' => 'ID User wajib diisi']);
        $this->form_validation->set_rules('password', 'Password', 'required', ['required' => 'Password wajib diisi']);
       
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/templates_admin/header');
            $this->load->view('admin/data/login_admin');
        } else {
            $auth = $this->Model_Auth->cek_login_admin();
            if ($auth == FALSE) {
                $this->handleLoginError_admin();
            } elseif($auth == "Password Salah"){
                $this->handlepasswordsalah_admin();
            } else {
                $this->handleLoginSuccess($auth, "Admin");
            }
        }
    }

    
    private function handlepasswordsalah() {
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Username atau Password Anda Salah!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #fff;">
                <span aria-hidden="true">&times;</span>
            </button> </div>');
        redirect('Auth');
    }

    private function handleLoginError() {
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            User Tidak Terdaftar!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #fff;">
                <span aria-hidden="true">&times;</span>
            </button> </div>');
        redirect('Auth');
    }

    private function handlepasswordsalah_admin() {
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Username atau Password Anda Salah!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #fff;">
                <span aria-hidden="true">&times;</span>
            </button> </div>');
        redirect('Auth/admin');
    }    

    private function handleLoginError_admin() {
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            User Tidak Terdaftar!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #fff;">
                <span aria-hidden="true">&times;</span>
            </button> </div>');
        redirect('Auth/admin');
    }

    private function handleLoginSuccess($auth, $role) {
        $this->session->set_userdata('id_user', $auth->id_user);
        $this->session->set_userdata('id_role', $auth->id_role);
        $this->session->set_userdata('keterangan', $auth->keterangan);
        $this->session->set_userdata('nama_lengkap', $auth->nama_lengkap);
        $this->session->set_userdata('fakultas', $auth->fakultas);
        $this->session->set_userdata('prodi', $auth->prodi);

        $this->session->set_userdata('email', $auth->email);

        if($role == "User"){
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Anda Berhasil Login!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #fff;">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
            redirect('user/index');
        } elseif ($role == "Admin") {
            
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Anda Berhasil Login!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #fff;">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>');
            redirect('Admin/Persetujuan');
        
        }
        
    }

    private function handleInactiveAccount() {
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Akun Anda Dinonaktifkan, Silahkan Hubungi Admin!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #fff;">
                <span aria-hidden="true">&times;</span>
            </button> </div>');
        redirect('Auth');
    }


    public function logout(){
        $this->session->sess_destroy();
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Anda Berhasil Logout
          <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #fff;">
            <span aria-hidden="true">&times;</span>
          </button> </div>');
        redirect('Auth');
    }

    private function handleInactiveAccount_admin() {
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Akun Anda Dinonaktifkan, Silahkan Hubungi Admin!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #fff;">
                <span aria-hidden="true">&times;</span>
            </button> </div>');
        redirect('Auth/admin');
    }


    public function logout_admin(){
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Anda Berhasil Logout
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #fff;">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>');
        $this->session->sess_destroy();
        redirect('Auth/admin');
    }

    public function change_password(){
        $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');
    
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('user/templates_user/header');

            $this->load->view('user/data/change_password');
        } else {
            $id_user = $this->session->userdata('id_user');
            $new_password = password_hash($this->input->post('new_password'), PASSWORD_DEFAULT);
            $this->Model_Auth->update_password($id_user, $new_password);
            
            $this->session->set_flashdata('pesan', '<div class="alert alert-success">Password Berhasil Diubah</div>');
            redirect('auth');
        }
    }
    
    

    
    

}