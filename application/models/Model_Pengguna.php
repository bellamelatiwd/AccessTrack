<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_Pengguna extends CI_Model
{
    public function getUsersByCategory($category)
    {
        $this->db->where('keterangan', $category);
        return $this->db->get('user')->result();
    }
    
    public function insertUser($data)
    {
        return $this->db->insert('user', $data);
    }

    public function update_password($id_user, $hashed_password, $password_changed) {
        $data = [
            'password' => $hashed_password,
            'password_changed' => $password_changed // Set to 0 to prompt password change
        ];
        $this->db->where('id_user', $id_user);
        $this->db->update('user', $data);
    }
    

    public function delete_user($id_user) {
        $this->db->where('id_user', $id_user);
        return $this->db->delete('user'); // Assuming 'users' is your table name
    }
    
    public function get_user_by_id($id_user) {
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('user'); // Assuming your table name is 'users'
    
        // Check if a result was found, return the user data, otherwise return null
        if ($query->num_rows() > 0) {
            return $query->row(); // Returns a single row as an object
        }
        return null; // No user found with that id
    }

    public function getUserByEmail($email) {
        $this->db->where('email', $email);
        return $this->db->get('user')->row();
    }

    public function getUserById($id_user) {
        $this->db->where('id_user', $id_user);
        return $this->db->get('user')->row();
    }
    
    
    

}
