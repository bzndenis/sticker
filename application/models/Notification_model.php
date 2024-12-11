<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_user_notifications($user_id) {
        $this->db->select('n.*, s.name as sticker_name, s.image as sticker_image, 
                          u.username as sender_name');
        $this->db->from('notifications n');
        $this->db->join('stickers s', 's.id = n.sticker_id', 'left');
        $this->db->join('users u', 'u.id = n.from_user_id', 'left');
        $this->db->where('n.to_user_id', $user_id);
        $this->db->order_by('n.created_at', 'DESC');
        $this->db->limit(50); // Batasi 50 notifikasi terakhir
        return $this->db->get()->result();
    }
    
    public function create_notification($data) {
        return $this->db->insert('notifications', $data);
    }
    
    public function mark_as_read($notification_id, $user_id) {
        return $this->db->where('id', $notification_id)
                        ->where('to_user_id', $user_id)
                        ->update('notifications', ['is_read' => 1]);
    }
    
    public function get_unread_count($user_id) {
        return $this->db->where('to_user_id', $user_id)
                        ->where('is_read', 0)
                        ->from('notifications')
                        ->count_all_results();
    }
} 