<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {
    
    public function get_categories_with_stats() {
        $this->db->select('sc.*, COUNT(s.id) as total_stickers')
                 ->from('sticker_categories sc')
                 ->join('stickers s', 's.category_id = sc.id', 'left')
                 ->group_by('sc.id');
        return $this->db->get()->result();
    }
    
    public function get_category($id) {
        $this->db->select('sc.*, COUNT(s.id) as total_stickers')
                 ->from('sticker_categories sc')
                 ->join('stickers s', 's.category_id = sc.id', 'left')
                 ->where('sc.id', $id)
                 ->group_by('sc.id');
        return $this->db->get()->row();
    }
    
    public function add_category($data) {
        return $this->db->insert('sticker_categories', $data);
    }
    
    public function update_category($id, $data) {
        return $this->db->where('id', $id)
                        ->update('sticker_categories', $data);
    }
    
    public function delete_category($id) {
        // Cek apakah ada sticker yang menggunakan kategori ini
        $sticker_count = $this->db->where('category_id', $id)
                                 ->count_all_results('stickers');
                                 
        if ($sticker_count > 0) {
            return false;
        }
        
        return $this->db->where('id', $id)->delete('sticker_categories');
    }
    
    public function get_all_categories() {
        return $this->db->get('sticker_categories')->result();
    }
} 