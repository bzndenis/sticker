<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->check_login();
    }
    
    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['trades'] = $this->trade_model->get_user_trades_with_chat($user_id);
        
        $this->load->view('chat/index', $data);
    }
    
    public function trade($trade_id) {
        $user_id = $this->session->userdata('user_id');
        
        // Cek akses ke chat
        $trade = $this->trade_model->get_trade($trade_id);
        if(!$trade || ($trade->requester_id != $user_id && $trade->owner_id != $user_id)) {
            show_404();
            return;
        }
        
        $data['trade'] = $trade;
        $data['messages'] = $this->chat_model->get_messages($trade_id);
        
        // Mark messages as read
        $this->chat_model->mark_messages_as_read($trade_id, $user_id);
        
        $this->load->view('chat/trade', $data);
    }
    
    public function send() {
        if(!$this->input->is_ajax_request()) {
            show_404();
            return;
        }
        
        $user_id = $this->session->userdata('user_id');
        $trade_id = $this->input->post('trade_id');
        $message = trim($this->input->post('message'));
        
        // Validasi input
        if(!$trade_id || !$message) {
            echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
            return;
        }
        
        // Validasi kepemilikan trade
        $trade = $this->trade_model->get_trade($trade_id);
        if(!$trade || ($trade->requester_id != $user_id && $trade->owner_id != $user_id)) {
            echo json_encode(['success' => false, 'message' => 'Akses ditolak']);
            return;
        }
        
        $message_data = [
            'trade_id' => $trade_id,
            'user_id' => $user_id,
            'message' => $message
        ];
        
        $new_message = $this->chat_model->add_message($message_data);
        if($new_message) {
            echo json_encode([
                'success' => true,
                'message' => [
                    'message' => $new_message->message,
                    'username' => $new_message->username,
                    'created_at' => date('H:i', strtotime($new_message->created_at)),
                    'is_mine' => true
                ]
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal mengirim pesan']);
        }
    }
    
    public function get_new_messages() {
        if(!$this->input->is_ajax_request()) {
            show_404();
            return;
        }
        
        $user_id = $this->session->userdata('user_id');
        $trade_id = $this->input->get('trade_id');
        $last_id = $this->input->get('last_id');
        
        // Validasi input
        if(!$trade_id || !$last_id) {
            $this->output->set_status_header(400);
            echo json_encode(['status' => 'error', 'message' => 'Parameter tidak valid']);
            return;
        }
        
        // Cek akses ke chat
        $trade = $this->trade_model->get_trade($trade_id);
        if(!$trade || ($trade->requester_id != $user_id && $trade->owner_id != $user_id)) {
            $this->output->set_status_header(403);
            echo json_encode(['status' => 'error', 'message' => 'Akses ditolak']);
            return;
        }
        
        // Ambil pesan baru
        $messages = $this->chat_model->get_new_messages($trade_id, $last_id);
        
        // Mark messages as read
        if(!empty($messages)) {
            $this->chat_model->mark_messages_as_read($trade_id, $user_id);
        }
        
        echo json_encode([
            'status' => 'success',
            'messages' => $messages
        ]);
    }
} 