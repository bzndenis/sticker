<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        $this->load->model(['user_model', 'trade_model', 'collection_model']);
        $this->load->library(['form_validation']);
    }

    public function index($username = null) {
        if ($username === null) {
            $user_id = $this->session->userdata('user_id');
        } else {
            $user = $this->user_model->get_user_by_username($username);
            if (!$user) {
                show_404();
            }
            $user_id = $user->id;
        }

        // Get user data
        $data['user'] = $this->user_model->get_user($user_id);
        
        // Set default avatar jika tidak ada
        $data['user']->avatar = isset($data['user']->avatar) ? $data['user']->avatar : 'default.jpg';
        
        // Get stats
        $data['stats'] = (object)[
            'total_stickers' => $this->user_model->count_user_stickers($user_id),
            'total_trades' => $this->trade_model->count_user_trades($user_id),
            'completion_rate' => $this->trade_model->get_completion_rate($user_id)
        ];
        
        // Get collections progress
        $data['collections'] = $this->collection_model->get_user_collections_progress($user_id);
        
        // Get recent activities (opsional)
        $data['activities'] = []; // Kosongkan dulu atau tambahkan jika sudah ada model activity
        
        $this->load->view('profile/index', $data);
    }

    public function edit() {
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->user_model->get_user($user_id);

        // Set rules validasi
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|max_length[20]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        
        // Tambahkan validasi untuk username dan email unik kecuali untuk user saat ini
        $this->form_validation->set_rules(
            'username', 
            'Username',
            'required|min_length[4]|max_length[20]|callback_check_unique_username['.$user_id.']'
        );
        $this->form_validation->set_rules(
            'email', 
            'Email',
            'required|valid_email|callback_check_unique_email['.$user_id.']'
        );
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('profile/edit', $data);
            return;
        }

        // Handle upload avatar jika ada
        $avatar = $data['user']->avatar; // Default ke avatar yang sudah ada
        if (!empty($_FILES['avatar']['name'])) {
            $config['upload_path'] = './uploads/avatars/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
            $config['file_name'] = 'avatar_' . $user_id . '_' . time();

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('avatar')) {
                $upload_data = $this->upload->data();
                $avatar = $upload_data['file_name'];
                
                // Hapus avatar lama jika bukan default.jpg
                if ($data['user']->avatar != 'default.jpg' && file_exists('./uploads/avatars/' . $data['user']->avatar)) {
                    unlink('./uploads/avatars/' . $data['user']->avatar);
                }
            }
        }

        // Update data user
        $update_data = [
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'avatar' => $avatar
        ];

        if ($this->user_model->update_user($user_id, $update_data)) {
            $this->session->set_flashdata('success', 'Profil berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui profil');
        }

        redirect('profile');
    }

    // Tambahkan method callback untuk validasi
    public function check_unique_username($username, $user_id) {
        $existing = $this->user_model->get_user_by_username_except($username, $user_id);
        if ($existing) {
            $this->form_validation->set_message('check_unique_username', 'Username sudah digunakan');
            return FALSE;
        }
        return TRUE;
    }

    public function check_unique_email($email, $user_id) {
        $existing = $this->user_model->get_user_by_email_except($email, $user_id);
        if ($existing) {
            $this->form_validation->set_message('check_unique_email', 'Email sudah digunakan');
            return FALSE;
        }
        return TRUE;
    }
} 