<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Collection_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_user_collections($user_id) {
        $this->db->select('sc.*, 
                          COUNT(DISTINCT s.id) as total,
                          COUNT(DISTINCT us.sticker_id) as owned,
                          ROUND((COUNT(DISTINCT us.sticker_id) / COUNT(DISTINCT s.id)) * 100, 1) as progress');
        $this->db->from('sticker_categories sc');
        $this->db->join('stickers s', 's.category_id = sc.id');
        $this->db->join('user_stickers us', 'us.sticker_id = s.id AND us.user_id = ' . $user_id, 'left');
        $this->db->group_by('sc.id');
        $this->db->order_by('sc.name');
        
        return $this->db->get()->result();
    }
    
    public function get_user_collections_progress($user_id) {
        $this->db->select('sc.id, sc.name, 
                          COUNT(DISTINCT s.id) as total,
                          COUNT(DISTINCT us.sticker_id) as owned,
                          ROUND((COUNT(DISTINCT us.sticker_id) / COUNT(DISTINCT s.id)) * 100) as progress');
        $this->db->from('sticker_categories sc');
        $this->db->join('stickers s', 's.category_id = sc.id');
        $this->db->join('user_stickers us', 'us.sticker_id = s.id AND us.user_id = ' . $user_id, 'left');
        $this->db->group_by('sc.id');
        $this->db->order_by('sc.name');
        
        return $this->db->get()->result();
    }

    public function calculate_total_progress($user_id) {
        $collections = $this->get_user_collections_progress($user_id);
        if (empty($collections)) {
            return 0;
        }

        $total_owned = 0;
        $total_stickers = 0;
        foreach ($collections as $collection) {
            $total_owned += $collection->owned;
            $total_stickers += $collection->total;
        }

        if ($total_stickers > 0) {
            return round(($total_owned / $total_stickers) * 100, 1);
        }
        return 0;
    }

    public function count_user_collections($user_id) {
        $this->db->select('COUNT(DISTINCT sc.id) as total');
        $this->db->from('sticker_categories sc');
        $this->db->join('stickers s', 's.category_id = sc.id');
        $this->db->join('user_stickers us', 'us.sticker_id = s.id AND us.user_id = ' . $user_id);
        
        $result = $this->db->get()->row();
        return $result ? $result->total : 0;
    }
} 