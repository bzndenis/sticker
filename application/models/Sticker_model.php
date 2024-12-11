<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sticker_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_categories() {
        $this->db->select('sc.*, COUNT(s.id) as total_stickers');
        $this->db->from('sticker_categories sc');
        $this->db->join('stickers s', 's.category_id = sc.id', 'left');
        $this->db->group_by('sc.id');
        return $this->db->get()->result();
    }
    
    public function get_category($id) {
        return $this->db->get_where('sticker_categories', ['id' => $id])->row();
    }
    
    public function get_stickers_by_category($category_id) {
        $user_id = $this->session->userdata('user_id');
        
        $this->db->select('s.*, COUNT(us.id) as total_owners, 
                          (SELECT COUNT(*) FROM user_stickers 
                           WHERE user_id = '.$user_id.' AND sticker_id = s.id) as owned');
        $this->db->from('stickers s');
        $this->db->join('user_stickers us', 'us.sticker_id = s.id', 'left');
        $this->db->where('s.category_id', $category_id);
        $this->db->group_by('s.id');
        return $this->db->get()->result();
    }
    
    public function get_user_stickers($user_id) {
        $this->db->select('s.*, us.quantity, us.is_tradeable');
        $this->db->from('stickers s');
        $this->db->join('user_stickers us', 'us.sticker_id = s.id');
        $this->db->where('us.user_id', $user_id);
        return $this->db->get()->result();
    }
    
    public function count_all_stickers() {
        return $this->db->count_all('stickers');
    }
    
    public function count_owned_stickers($user_id) {
        return $this->db->where('user_id', $user_id)
                        ->from('user_stickers')
                        ->count_all_results();
    }
    
    public function get_recent_trades($user_id, $limit = 5) {
        $this->db->select('tr.*, s.name as sticker_name, s.image, 
                          u1.username as requester_name, u2.username as owner_name')
                 ->from('trade_requests tr')
                 ->join('stickers s', 's.id = tr.sticker_id')
                 ->join('users u1', 'u1.id = tr.requester_id')
                 ->join('users u2', 'u2.id = tr.owner_id')
                 ->where('tr.requester_id', $user_id)
                 ->or_where('tr.owner_id', $user_id)
                 ->order_by('tr.created_at', 'DESC')
                 ->limit($limit);
        return $this->db->get()->result();
    }
    
    public function get_user_collection($user_id) {
        $this->db->select('s.*, sc.name as category_name, us.quantity, us.id as user_sticker_id')
                 ->from('user_stickers us')
                 ->join('stickers s', 's.id = us.sticker_id')
                 ->join('sticker_categories sc', 'sc.id = s.category_id')
                 ->where('us.user_id', $user_id)
                 ->order_by('sc.name', 'ASC')
                 ->order_by('s.name', 'ASC');
        return $this->db->get()->result();
    }
    
    public function update_sticker_quantity($user_id, $sticker_id, $quantity) {
        if ($quantity <= 0) {
            return $this->db->delete('user_stickers', [
                'user_id' => $user_id,
                'sticker_id' => $sticker_id
            ]);
        }
        
        return $this->db->where([
            'user_id' => $user_id,
            'sticker_id' => $sticker_id
        ])->update('user_stickers', ['quantity' => $quantity]);
    }
    
    public function get_sticker_detail($sticker_id) {
        $this->db->select('s.*, sc.name as category_name');
        $this->db->from('stickers s');
        $this->db->join('sticker_categories sc', 'sc.id = s.category_id');
        $this->db->where('s.id', $sticker_id);
        return $this->db->get()->row();
    }
    
    public function get_sticker_owners($sticker_id) {
        $this->db->select('u.id, u.username, us.quantity');
        $this->db->from('users u');
        $this->db->join('user_stickers us', 'us.user_id = u.id');
        $this->db->where('us.sticker_id', $sticker_id);
        $this->db->where('us.quantity >', 1); // Hanya yang punya lebih dari 1
        $this->db->where('us.is_tradeable', 1);
        return $this->db->get()->result();
    }
    
    public function get_sticker_needs($sticker_id) {
        // Subquery untuk mendapatkan user yang belum punya sticker ini
        $subquery = $this->db->select('user_id')
                            ->from('user_stickers')
                            ->where('sticker_id', $sticker_id)
                            ->get_compiled_select();
                            
        $this->db->select('u.id, u.username');
        $this->db->from('users u');
        $this->db->where("u.id NOT IN ($subquery)");
        return $this->db->get()->result();
    }
    
    public function get_completion_stats($user_id) {
        // Total progress per kategori
        $this->db->select('sc.name, 
                          COUNT(DISTINCT s.id) as total_stickers,
                          COUNT(DISTINCT CASE WHEN us.user_id = '.$user_id.' THEN s.id END) as owned_stickers');
        $this->db->from('sticker_categories sc');
        $this->db->join('stickers s', 's.category_id = sc.id');
        $this->db->join('user_stickers us', 'us.sticker_id = s.id', 'left');
        $this->db->group_by('sc.id');
        return $this->db->get()->result();
    }
    
    public function get_category_progress($user_id) {
        // Progress detail per kategori
        $categories = $this->get_categories();
        $progress = [];
        
        foreach($categories as $category) {
            $progress[$category->id] = [
                'name' => $category->name,
                'total' => 9, // Total sticker per kategori adalah 9
                'owned' => $this->db->where('us.user_id', $user_id)
                                   ->where('s.category_id', $category->id)
                                   ->join('stickers s', 's.id = us.sticker_id')
                                   ->from('user_stickers us')
                                   ->count_all_results(),
                'tradeable' => $this->db->where('us.user_id', $user_id)
                                       ->where('s.category_id', $category->id)
                                       ->where('us.is_tradeable', 1)
                                       ->where('us.quantity >', 1)
                                       ->join('stickers s', 's.id = us.sticker_id')
                                       ->from('user_stickers us')
                                       ->count_all_results()
            ];
        }
        
        return $progress;
    }
    
    public function get_recent_activities($user_id, $limit = 10) {
        $this->db->select("s.name as sticker_name, s.image, 
                         IF(tr.id IS NOT NULL, 'trade',
                            IF(us.created_at IS NOT NULL, 'new', 'update')) as activity_type,
                         COALESCE(tr.created_at, us.created_at, us.updated_at) as activity_date");
        $this->db->from('user_stickers us');
        $this->db->join('stickers s', 's.id = us.sticker_id');
        $this->db->join('trade_requests tr', 'tr.sticker_id = s.id AND (tr.requester_id = '.$user_id.' OR tr.owner_id = '.$user_id.')', 'left');
        $this->db->where('us.user_id', $user_id);
        $this->db->order_by('activity_date', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
    
    public function get_tradeable_stickers($user_id) {
        $this->db->select('s.*, sc.name as category_name, us.quantity, us.is_tradeable, 
                          COALESCE(us.min_quantity, 1) as min_quantity');
        $this->db->from('user_stickers us');
        $this->db->join('stickers s', 's.id = us.sticker_id');
        $this->db->join('sticker_categories sc', 'sc.id = s.category_id');
        $this->db->where('us.user_id', $user_id);
        $this->db->where('us.quantity >', 1);
        return $this->db->get()->result();
    }
    
    public function update_tradeable_status($user_id, $sticker_id, $is_tradeable) {
        return $this->db->where('user_id', $user_id)
                        ->where('sticker_id', $sticker_id)
                        ->update('user_stickers', ['is_tradeable' => $is_tradeable]);
    }
    
    public function set_minimum_tradeable_quantity($user_id, $sticker_id, $min_quantity) {
        return $this->db->where('user_id', $user_id)
                        ->where('sticker_id', $sticker_id)
                        ->update('user_stickers', ['min_quantity' => $min_quantity]);
    }
    
    public function search_stickers($params) {
        $this->db->select('s.*, sc.name as category_name, 
                          COALESCE(us.quantity, 0) as owned_quantity,
                          us.is_tradeable');
        $this->db->from('stickers s');
        $this->db->join('sticker_categories sc', 'sc.id = s.category_id');
        $this->db->join('user_stickers us', 'us.sticker_id = s.id AND us.user_id = '.$params['user_id'], 'left');
        
        if (!empty($params['keyword'])) {
            $this->db->group_start();
            $this->db->like('s.name', $params['keyword']);
            $this->db->or_like('sc.name', $params['keyword']);
            $this->db->group_end();
        }
        
        if (!empty($params['category'])) {
            $this->db->where('s.category_id', $params['category']);
        }
        
        if (!empty($params['status'])) {
            switch($params['status']) {
                case 'owned':
                    $this->db->where('us.quantity >', 0);
                    break;
                case 'needed':
                    $this->db->where('us.quantity IS NULL');
                    break;
                case 'tradeable':
                    $this->db->where('us.quantity >', 1);
                    $this->db->where('us.is_tradeable', 1);
                    break;
            }
        }
        
        return $this->db->get()->result();
    }
    
    public function quick_search_stickers($keyword, $user_id) {
        $this->db->select('s.id, s.name, s.image, sc.name as category_name');
        $this->db->from('stickers s');
        $this->db->join('sticker_categories sc', 'sc.id = s.category_id');
        $this->db->like('s.name', $keyword);
        $this->db->or_like('sc.name', $keyword);
        $this->db->limit(5);
        return $this->db->get()->result();
    }

    public function count_tradeable_stickers($user_id) {
        return $this->db->where('user_id', $user_id)
                        ->where('quantity >', 1)
                        ->where('is_tradeable', 1)
                        ->from('user_stickers')
                        ->count_all_results();
    }
} 