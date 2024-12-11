<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_trade_messages($trade_id) {
        $this->db->select('cm.*, u.username as sender_name');
        $this->db->from('chat_messages cm');
        $this->db->join('users u', 'u.id = cm.user_id');
        $this->db->where('cm.trade_id', $trade_id);
        $this->db->order_by('cm.created_at', 'ASC');
        return $this->db->get()->result();
    }
    
    public function add_message($trade_id, $user_id, $message) {
        $data = [
            'trade_id' => $trade_id,
            'user_id' => $user_id,
            'message' => $message,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $result = $this->db->insert('chat_messages', $data);
        
        if ($result) {
            // Dapatkan detail pesan yang baru ditambahkan
            $this->db->select('cm.*, u.username as sender_name');
            $this->db->from('chat_messages cm');
            $this->db->join('users u', 'u.id = cm.user_id');
            $this->db->where('cm.id', $this->db->insert_id());
            return $this->db->get()->row();
        }
        
        return false;
    }
    
    public function get_new_messages($trade_id, $last_id) {
        $this->db->select('cm.*, u.username as sender_name');
        $this->db->from('chat_messages cm');
        $this->db->join('users u', 'u.id = cm.user_id');
        $this->db->where('cm.trade_id', $trade_id);
        $this->db->where('cm.id >', $last_id);
        $this->db->order_by('cm.created_at', 'ASC');
        return $this->db->get()->result();
    }
    
    public function mark_messages_as_read($trade_id, $user_id) {
        return $this->db->where('trade_id', $trade_id)
                        ->where('user_id !=', $user_id)
                        ->update('chat_messages', ['is_read' => 1]);
    }
    
    public function get_unread_count($trade_id, $user_id) {
        return $this->db->where('trade_id', $trade_id)
                        ->where('user_id !=', $user_id)
                        ->where('is_read', 0)
                        ->from('chat_messages')
                        ->count_all_results();
    }
}