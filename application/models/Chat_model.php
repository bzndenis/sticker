<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function add_message($data) {
        return $this->db->insert('chat_messages', $data);
    }
    
    public function get_trade_messages($trade_id) {
        return $this->db->select('cm.*, u.username')
                       ->from('chat_messages cm')
                       ->join('users u', 'u.id = cm.user_id')
                       ->where('cm.trade_id', $trade_id)
                       ->order_by('cm.created_at', 'ASC')
                       ->get()
                       ->result();
    }
} 