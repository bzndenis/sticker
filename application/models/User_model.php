<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_user_by_email($email) {
        return $this->db->where('email', $email)
                       ->get('users')
                       ->row();
    }
    
    public function login($username, $password) {
        $user = $this->db->where('username', $username)
                        ->get('users')
                        ->row();
        
        if($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }
    
    public function register($data) {
        return $this->db->insert('users', $data);
    }
    
    public function get_user($id) {
        return $this->db->where('id', $id)
                       ->get('users')
                       ->row();
    }
    
    public function update_user($id, $data) {
        return $this->db->where('id', $id)
                       ->update('users', $data);
    }
    
    public function delete_user($id) {
        return $this->db->where('id', $id)
                       ->delete('users');
    }
    
    public function count_user_stickers($user_id) {
        return $this->db->where('user_id', $user_id)
                       ->count_all_results('user_stickers');
    }
    
    public function update_last_login($user_id) {
        return $this->db->where('id', $user_id)
                       ->update('users', [
                           'last_login' => date('Y-m-d H:i:s')
                       ]);
    }
} 