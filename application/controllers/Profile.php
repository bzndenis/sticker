<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['user_model', 'sticker_model', 'trade_model']);
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'trade']);
        
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        
        // Ambil data user dan pengaturan notifikasi
        $this->db->select('users.*, notification_settings.trade_notification, notification_settings.chat_notification, notification_settings.email_notification');
        $this->db->from('users');
        $this->db->join('notification_settings', 'users.id = notification_settings.user_id', 'left');
        $this->db->where('users.id', $user_id);
        $user = $this->db->get()->row();
        
        // Ambil data statistik
        $stats = $this->get_user_stats($user_id);
        
        $data['user'] = $user;
        $data['stats'] = $stats;
        
        $this->load->view('templates/header', $data);
        $this->load->view('profile/index', $data);
        $this->load->view('templates/footer');
    }

    private function get_user_stats($user_id) {
        // Contoh pengambilan data statistik
        $this->db->select('COUNT(*) as total_owned');
        $this->db->from('user_stickers');
        $this->db->where('user_id', $user_id);
        $total_owned = $this->db->get()->row()->total_owned;

        $this->db->select('COUNT(*) as total_trades');
        $this->db->from('trade_requests');
        $this->db->where('requester_id', $user_id);
        $total_trades = $this->db->get()->row()->total_trades;

        $this->db->select('COUNT(*) as success_trades');
        $this->db->from('trade_requests');
        $this->db->where('requester_id', $user_id);
        $this->db->where('status', 'accepted');
        $success_trades = $this->db->get()->row()->success_trades;

        return [
            'total_owned' => $total_owned,
            'total_trades' => $total_trades,
            'success_trades' => $success_trades
        ];
    }

    public function settings() {
        $user_id = $this->session->userdata('user_id');
        
        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[4]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
                $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'matches[password]');
            }
            
            if ($this->form_validation->run()) {
                $update_data = [
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                    'whatsapp' => $this->input->post('whatsapp'),
                    'telegram' => $this->input->post('telegram')
                ];
                
                if ($this->input->post('password')) {
                    $update_data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
                }
                
                $this->user_model->update_user($user_id, $update_data);
                $this->session->set_flashdata('success', 'Profil berhasil diperbarui');
                redirect('profile/settings');
            }
        }
        
        $data['title'] = 'Pengaturan Akun';
        $data['user'] = $this->user_model->get_user_detail($user_id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('profile/settings');
        $this->load->view('templates/footer');
    }

    public function notifications() {
        $user_id = $this->session->userdata('user_id');
        
        if ($this->input->method() == 'post') {
            $data = array(
                'trade_notification' => $this->input->post('trade_notification') ? 1 : 0,
                'chat_notification' => $this->input->post('chat_notification') ? 1 : 0,
                'email_notification' => $this->input->post('email_notification') ? 1 : 0
            );
            
            if ($this->user_model->update_notification_settings($user_id, $data)) {
                $this->session->set_flashdata('success', 'Pengaturan notifikasi berhasil diperbarui');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui pengaturan notifikasi');
            }
            
            redirect('profile/notifications');
        }
        
        $data['settings'] = $this->user_model->get_notification_settings($user_id);
        
        $this->load->view('templates/header');
        $this->load->view('profile/notifications', $data);
        $this->load->view('templates/footer');
    }

    public function update_notification_ajax() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $user_id = $this->session->userdata('user_id');
        $type = $this->input->post('type');
        $value = $this->input->post('value') ? 1 : 0;

        $update_data = array(
            $type => $value
        );

        $result = $this->user_model->update_notification_settings($user_id, $update_data);

        echo json_encode(array(
            'success' => $result ? true : false,
            'message' => $result ? 'Pengaturan berhasil diperbarui' : 'Gagal memperbarui pengaturan'
        ));
    }
}