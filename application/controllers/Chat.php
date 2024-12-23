<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {
    private $chat_path;
    
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        $this->load->model('trade_model');
        
        // Buat direktori untuk menyimpan file chat jika belum ada
        $this->chat_path = FCPATH . 'uploads/chats/';
        if (!is_dir($this->chat_path)) {
            mkdir($this->chat_path, 0777, true);
        }
    }
    
    private function get_chat_file($trade_id) {
        return $this->chat_path . 'trade_' . $trade_id . '.json';
    }
    
    private function load_messages($trade_id) {
        $file = $this->get_chat_file($trade_id);
        if (file_exists($file)) {
            $content = file_get_contents($file);
            if (!empty($content)) {
                $messages = json_decode($content, true);
                return is_array($messages) ? $messages : [];
            }
        }
        return [];
    }
    
    private function save_messages($trade_id, $messages) {
        $file = $this->get_chat_file($trade_id);
        return file_put_contents($file, json_encode($messages, JSON_PRETTY_PRINT)) !== false;
    }
    
    public function send() {
        if (!$this->input->is_ajax_request()) {
            show_404();
            return;
        }
        
        $user_id = $this->session->userdata('user_id');
        $trade_id = $this->input->post('trade_id');
        $message = trim($this->input->post('message'));
        
        if (empty($trade_id) || empty($message)) {
            echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
            return;
        }
        
        $trade = $this->trade_model->get_trade($trade_id);
        if (!$trade || ($trade->requester_id != $user_id && $trade->owner_id != $user_id)) {
            echo json_encode(['success' => false, 'message' => 'Akses ditolak']);
            return;
        }
        
        try {
            $messages = $this->load_messages($trade_id);
            
            // Pastikan messages adalah array
            if (!is_array($messages)) {
                $messages = [];
            }
            
            $new_message = [
                'id' => count($messages) + 1,
                'user_id' => $user_id,
                'message' => $message,
                'is_delivered' => true,
                'is_read' => false,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $messages[] = $new_message;
            
            // Pastikan direktori ada dan bisa ditulis
            if (!is_dir($this->chat_path)) {
                mkdir($this->chat_path, 0777, true);
            }
            
            if (!$this->save_messages($trade_id, $messages)) {
                throw new Exception('Gagal menyimpan pesan ke file');
            }
            
            echo json_encode([
                'success' => true,
                'message' => [
                    'id' => $new_message['id'],
                    'message' => $new_message['message'],
                    'username' => $this->get_username($user_id),
                    'is_mine' => true,
                    'is_delivered' => true,
                    'is_read' => false,
                    'created_at' => date('H:i')
                ]
            ]);
        } catch (Exception $e) {
            log_message('error', 'Error saving chat message: ' . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Gagal menyimpan pesan: ' . $e->getMessage()]);
        }
    }
    
    public function get_messages($trade_id) {
        if (!$this->input->is_ajax_request()) {
            show_404();
            return;
        }
        
        $user_id = $this->session->userdata('user_id');
        
        // Validasi akses ke trade
        $trade = $this->trade_model->get_trade($trade_id);
        if (!$trade || ($trade->requester_id != $user_id && $trade->owner_id != $user_id)) {
            echo json_encode(['success' => false, 'message' => 'Akses ditolak']);
            return;
        }
        
        $messages = $this->load_messages($trade_id);
        
        // Update status read untuk pesan yang diterima
        $updated = false;
        foreach ($messages as &$msg) {
            if ($msg['user_id'] != $user_id && !$msg['is_read']) {
                $msg['is_read'] = true;
                $updated = true;
            }
        }
        
        if ($updated) {
            $this->save_messages($trade_id, $messages);
        }
        
        echo json_encode([
            'success' => true,
            'messages' => array_map(function($msg) use ($user_id) {
                return [
                    'id' => $msg['id'],
                    'message' => $msg['message'],
                    'username' => $this->get_username($msg['user_id']),
                    'is_mine' => $msg['user_id'] == $user_id,
                    'is_delivered' => isset($msg['is_delivered']) ? $msg['is_delivered'] : true,
                    'is_read' => isset($msg['is_read']) ? $msg['is_read'] : false,
                    'created_at' => date('H:i', strtotime($msg['created_at']))
                ];
            }, $messages)
        ]);
    }
    
    private function get_username($user_id) {
        $user = $this->db->select('username')->where('id', $user_id)->get('users')->row();
        return $user ? $user->username : 'Unknown';
    }
} 