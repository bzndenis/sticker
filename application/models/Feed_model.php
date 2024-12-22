<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feed_model extends CI_Model {

    public function get_available_stickers($user_id, $limit, $start) {
        // Subquery untuk mendapatkan stiker yang sudah dimiliki user
        $this->db->select('sticker_id');
        $this->db->from('user_stickers');
        $this->db->where('user_id', $user_id);
        $subquery = $this->db->get_compiled_select();

        // Query utama
        $this->db->select('us.*, u.username, s.number as sticker_number, sc.name as category_name');
        $this->db->from('user_stickers us');
        $this->db->join('users u', 'us.user_id = u.id');
        $this->db->join('stickers s', 'us.sticker_id = s.id');
        $this->db->join('sticker_categories sc', 's.category_id = sc.id');
        $this->db->where('us.is_for_trade', 1);
        $this->db->where('us.user_id !=', $user_id);
        $this->db->where_not_in('us.sticker_id', $subquery, FALSE);
        $this->db->limit($limit, $start);
        $this->db->order_by('us.created_at', 'DESC');
        
        return $this->db->get()->result_array();
    }

    public function count_available_stickers($user_id) {
        // Subquery untuk mendapatkan stiker yang sudah dimiliki user
        $this->db->select('sticker_id');
        $this->db->from('user_stickers');
        $this->db->where('user_id', $user_id);
        $subquery = $this->db->get_compiled_select();

        // Query utama untuk menghitung total
        $this->db->from('user_stickers us');
        $this->db->where('us.is_for_trade', 1);
        $this->db->where('us.user_id !=', $user_id);
        $this->db->where_not_in('us.sticker_id', $subquery, FALSE);
        
        return $this->db->count_all_results();
    }
} 