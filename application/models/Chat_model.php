<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model {
    private $status_cache = [];
    private $message_cache = [];
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_trade_messages($trade_id) {
        // Cek cache
        $cache_key = "trade_messages_{$trade_id}";
        $cached = $this->session->userdata($cache_key);
        
        if ($cached && (time() - $cached['time'] < 5)) {
            return $cached['data'];
        }
        
        // Query dengan limit dan select yang dioptimasi
        $this->db->select('cm.id, cm.message, cm.user_id, cm.created_at, cm.is_read, cm.read_at, cm.is_delivered, u.username');
        $this->db->from('chat_messages cm');
        $this->db->join('users u', 'u.id = cm.user_id');
        $this->db->where('cm.trade_id', $trade_id);
        $this->db->order_by('cm.created_at', 'DESC');
        $this->db->limit(50); // Batasi 50 pesan terakhir
        $result = array_reverse($this->db->get()->result());
        
        // Simpan ke cache
        $this->session->set_userdata($cache_key, [
            'time' => time(),
            'data' => $result
        ]);
        
        return $result;
    }
    
    public function add_message($data) {
        // Validasi dan sanitasi input
        if (!isset($data['trade_id']) || !isset($data['user_id']) || !isset($data['message'])) {
            return false;
        }
        
        $data = array(
            'trade_id' => (int)$data['trade_id'],
            'user_id' => (int)$data['user_id'],
            'message' => htmlspecialchars($data['message']),
            'is_delivered' => 1,
            'created_at' => date('Y-m-d H:i:s')
        );
        
        // Insert dengan transaksi
        $this->db->trans_start();
        $result = $this->db->insert('chat_messages', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            log_message('error', 'Gagal menyimpan chat: ' . $this->db->error()['message']);
            return false;
        }
        
        // Clear cache yang terkait
        $this->clear_chat_cache($data['trade_id']);
        
        // Get pesan yang baru diinsert
        $this->db->select('cm.id, cm.message, cm.created_at, cm.is_read, cm.read_at, cm.is_delivered, u.username');
        $this->db->from('chat_messages cm');
        $this->db->join('users u', 'u.id = cm.user_id');
        $this->db->where('cm.id', $insert_id);
        return $this->db->get()->row();
    }
    
    public function get_message_status($trade_id, $user_id) {
        $cache_key = "msg_status_{$trade_id}_{$user_id}";
        
        // Cek memory cache
        if (isset($this->status_cache[$cache_key])) {
            $cached = $this->status_cache[$cache_key];
            if (time() - $cached['time'] < 5) { // Cache 5 detik
                return $cached['data'];
            }
        }
        
        // Query dengan select yang dioptimasi
        $this->db->select('id, is_delivered, is_read, read_at');
        $this->db->from('chat_messages');
        $this->db->where('trade_id', $trade_id);
        $this->db->where('user_id', $user_id);
        $this->db->where('created_at >=', date('Y-m-d H:i:s', strtotime('-1 hour'))); // Hanya status 1 jam terakhir
        $this->db->order_by('created_at', 'DESC');
        $result = $this->db->get()->result();
        
        // Simpan ke memory cache
        $this->status_cache[$cache_key] = [
            'time' => time(),
            'data' => $result
        ];
        
        return $result;
    }
    
    public function mark_messages_as_read($trade_id, $user_id) {
        $now = date('Y-m-d H:i:s');
        
        $this->db->where('trade_id', $trade_id);
        $this->db->where('user_id !=', $user_id);
        $this->db->where('is_read', 0);
        $this->db->update('chat_messages', [
            'is_read' => 1,
            'read_at' => $now
        ]);
        
        // Clear cache yang terkait
        $this->clear_chat_cache($trade_id);
        
        return $this->db->affected_rows();
    }
    
    private function clear_chat_cache($trade_id) {
        // Clear session cache
        $this->session->unset_userdata("trade_messages_{$trade_id}");
        
        // Clear new messages cache
        $cache_keys = $this->session->userdata();
        foreach ($cache_keys as $key => $value) {
            if (strpos($key, "new_messages_{$trade_id}_") === 0) {
                $this->session->unset_userdata($key);
            }
        }
        
        // Clear memory cache
        foreach ($this->status_cache as $key => $value) {
            if (strpos($key, "msg_status_{$trade_id}_") === 0) {
                unset($this->status_cache[$key]);
            }
        }
    }
    
    public function get_unread_count($trade_id, $user_id) {
        $cache_key = "unread_count_{$trade_id}_{$user_id}";
        $cached = $this->session->userdata($cache_key);
        
        if ($cached && (time() - $cached['time'] < 10)) {
            return $cached['count'];
        }
        
        $count = $this->db->where('trade_id', $trade_id)
                         ->where('user_id !=', $user_id)
                         ->where('is_read', 0)
                         ->count_all_results('chat_messages');
        
        $this->session->set_userdata($cache_key, [
            'time' => time(),
            'count' => $count
        ]);
        
        return $count;
    }
    
    public function get_new_messages($trade_id, $last_id, $user_id) {
        // Cek cache
        $cache_key = "new_messages_{$trade_id}_{$last_id}_{$user_id}";
        $cached = $this->session->userdata($cache_key);
        
        if ($cached && (time() - $cached['time'] < 3)) { // Cache 3 detik
            return $cached['data'];
        }
        
        // Query pesan baru
        $this->db->select('cm.id, cm.message, cm.user_id, cm.created_at, cm.is_read, cm.read_at, cm.is_delivered, u.username');
        $this->db->from('chat_messages cm');
        $this->db->join('users u', 'u.id = cm.user_id');
        $this->db->where('cm.trade_id', $trade_id);
        $this->db->where('cm.id >', $last_id);
        $this->db->where('cm.user_id !=', $user_id); // Hanya pesan dari orang lain
        $this->db->order_by('cm.created_at', 'ASC');
        $result = $this->db->get()->result();
        
        // Simpan ke cache
        $this->session->set_userdata($cache_key, [
            'time' => time(),
            'data' => $result
        ]);
        
        // Tandai pesan sebagai terkirim
        if (!empty($result)) {
            $message_ids = array_column($result, 'id');
            $this->db->where_in('id', $message_ids);
            $this->db->update('chat_messages', ['is_delivered' => 1]);
            
            // Clear cache yang terkait
            $this->clear_chat_cache($trade_id);
        }
        
        return $result;
    }
} 