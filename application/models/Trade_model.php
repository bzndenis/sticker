<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trade_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_incoming_requests($user_id) {
        return $this->db->select('tr.*, s.name as sticker_name, s.image, u.username as requester_name')
                        ->from('trade_requests tr')
                        ->join('stickers s', 's.id = tr.sticker_id')
                        ->join('users u', 'u.id = tr.requester_id')
                        ->where('tr.owner_id', $user_id)
                        ->where('tr.status', 'pending')
                        ->order_by('tr.created_at', 'DESC')
                        ->get()->result();
    }
    
    public function get_outgoing_requests($user_id) {
        return $this->db->select('tr.*, s.name as sticker_name, s.image, u.username as owner_name')
                        ->from('trade_requests tr')
                        ->join('stickers s', 's.id = tr.sticker_id')
                        ->join('users u', 'u.id = tr.owner_id')
                        ->where('tr.requester_id', $user_id)
                        ->where('tr.status', 'pending')
                        ->order_by('tr.created_at', 'DESC')
                        ->get()->result();
    }
    
    public function create_trade_request($requester_id, $owner_id, $sticker_id, $message) {
        return $this->db->insert('trade_requests', [
            'requester_id' => $requester_id,
            'owner_id' => $owner_id,
            'sticker_id' => $sticker_id,
            'message' => $message,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    public function update_request_status($request_id, $status, $user_id) {
        $request = $this->db->get_where('trade_requests', ['id' => $request_id])->row();
        
        if (!$request || $request->owner_id != $user_id) {
            return false;
        }
        
        return $this->db->where('id', $request_id)
                        ->update('trade_requests', [
                            'status' => $status,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
    }
    
    public function get_trade_history($user_id) {
        $this->db->select('tr.*, s.name as sticker_name, s.image as sticker_image, 
                          u1.username as requester_name, u2.username as owner_name');
        $this->db->from('trade_requests tr');
        $this->db->join('stickers s', 's.id = tr.sticker_id');
        $this->db->join('users u1', 'u1.id = tr.requester_id');
        $this->db->join('users u2', 'u2.id = tr.owner_id');
        $this->db->where('tr.requester_id', $user_id);
        $this->db->or_where('tr.owner_id', $user_id);
        $this->db->order_by('tr.created_at', 'DESC');
        
        $result = $this->db->get()->result();
        
        return [
            'sent_trades' => array_filter($result, function($trade) use ($user_id) {
                return $trade->requester_id == $user_id;
            }),
            'received_trades' => array_filter($result, function($trade) use ($user_id) {
                return $trade->owner_id == $user_id;
            })
        ];
    }
    
    public function delete_trade_history($id, $user_id) {
        $trade = $this->db->get_where('trade_requests', ['id' => $id])->row();
        
        if (!$trade || ($trade->requester_id != $user_id && $trade->owner_id != $user_id)) {
            return false;
        }
        
        return $this->db->delete('trade_requests', ['id' => $id]);
    }
    
    public function get_sticker_owners($sticker_id) {
        return $this->db->select('u.id, u.username, us.quantity')
                        ->from('user_stickers us')
                        ->join('users u', 'u.id = us.user_id')
                        ->where('us.sticker_id', $sticker_id)
                        ->where('us.quantity >', 0)
                        ->where('u.id !=', $this->session->userdata('user_id'))
                        ->get()->result();
    }

    public function count_pending_trades($user_id) {
        return $this->db->where('requester_id', $user_id)
                        ->where('status', 'pending')
                        ->from('trade_requests')
                        ->count_all_results();
    }

    public function get_recent_trades($user_id, $limit = 10) {
        return $this->db->select('tr.*, s.name as sticker_name, s.image, u1.username as requester_name, u2.username as owner_name')
                        ->from('trade_requests tr')
                        ->join('stickers s', 's.id = tr.sticker_id')
                        ->join('users u1', 'u1.id = tr.requester_id')
                        ->join('users u2', 'u2.id = tr.owner_id')
                        ->where('tr.requester_id', $user_id)
                        ->or_where('tr.owner_id', $user_id)
                        ->order_by('tr.created_at', 'DESC')
                        ->limit($limit)
                        ->get()->result();
    }

    public function count_total_trades($user_id) {
        return $this->db->where('requester_id', $user_id)
                        ->or_where('owner_id', $user_id)
                        ->from('trade_requests')
                        ->count_all_results();
    }

    public function count_success_trades($user_id) {
        return $this->db->where('requester_id', $user_id)
                        ->where('status', 'success')
                        ->from('trade_requests')
                        ->count_all_results();
    }
} 