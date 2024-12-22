<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Collection_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_user_collections($user_id) {
        $this->db->select('
            sc.*,
            COALESCE(user_stickers_count.owned, 0) as owned,
            9 as total, /* Setiap kategori memiliki 9 stiker */
            ROUND(COALESCE(user_stickers_count.owned, 0) / 9 * 100, 1) as progress
        ');
        $this->db->from('sticker_categories sc');
        
        // Subquery untuk menghitung stiker yang dimiliki per kategori
        $this->db->join('(
            SELECT s.category_id, COUNT(DISTINCT us.id) as owned 
            FROM user_stickers us
            JOIN stickers s ON s.id = us.sticker_id
            WHERE us.user_id = '.$user_id.' 
            GROUP BY s.category_id
        ) as user_stickers_count', 'user_stickers_count.category_id = sc.id', 'left');
        
        return $this->db->get()->result();
    }
    
    public function count_user_collections($user_id) {
        return $this->db->select('DISTINCT sc.id')
                        ->from('sticker_categories sc')
                        ->join('stickers s', 's.category_id = sc.id')
                        ->join('user_stickers us', 'us.sticker_id = s.id')
                        ->where('us.user_id', $user_id)
                        ->count_all_results();
    }

    public function calculate_total_progress($user_id) {
        $collections = $this->get_user_collections($user_id);
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
} 