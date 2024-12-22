<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->check_login();
    }
    
    public function index() {
        $user_id = $this->session->userdata('user_id');
        
        // Get user data
        $data['user'] = $this->user_model->get_user($user_id);
        
        // Get collection progress
        $collections = $this->sticker_model->get_collections_with_progress($user_id);
        
        // Calculate progress for each collection
        foreach($collections as &$collection) {
            $collection->total = $this->sticker_model->get_total_stickers($collection->id);
            $collection->owned = $this->sticker_model->count_owned_stickers($user_id, $collection->id);
            $collection->progress = $collection->total > 0 ? 
                round(($collection->owned / $collection->total) * 100, 1) : 0;
        }
        
        $data['collections'] = $collections;
        
        // Get statistics
        $data['total_stickers'] = $this->user_model->count_user_stickers($user_id);
        $data['total_trades'] = $this->trade_model->count_user_trades($user_id);
        
        $this->load->view('profile/index', $data);
    }
    
    public function edit() {
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->user_model->get_user($user_id);
        
        $this->form_validation->set_rules('username', 'Username', 'required|callback_check_unique_username['.$user_id.']');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_check_unique_email['.$user_id.']');
        
        if($this->input->post('password')) {
            $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'matches[password]');
        }
        
        if($this->form_validation->run() === FALSE) {
            $this->load->view('profile/edit', $data);
            return;
        }
        
        $user_data = array(
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email')
        );
        
        if($this->input->post('password')) {
            $user_data['password'] = $this->input->post('password');
        }
        
        if($this->user_model->update_user($user_id, $user_data)) {
            $this->session->set_flashdata('success', 'Profil berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui profil');
        }
        
        redirect('profile');
    }
    
    public function check_unique_username($username, $user_id) {
        $existing = $this->db->where('username', $username)
                            ->where('id !=', $user_id)
                            ->get('users')
                            ->row();
                            
        if($existing) {
            $this->form_validation->set_message('check_unique_username', 'Username sudah digunakan');
            return FALSE;
        }
        return TRUE;
    }
    
    public function check_unique_email($email, $user_id) {
        $existing = $this->db->where('email', $email)
                            ->where('id !=', $user_id)
                            ->get('users')
                            ->row();
                            
        if($existing) {
            $this->form_validation->set_message('check_unique_email', 'Email sudah digunakan');
            return FALSE;
        }
        return TRUE;
    }
} 