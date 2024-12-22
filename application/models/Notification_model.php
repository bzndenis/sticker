<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function create_notification($data) {
        $this->db->insert('notifications', $data);
        return $this->db->insert_id();
    }
    
    public function get_user_notifications($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('notifications')->result();
    }
    
    public function count_user_notifications($user_id) {
        return $this->db->where('user_id', $user_id)->count_all_results('notifications');
    }
    
    public function mark_as_read($id, $user_id) {
        return $this->db->where([
            'id' => $id,
            'user_id' => $user_id
        ])->update('notifications', [
            'is_read' => 1
        ]);
    }
    
    public function mark_all_read($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->update('notifications', ['is_read' => 1]);
    }
    
    public function count_unread($user_id) {
        return $this->db->where('user_id', $user_id)
                       ->where('is_read', 0)
                       ->count_all_results('notifications');
    }
    
    public function delete_all($user_id) {
        // Hitung jumlah notifikasi yang akan dihapus
        $count = $this->db->where('user_id', $user_id)->count_all_results('notifications');
        
        // Hapus semua notifikasi
        $result = $this->db->where('user_id', $user_id)->delete('notifications');
        
        // Log aktivitas jika berhasil
        if($result) {
            $this->log_notification_deletion($user_id, 'bulk_delete', $count);
        }
        
        return $result;
    }
    
    public function delete_notification($id, $user_id) {
        // Validasi input
        if(!$id || !$user_id) {
            return false;
        }
        
        // Pastikan notifikasi milik user yang benar
        $notification = $this->db->where([
            'id' => $id,
            'user_id' => $user_id
        ])->get('notifications')->row();
        
        if(!$notification) {
            return false;
        }
        
        // Hapus notifikasi
        $result = $this->db->where([
            'id' => $id,
            'user_id' => $user_id
        ])->delete('notifications');
        
        // Log aktivitas jika diperlukan
        if($result) {
            $this->log_notification_deletion($user_id, 'single_delete', 1, $id);
        }
        
        return $result;
    }
    
    private function log_notification_deletion($user_id, $type, $count, $notification_id = null) {
        $log_data = [
            'user_id' => $user_id,
            'action' => 'notification_deletion',
            'type' => $type,
            'count' => $count,
            'notification_id' => $notification_id,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Simpan ke tabel log jika ada
        if($this->db->table_exists('activity_logs')) {
            $this->db->insert('activity_logs', $log_data);
        }
    }
    
    public function get_notification($id, $user_id) {
        return $this->db->where([
            'id' => $id,
            'user_id' => $user_id
        ])->get('notifications')->row();
    }
    
    public function get_unread_notifications_count($user_id) {
        return $this->db->where([
            'user_id' => $user_id,
            'is_read' => 0
        ])->count_all_results('notifications');
    }
} 