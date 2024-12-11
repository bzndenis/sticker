<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function check_login($username, $password) {
        $this->db->where('username', $username);
        $user = $this->db->get('users')->row();
        
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }

    public function register($data) {
        return $this->db->insert('users', $data);
    }

    public function get_user_detail($user_id) {
        return $this->db->get_where('users', ['id' => $user_id])->row();
    }

    public function update_user($user_id, $data) {
        return $this->db->where('id', $user_id)->update('users', $data);
    }

    public function get_notification_settings($user_id) {
        $settings = $this->db->get_where('notification_settings', ['user_id' => $user_id])->row();
        
        if (!$settings) {
            // Jika belum ada settings, buat default sesuai struktur tabel
            $default_settings = [
                'user_id' => $user_id,
                'trade_notification' => 1,
                'chat_notification' => 1, 
                'email_notification' => 1
            ];
            $this->db->insert('notification_settings', $default_settings);
            return (object) $default_settings;
        }
        
        return $settings;
    }

    public function update_notification_settings($user_id, $data) {
        $exists = $this->db->get_where('notification_settings', ['user_id' => $user_id])->row();
        
        if ($exists) {
            return $this->db->where('user_id', $user_id)->update('notification_settings', $data);
        } else {
            $data['user_id'] = $user_id;
            return $this->db->insert('notification_settings', $data);
        }
    }
} 