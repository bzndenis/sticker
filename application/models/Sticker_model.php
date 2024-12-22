<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sticker_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_categories() {
        return $this->db->get('sticker_categories')->result();
    }
    
    public function get_category($id) {
        return $this->db->get_where('sticker_categories', ['id' => $id])->row();
    }
    
    public function get_sticker($id) {
        return $this->db->get_where('stickers', ['id' => $id])->row();
    }
    
    public function get_sticker_by_hash($hash) {
        return $this->db->get_where('stickers', ['image_hash' => $hash])->row();
    }
    
    public function add_sticker($data) {
        // Tambahkan validasi hash gambar
        if (!isset($data['image_hash'])) {
            require_once APPPATH . 'libraries/ImageHash/ImageHash.php';
            $hasher = new ImageHash();
            $data['image_hash'] = $hasher->hash('./uploads/stickers/' . $data['image_path']);
        }
        
        // Cek duplikasi stiker berdasarkan hash
        $existing = $this->get_sticker_by_hash($data['image_hash']);
        if ($existing) {
            return ['status' => 'duplicate', 'sticker' => $existing];
        }
        
        // Tambahkan data tambahan
        $data['created_at'] = date('Y-m-d H:i:s');
        
        if ($this->db->insert('stickers', $data)) {
            return ['status' => 'success', 'sticker_id' => $this->db->insert_id()];
        }
        
        return ['status' => 'error'];
    }
    
    public function update_sticker($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('stickers', $data);
    }
    
    public function delete_sticker($id) {
        $this->db->trans_start();
        
        // Hapus file gambar
        $sticker = $this->get_sticker($id);
        if($sticker) {
            $image_path = './uploads/stickers/'.$sticker->image_path;
            if(file_exists($image_path)) {
                unlink($image_path);
            }
        }
        
        // Delete user_stickers records
        $this->db->where('sticker_id', $id)->delete('user_stickers');
        
        // Delete trade_requests records
        $this->db->where('requested_sticker_id', $id)
                 ->or_where('offered_sticker_id', $id)
                 ->delete('trade_requests');
        
        // Delete trade_items records
        $this->db->delete('trade_items', ['sticker_id' => $id]);
        
        // Delete sticker record
        $this->db->where('id', $id)->delete('stickers');
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    
    public function get_collections_with_progress($user_id) {
        $this->db->select('sc.*, sc.name as name');
        $this->db->from('sticker_categories sc');
        $this->db->order_by('sc.id', 'ASC'); // Urutkan berdasarkan ID
        $collections = $this->db->get()->result();
        
        // Tambahkan informasi total stiker untuk setiap kategori
        foreach($collections as $collection) {
            $collection->total = 9; // Setiap kategori memiliki 9 stiker
            $collection->owned = $this->count_owned_stickers($user_id, $collection->id);
            $collection->progress = round(($collection->owned / $collection->total) * 100, 1);
        }
        
        return $collections;
    }
    
    public function get_category_stickers($category_id) {
        // Get base stickers from category
        $stickers = $this->db->select('s.*, sc.name as category_name')
            ->from('stickers s')
            ->join('sticker_categories sc', 'sc.id = s.category_id')
            ->where('s.category_id', $category_id)
            ->get()
            ->result();
        
        // Get user's stickers for this category
        $user_stickers = $this->db->select('us.*, s.number')
            ->from('user_stickers us')
            ->join('stickers s', 's.id = us.sticker_id')
            ->where('us.user_id', $this->session->userdata('user_id'))
            ->where('s.category_id', $category_id)
            ->get()
            ->result_array();
        
        // Index user stickers by sticker_id for easy lookup
        $user_sticker_map = array_column($user_stickers, NULL, 'sticker_id');
        
        // Combine the data
        foreach ($stickers as &$sticker) {
            $sticker->user_sticker = isset($user_sticker_map[$sticker->id]) 
                ? $user_sticker_map[$sticker->id] 
                : null;
        }
        
        return $stickers;
    }
    
    public function get_available_trades($user_id) {
        $this->db->select('us.*, s.number, s.image_path, 
                          sc.name as category_name, u.username');
        $this->db->from('user_stickers us');
        $this->db->join('stickers s', 's.id = us.sticker_id');
        $this->db->join('sticker_categories sc', 'sc.id = s.category_id');
        $this->db->join('users u', 'u.id = us.user_id');
        $this->db->where('us.is_for_trade', 1);
        $this->db->where('us.quantity >', 1);
        $this->db->where('us.user_id !=', $user_id);
        return $this->db->get()->result();
    }
    
    public function get_trade_recommendations($user_id) {
        // Dapatkan stiker yang belum dimiliki user
        $this->db->select('s.*, sc.name as category_name, u.username, us.quantity');
        $this->db->from('stickers s');
        $this->db->join('sticker_categories sc', 'sc.id = s.category_id');
        $this->db->join('user_stickers us', 'us.sticker_id = s.id');
        $this->db->join('users u', 'u.id = us.user_id');
        $this->db->where('us.quantity >', 1); // Yang punya double
        $this->db->where('us.user_id !=', $user_id); // Bukan milik user ini
        
        // Ganti where_not_exists dengan subquery untuk mencari stiker yang belum dimiliki
        $this->db->where("NOT EXISTS (
            SELECT 1 FROM user_stickers us2 
            WHERE us2.sticker_id = s.id 
            AND us2.user_id = $user_id
        )");
        
        $this->db->order_by('RAND()');
        $this->db->limit(5);
        
        return $this->db->get()->result();
    }
    
    public function get_feed($user_id) {
        $this->db->select('s.*, sc.name as category_name, u.username, us.quantity, us.user_id');
        $this->db->from('user_stickers us');
        $this->db->join('stickers s', 's.id = us.sticker_id');
        $this->db->join('sticker_categories sc', 'sc.id = s.category_id');
        $this->db->join('users u', 'u.id = us.user_id');
        $this->db->where('us.quantity >', 0);
        $this->db->order_by('us.created_at', 'DESC');
        $this->db->limit(20);
        return $this->db->get()->result();
    }

    public function get_categories_with_stats($category_id = null) {
        $this->db->select('sc.*, COUNT(s.id) as total_stickers, COUNT(DISTINCT us.user_id) as total_collectors');
        $this->db->from('sticker_categories sc');
        $this->db->join('stickers s', 's.category_id = sc.id', 'left');
        $this->db->join('user_stickers us', 'us.sticker_id = s.id', 'left');
        
        if($category_id) {
            $this->db->where('sc.id', $category_id);
        }
        
        $this->db->group_by('sc.id');
        $this->db->order_by('sc.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function add_category($data) {
        return $this->db->insert('sticker_categories', $data);
    }

    public function update_sticker_quantity($sticker_id, $number, $quantity, $is_for_trade = true) {
        // Check if record exists
        $existing = $this->db->get_where('user_stickers', [
            'sticker_id' => $sticker_id,
            'number' => $number
        ])->row();

        if ($existing) {
            return $this->db->where([
                'sticker_id' => $sticker_id,
                'number' => $number
            ])->update('user_stickers', [
                'quantity' => $quantity,
                'is_for_trade' => $is_for_trade ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            return $this->db->insert('user_stickers', [
                'sticker_id' => $sticker_id,
                'number' => $number,
                'quantity' => $quantity,
                'is_for_trade' => $is_for_trade ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    public function get_categories_with_progress() {
        $user_id = $this->session->userdata('user_id');
        
        $this->db->select('
            sc.*,
            COALESCE(SUM(us.quantity), 0) as owned,
            9 as total,
            COALESCE((SUM(us.quantity) / 9) * 100, 0) as progress
        ')
        ->from('sticker_categories sc')
        ->join('stickers s', 's.category_id = sc.id', 'left')
        ->join('user_stickers us', 'us.sticker_id = s.id AND us.user_id = '.$user_id, 'left')
        ->group_by('sc.id')
        ->order_by('sc.name', 'ASC');

        return $this->db->get()->result();
    }

    public function delete_category($id) {
        // Hapus stiker terlebih dahulu
        $stickers = $this->db->get_where('stickers', ['category_id' => $id])->result();
        foreach($stickers as $sticker) {
            $this->delete_sticker($sticker->id);
        }
        
        // Hapus kategori
        return $this->db->delete('sticker_categories', ['id' => $id]);
    }

    public function get_category_by_name($name) {
        return $this->db->get_where('sticker_categories', ['name' => $name])->row();
    }

    public function initialize_category_stickers($category_id) {
        // Buat 9 stiker untuk kategori ini
        for($number = 1; $number <= 9; $number++) {
            $data = [
                'category_id' => $category_id,
                'number' => $number,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('stickers', $data);
        }
        return true;
    }

    public function get_feed_items($user_id, $limit = 20, $category_id = null) {
        $this->db->select('s.id as sticker_id, s.*, us.image_path, us.image_hash, us.quantity, us.is_for_trade, 
                          sc.name as category_name, u.username, us.user_id as owner_id');
        $this->db->from('user_stickers us');
        $this->db->join('stickers s', 's.id = us.sticker_id');
        $this->db->join('sticker_categories sc', 'sc.id = s.category_id');
        $this->db->join('users u', 'u.id = us.user_id');
        $this->db->where([
            'us.quantity >' => 1,  // Pemilik harus punya lebih dari 1
            'us.user_id !=' => $user_id,  // Bukan milik user yang request
            'us.image_path IS NOT NULL'  // Harus ada gambar
        ]);
        
        if ($category_id) {
            $this->db->where('s.category_id', $category_id);
        }
        
        $this->db->order_by('us.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    public function get_user_collections($user_id) {
        $this->db->select('s.*, sc.name as category_name, us.quantity, us.is_for_trade, us.image_path');
        $this->db->from('user_stickers us');
        $this->db->join('stickers s', 's.id = us.sticker_id');
        $this->db->join('sticker_categories sc', 'sc.id = s.category_id');
        $this->db->where('us.user_id', $user_id);
        return $this->db->get()->result();
    }

    public function get_sticker_with_owner($sticker_id) {
        $this->db->select('s.*, us.user_id as owner_id, us.image_path, us.number, 
                          u.username as owner_username');
        $this->db->from('stickers s');
        $this->db->join('user_stickers us', 'us.sticker_id = s.id');
        $this->db->join('users u', 'u.id = us.user_id');
        $this->db->where('s.id', $sticker_id);
        return $this->db->get()->row();
    }

    public function get_user_stickers_chart($user_id, $period = 'monthly') {
        $format = $period == 'daily' ? '%Y-%m-%d' : 
                 ($period == 'weekly' ? '%Y-%u' : '%Y-%m');
                 
        $sql = "SELECT DATE_FORMAT(created_at, ?) as period, 
                COUNT(*) as total,
                MIN(created_at) as min_date
                FROM user_stickers 
                WHERE user_id = ?
                AND created_at >= DATE_SUB(NOW(), INTERVAL 1 YEAR)
                GROUP BY period
                ORDER BY min_date ASC";
                
        return $this->db->query($sql, [$format, $user_id])->result();
    }

    public function count_categories() {
        return $this->db->count_all('sticker_categories');
    }

    public function count_stickers() {
        return $this->db->count_all('stickers');
    }

    public function count_owned_stickers($user_id, $category_id) {
        $result = $this->db->select_sum('us.quantity')
            ->from('user_stickers us')
            ->join('stickers s', 's.id = us.sticker_id')
            ->where('s.category_id', $category_id)
            ->where('us.user_id', $user_id)
            ->get()
            ->row();
        
        return $result ? ($result->quantity ? $result->quantity : 0) : 0;
    }

    public function get_total_stickers($category_id) {
        // Setiap kategori memiliki 9 stiker (sesuai dengan database)
        return 9;
        
        // Atau jika ingin mengambil dari database:
        // return $this->db->where('category_id', $category_id)
        //                 ->count_all_results('stickers');
    }

    public function can_request_trade($user_id, $sticker_id) {
        // Cek apakah stiker milik user lain dan pemilik punya lebih dari 1
        $sticker = $this->db->select('us.*, s.category_id')
                            ->from('user_stickers us')
                            ->join('stickers s', 's.id = us.sticker_id')
                            ->where([
                                'us.sticker_id' => $sticker_id,
                                'us.quantity >' => 1,  // Pemilik harus punya lebih dari 1
                                'us.user_id !=' => $user_id  // Bukan milik user yang request
                            ])
                            ->get()
                            ->row();
        
        if (!$sticker) return false;
        
        // Cek apakah user yang request punya stiker yang bisa ditukar
        $has_tradeable = $this->db->where([
            'user_id' => $user_id,
            'quantity >' => 1  // User yang request juga harus punya stiker double
        ])->count_all_results('user_stickers') > 0;
        
        return $has_tradeable;
    }

    public function get_user_stickers($user_id, $category = null, $sort = null) {
        $this->db->select('
            us.*, 
            s.number as sticker_number,
            sc.name as category_name
        ')
        ->from('user_stickers us')
        ->join('stickers s', 's.id = us.sticker_id')
        ->join('sticker_categories sc', 'sc.id = s.category_id')
        ->where('us.user_id', $user_id);

        // Filter by category
        if ($category) {
            $this->db->where('s.category_id', $category);
        }

        // Sort options
        switch ($sort) {
            case 'number':
                $this->db->order_by('us.number', 'ASC');
                break;
            case 'newest':
                $this->db->order_by('us.created_at', 'DESC');
                break;
            case 'quantity':
                $this->db->order_by('us.quantity', 'DESC');
                break;
            default:
                $this->db->order_by('us.number', 'ASC');
        }

        return $this->db->get()->result();
    }

    public function count_user_stickers($user_id) {
        return $this->db->where('user_id', $user_id)
                       ->count_all_results('user_stickers');
    }

    public function count_unique_stickers($user_id) {
        return $this->db->where('user_id', $user_id)
            ->count_all_results('user_stickers');
    }

    public function count_tradeable_stickers($user_id) {
        return $this->db->where('user_id', $user_id)
            ->where('is_for_trade', 1)
            ->count_all_results('user_stickers');
    }

    public function get_collection_completion_rate($user_id) {
        $total_stickers = $this->db->count_all('stickers');
        if ($total_stickers == 0) return 0;

        $collected_stickers = $this->db->where('user_id', $user_id)
            ->count_all_results('user_stickers');

        return ($collected_stickers / $total_stickers) * 100;
    }

    public function toggle_trade_status($sticker_id, $user_id, $status) {
        return $this->db->where('id', $sticker_id)
            ->where('user_id', $user_id)
            ->update('user_stickers', [
                'is_for_trade' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

    public function count_collection_stickers($collection_id, $user_id) {
        return $this->db->where('collection_id', $collection_id)
                       ->where('user_id', $user_id)
                       ->count_all_results('user_stickers');
    }

    public function get_feed_stickers($category = null) {
        $this->db->select('
            us.*, 
            us.image_path,
            s.number,
            sc.name as category_name,
            u.username as owner_username,
            u.id as owner_id
        ')
        ->from('user_stickers us')
        ->join('stickers s', 's.id = us.sticker_id')
        ->join('sticker_categories sc', 'sc.id = s.category_id')
        ->join('users u', 'u.id = us.user_id')
        ->where('us.is_for_trade', 1)
        ->where('us.user_id !=', $this->session->userdata('user_id'));
        
        if ($category) {
            $this->db->where('s.category_id', $category);
        }
        
        $this->db->order_by('us.created_at', 'DESC');
        
        return $this->db->get()->result();
    }

    public function add_user_sticker($data) {
        return $this->db->insert('user_stickers', $data);
    }

    public function update_user_sticker($id, $data) {
        return $this->db->where('id', $id)
                        ->update('user_stickers', $data);
    }

    public function get_user_sticker($user_id, $sticker_id) {
        return $this->db->where([
            'user_id' => $user_id,
            'sticker_id' => $sticker_id
        ])->get('user_stickers')->row();
    }

    public function get_tradeable_stickers($user_id) {
        return $this->db->select('
            us.id,
            us.sticker_id,
            us.quantity,
            s.number,
            sc.name as category_name,
            us.image_path
        ')
        ->from('user_stickers us')
        ->join('stickers s', 's.id = us.sticker_id')
        ->join('sticker_categories sc', 'sc.id = s.category_id')
        ->where([
            'us.user_id' => $user_id,
            'us.quantity >' => 1,
            'us.image_path IS NOT NULL' => null
        ])
        ->order_by('sc.name', 'ASC')
        ->order_by('s.number', 'ASC')
        ->get()
        ->result();
    }

    public function fix_sticker_numbers() {
        // Ambil semua kategori
        $categories = $this->db->get('sticker_categories')->result();
        
        foreach($categories as $category) {
            // Ambil stiker untuk kategori ini
            $stickers = $this->db->where('category_id', $category->id)
                                ->order_by('id', 'ASC')
                                ->get('stickers')
                                ->result();
            
            // Update nomor stiker
            $number = 1;
            foreach($stickers as $sticker) {
                $this->db->where('id', $sticker->id)
                         ->update('stickers', ['number' => $number]);
                $number++;
            }
        }
    }
} 