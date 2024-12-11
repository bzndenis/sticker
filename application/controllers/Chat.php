<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['chat_model', 'trade_model']);
        $this->load->library('session');
        $this->load->helper(['url', 'time']);
        
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function trade($trade_id) {
        $user_id = $this->session->userdata('user_id');
        
        $data['title'] = 'Chat Pertukaran';
        $data['trade'] = $this->trade_model->get_trade_detail($trade_id);
        
        // Cek apakah user terlibat dalam pertukaran ini
        if ($data['trade']->requester_id != $user_id && $data['trade']->owner_id != $user_id) {
            show_error('Tidak dapat mengakses chat ini', 403);
        }
        
        $data['messages'] = $this->chat_model->get_trade_messages($trade_id);
        $data['other_user'] = $data['trade']->requester_id == $user_id ? 
                             $data['trade']->owner_name : 
                             $data['trade']->requester_name;
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('chat/trade');
        $this->load->view('templates/footer');
    }

    public function send_message() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $trade_id = $this->input->post('trade_id');
        $message = $this->input->post('message');
        $user_id = $this->session->userdata('user_id');
        
        $result = $this->chat_model->add_message($trade_id, $user_id, $message);
        
        if ($result) {
            // Kirim notifikasi ke user lain
            $trade = $this->trade_model->get_trade_detail($trade_id);
            $to_user_id = $trade->requester_id == $user_id ? 
                         $trade->owner_id : 
                         $trade->requester_id;
            
            $this->load->model('notification_model');
            $this->notification_model->create_notification([
                'to_user_id' => $to_user_id,
                'from_user_id' => $user_id,
                'type' => 'chat',
                'trade_id' => $trade_id,
                'message' => 'Mengirim pesan baru pada pertukaran sticker'
            ]);
        }
        
        echo json_encode(['success' => $result]);
    }

    public function get_new_messages() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $trade_id = $this->input->get('trade_id');
        $last_id = $this->input->get('last_id');
        
        $messages = $this->chat_model->get_new_messages($trade_id, $last_id);
        echo json_encode(['messages' => $messages]);
    }
} 