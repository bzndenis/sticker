<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trade_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function create_trade($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('trades', $data);
    }
    
    public function get_user_trades($user_id) {
        return $this->db->where('requester_id', $user_id)
                       ->or_where('owner_id', $user_id)
                       ->get('trades')
                       ->result();
    }
    
    public function update_trade_status($trade_id, $status) {
        return $this->db->where('id', $trade_id)
                        ->update('trades', [
                            'status' => $status,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
    }
    
    public function get_trade($trade_id) {
        $this->db->select('t.*, 
                          rus.image_path as requested_image,
                          ous.image_path as offered_image,
                          u1.username as requester_username,
                          u2.username as owner_username,
                          rsc.name as requested_category,
                          osc.name as offered_category');
        $this->db->from('trades t');
        $this->db->join('stickers rs', 'rs.id = t.requested_sticker_id');
        $this->db->join('stickers os', 'os.id = t.offered_sticker_id');
        $this->db->join('user_stickers rus', 'rus.sticker_id = rs.id AND rus.user_id = t.owner_id', 'left');
        $this->db->join('user_stickers ous', 'ous.sticker_id = os.id AND ous.user_id = t.requester_id', 'left');
        $this->db->join('sticker_categories rsc', 'rsc.id = rs.category_id');
        $this->db->join('sticker_categories osc', 'osc.id = os.category_id');
        $this->db->join('users u1', 'u1.id = t.requester_id');
        $this->db->join('users u2', 'u2.id = t.owner_id');
        $this->db->where('t.id', $trade_id);
        
        return $this->db->get()->row();
    }

    public function get_recent_trades($user_id, $limit = 5) {
        $this->db->select('t.*, 
                          rus.image_path as requested_image,
                          ous.image_path as offered_image,
                          u1.username as requester_username, 
                          u2.username as owner_username,
                          rsc.name as requested_category,
                          osc.name as offered_category');
        $this->db->from('trades t');
        $this->db->join('stickers rs', 'rs.id = t.requested_sticker_id');
        $this->db->join('stickers os', 'os.id = t.offered_sticker_id');
        $this->db->join('user_stickers rus', 'rus.sticker_id = rs.id AND rus.user_id = t.owner_id', 'left');
        $this->db->join('user_stickers ous', 'ous.sticker_id = os.id AND ous.user_id = t.requester_id', 'left');
        $this->db->join('sticker_categories rsc', 'rsc.id = rs.category_id');
        $this->db->join('sticker_categories osc', 'osc.id = os.category_id');
        $this->db->join('users u1', 'u1.id = t.requester_id');
        $this->db->join('users u2', 'u2.id = t.owner_id');
        $this->db->where("(t.requester_id = $user_id OR t.owner_id = $user_id)");
        $this->db->order_by('t.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    public function count_user_trades($user_id) {
        return $this->db->where('(requester_id = '.$user_id.' OR owner_id = '.$user_id.')')
                       ->where('status', 'completed')
                       ->count_all_results('trades');
    }

    public function count_trades() {
        return $this->db->count_all('trades');
    }

    public function count_pending_trades() {
        return $this->db->where('status', 'pending')->count_all_results('trades');
    }

    public function get_trade_stats($user_id) {
        // Hitung total trades
        $total_trades = $this->db->where('requester_id', $user_id)
                                ->or_where('owner_id', $user_id)
                                ->count_all_results('trades');
        
        // Hitung pending trades                        
        $pending_trades = $this->db->where('status', 'pending')
                                  ->where('(requester_id = ' . $user_id . ' OR owner_id = ' . $user_id . ')')
                                  ->count_all_results('trades');
                                  
        // Hitung successful trades
        $success_trades = $this->db->where('status', 'accepted')
                                  ->where('(requester_id = ' . $user_id . ' OR owner_id = ' . $user_id . ')')
                                  ->count_all_results('trades');
                                  
        // Hitung completion rate
        $completion_rate = $total_trades > 0 ? ($success_trades / $total_trades) * 100 : 0;
        
        return (object)[
            'total_trades' => $total_trades,
            'pending_trades' => $pending_trades,
            'success_trades' => $success_trades,
            'completion_rate' => round($completion_rate, 1)
        ];
    }
    
    public function get_user_trades_chart($user_id, $period = 'monthly') {
        $format = $period == 'daily' ? '%Y-%m-%d' : 
                 ($period == 'weekly' ? '%Y-%u' : '%Y-%m');
                 
        $sql = "SELECT DATE_FORMAT(created_at, ?) as period, 
                COUNT(*) as total,
                MIN(created_at) as min_date
                FROM trades 
                WHERE (requester_id = ? OR owner_id = ?)
                AND created_at >= DATE_SUB(NOW(), INTERVAL 1 YEAR)
                GROUP BY period
                ORDER BY min_date ASC";
                
        return $this->db->query($sql, [$format, $user_id, $user_id])->result();
    }

    public function get_all_trades($limit = null, $offset = 0) {
        $this->db->select('t.*, 
                          rus.image_path as requested_image,
                          ous.image_path as offered_image,
                          u1.username as requester_username, 
                          u2.username as owner_username,
                          rsc.name as requested_category,
                          osc.name as offered_category');
        $this->db->from('trades t');
        $this->db->join('stickers rs', 'rs.id = t.requested_sticker_id');
        $this->db->join('stickers os', 'os.id = t.offered_sticker_id');
        $this->db->join('user_stickers rus', 'rus.sticker_id = rs.id AND rus.user_id = t.owner_id', 'left');
        $this->db->join('user_stickers ous', 'ous.sticker_id = os.id AND ous.user_id = t.requester_id', 'left');
        $this->db->join('sticker_categories rsc', 'rsc.id = rs.category_id');
        $this->db->join('sticker_categories osc', 'osc.id = os.category_id');
        $this->db->join('users u1', 'u1.id = t.requester_id');
        $this->db->join('users u2', 'u2.id = t.owner_id');
        
        $this->db->order_by('t.created_at', 'DESC');
        
        if($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result();
    }

    public function get_trades_by_status($status, $limit = null) {
        $this->db->select('t.*, 
                          rus.image_path as requested_image,
                          ous.image_path as offered_image,
                          u1.username as requester_username,
                          u2.username as owner_username,
                          rsc.name as requested_category,
                          osc.name as offered_category');
        $this->db->from('trades t');
        $this->db->join('stickers rs', 'rs.id = t.requested_sticker_id');
        $this->db->join('stickers os', 'os.id = t.offered_sticker_id');
        $this->db->join('user_stickers rus', 'rus.sticker_id = rs.id AND rus.user_id = t.owner_id', 'left');
        $this->db->join('user_stickers ous', 'ous.sticker_id = os.id AND ous.user_id = t.requester_id', 'left');
        $this->db->join('sticker_categories rsc', 'rsc.id = rs.category_id');
        $this->db->join('sticker_categories osc', 'osc.id = os.category_id');
        $this->db->join('users u1', 'u1.id = t.requester_id');
        $this->db->join('users u2', 'u2.id = t.owner_id');
        $this->db->where('t.status', $status);
        $this->db->order_by('t.created_at', 'DESC');
        
        if($limit) {
            $this->db->limit($limit);
        }
        
        return $this->db->get()->result();
    }

    public function get_trades_report($start_date = null, $end_date = null, $period = 'monthly') {
        $format = $period == 'daily' ? '%Y-%m-%d' : 
                 ($period == 'weekly' ? '%Y-%u' : '%Y-%m');
                 
        $sql = "SELECT 
                DATE_FORMAT(created_at, ?) as period,
                COUNT(*) as total,
                COUNT(CASE WHEN status = 'accepted' THEN 1 END) as accepted,
                COUNT(CASE WHEN status = 'rejected' THEN 1 END) as rejected,
                MIN(created_at) as min_date
                FROM trades";
                
        if($start_date && $end_date) {
            $sql .= " WHERE created_at BETWEEN ? AND ?";
        }
        
        $sql .= " GROUP BY period ORDER BY min_date ASC";
        
        $params = [$format];
        if($start_date && $end_date) {
            $params[] = $start_date;
            $params[] = $end_date;
        }
        
        return $this->db->query($sql, $params)->result();
    }

    public function get_trades_chart($user_id, $period = 'monthly') {
        $format = $period == 'daily' ? '%Y-%m-%d' : 
                 ($period == 'weekly' ? '%Y-%u' : '%Y-%m');
                 
        $sql = "SELECT DATE_FORMAT(created_at, ?) as period, 
                COUNT(*) as total,
                MIN(created_at) as min_date
                FROM trades 
                WHERE (requester_id = ? OR owner_id = ?)
                AND created_at >= DATE_SUB(NOW(), INTERVAL 1 YEAR)
                GROUP BY period
                ORDER BY min_date ASC";
                
        return $this->db->query($sql, [$format, $user_id, $user_id])->result();
    }

    public function get_completion_rate($user_id) {
        $total_trades = $this->count_user_trades($user_id);
        
        if($total_trades == 0) {
            return 0;
        }
        
        $completed_trades = $this->count_user_trades($user_id, 'accepted');
        
        return ($completed_trades / $total_trades) * 100;
    }

    public function get_trade_details($trade_id) {
        $this->db->select('t.*, 
                          rsc.name as requested_category,
                          osc.name as offered_category,
                          u1.username as requester_username,
                          u2.username as owner_username,
                          rus.image_path as requested_image,
                          ous.image_path as offered_image,
                          rs.number as requested_number,
                          os.number as offered_number')
            ->from('trades t')
            ->join('stickers rs', 'rs.id = t.requested_sticker_id')
            ->join('stickers os', 'os.id = t.offered_sticker_id')
            ->join('sticker_categories rsc', 'rsc.id = rs.category_id')
            ->join('sticker_categories osc', 'osc.id = os.category_id')
            ->join('users u1', 'u1.id = t.requester_id')
            ->join('users u2', 'u2.id = t.owner_id')
            ->join('user_stickers rus', 'rus.sticker_id = rs.id AND rus.user_id = t.owner_id', 'left')
            ->join('user_stickers ous', 'ous.sticker_id = os.id AND ous.user_id = t.requester_id', 'left')
            ->where('t.id', $trade_id);
        
        return $this->db->get()->row();
    }

    public function accept_trade($trade_id) {
        return $this->db->where('id', $trade_id)
            ->update('trades', [
                'status' => 'accepted',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

    public function reject_trade($trade_id) {
        return $this->db->where('id', $trade_id)
            ->update('trades', [
                'status' => 'rejected',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

    public function get_trade_messages($trade_id) {
        return $this->db->select('tm.*, u.username')
            ->from('trade_messages tm')
            ->join('users u', 'u.id = tm.user_id')
            ->where('tm.trade_id', $trade_id)
            ->order_by('tm.created_at', 'ASC')
            ->get()
            ->result();
    }

    public function add_message($data) {
        return $this->db->insert('trade_messages', $data);
    }

    public function get_trade_detail($trade_id) {
        return $this->db->select('trades.*, 
                                req_sticker.number as requested_number,
                                req_sticker.category_id as requested_category,
                                req_us.image_path as requested_image,
                                off_sticker.number as offered_number,
                                off_sticker.category_id as offered_category,
                                off_us.image_path as offered_image,
                                requester.username as requester_username,
                                owner.username as owner_username')
                        ->from('trades')
                        ->join('stickers as req_sticker', 'req_sticker.id = trades.requested_sticker_id')
                        ->join('stickers as off_sticker', 'off_sticker.id = trades.offered_sticker_id')
                        ->join('user_stickers as req_us', 'req_us.sticker_id = trades.requested_sticker_id AND req_us.user_id = trades.owner_id')
                        ->join('user_stickers as off_us', 'off_us.sticker_id = trades.offered_sticker_id AND off_us.user_id = trades.requester_id')
                        ->join('users as requester', 'requester.id = trades.requester_id')
                        ->join('users as owner', 'owner.id = trades.owner_id')
                        ->where('trades.id', $trade_id)
                        ->get()
                        ->row();
    }

    public function get_chat_messages($trade_id) {
        return $this->db->select('chat_messages.*, users.username')
                        ->from('chat_messages')
                        ->join('users', 'users.id = chat_messages.user_id')
                        ->where('trade_id', $trade_id)
                        ->order_by('created_at', 'ASC')
                        ->get()
                        ->result();
    }
} 