<?php 

class Model_Auth extends CI_Model{

    public function cek_login(){
        $id_user = $this->input->post('id_user');
        $password = $this->input->post('password');
        
        $user = $this->db->where('id_user', $id_user)->get('user')->row();
    
        if ($user && password_verify($password, $user->password)) {
            if ($user->password_changed == 0) {
                return "Password Belum Diubah";
            }
            return $user;
        } elseif ($user && !password_verify($password, $user->password)) {
            return "Password Salah";
        } else {
            return false;
        }
    }

    public function cek_login_admin(){
        $id_user = $this->input->post('id_user');
        $password = $this->input->post('password');
        
        $user = $this->db->where('id_user', $id_user)->get('admin')->row();

        if ($user && password_verify($password, $user->password)) {
            return $user;
        } elseif ($user && !password_verify($password, $user->password)) {
            return "Password Salah";
        } else {
            return false;
        }
    }
    
    public function getUsernameFromSession() {
        $id_user = $this->session->userdata('id_user');
        $user = $this->db->where('id_user', $id_user)->get('user')->row();

        if ($user) {
            return $user->nama;
        } else {
            return "Pengguna tidak ditemukan";
        }
    }

    public function getUsernameFromSession_admin() {
        $id_user = $this->session->userdata('id_user');
        $user = $this->db->where('id_user', $id_user)->get('admin')->row();

        if ($user) {
            return $user->nama;
        } else {
            return "Pengguna tidak ditemukan";
        }
    }

    public function update_password($id_user, $new_password) {
        $this->db->set('password', $new_password)
                 ->set('password_changed', 1)
                 ->where('id_user', $id_user)
                 ->update('user');
    }
    

    
    

}
