<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['sticker_model', 'trade_model', 'collection_model']);
    }
    
    public function index() {
        $this->check_login();
        
        $data = [
            'title' => 'Dashboard',
            'unread_notifications' => $this->notification_model->get_unread_notifications_count($this->user_id),
            
            // Total stiker yang dimiliki user
            'total_stickers' => $this->sticker_model->count_user_stickers($this->user_id),
            
            // Total pertukaran yang dilakukan
            'total_trades' => $this->trade_model->count_user_trades($this->user_id),
            
            // Data koleksi
            'total_collections' => $this->collection_model->count_user_collections($this->user_id),
            'collections' => $this->collection_model->get_user_collections($this->user_id),
            
            // Hitung progress koleksi keseluruhan
            'collection_progress' => $this->collection_model->calculate_total_progress($this->user_id)
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function get_chart_data() {
        if(!$this->input->is_ajax_request()) {
            show_404();
            return;
        }
        
        $user_id = $this->session->userdata('user_id');
        $period = $this->input->get('period') ?: 'monthly';
        
        // Validasi period
        if(!in_array($period, ['daily', 'weekly', 'monthly'])) {
            $period = 'monthly';
        }
        
        // Get data untuk chart
        $sticker_data = $this->sticker_model->get_user_stickers_chart($user_id, $period);
        $trade_data = $this->trade_model->get_trades_chart($user_id, $period);
        
        // Format data untuk chart
        $formatted_data = [
            'labels' => [],
            'stickers' => [],
            'trades' => []
        ];
        
        // Format sticker data
        foreach($sticker_data as $item) {
            $formatted_data['labels'][] = $this->format_period_label($item->period, $period);
            $formatted_data['stickers'][] = (int)$item->total;
        }
        
        // Format trade data
        foreach($trade_data as $item) {
            if(!in_array($this->format_period_label($item->period, $period), $formatted_data['labels'])) {
                $formatted_data['labels'][] = $this->format_period_label($item->period, $period);
            }
            $formatted_data['trades'][] = (int)$item->total;
        }
        
        // Sort labels chronologically
        sort($formatted_data['labels']);
        
        $this->output->set_content_type('application/json');
        echo json_encode([
            'success' => true,
            'data' => $formatted_data
        ]);
    }
    
    private function format_period_label($period, $type) {
        switch($type) {
            case 'daily':
                return date('d M', strtotime($period));
            case 'weekly':
                $year = substr($period, 0, 4);
                $week = substr($period, -2);
                $dto = new DateTime();
                $dto->setISODate($year, $week);
                return $dto->format('d M');
            case 'monthly':
                return date('M Y', strtotime($period . '-01'));
            default:
                return $period;
        }
    }
    
    private function calculate_collection_progress($user_id) {
        $collections = $this->collection_model->get_user_collections($user_id);
        if (empty($collections)) {
            return 0;
        }

        $total_progress = 0;
        foreach ($collections as $collection) {
            $owned_stickers = $this->sticker_model->count_collection_stickers($collection->id, $user_id);
            $total_stickers = $collection->total_stickers;
            
            if ($total_stickers > 0) {
                $total_progress += ($owned_stickers / $total_stickers) * 100;
            }
        }

        return number_format($total_progress / count($collections), 1);
    }
} 