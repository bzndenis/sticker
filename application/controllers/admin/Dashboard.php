<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->check_admin();
        $this->load->model(['sticker_model', 'user_model', 'trade_model']);
    }
    
    public function index() {
        // Get statistik
        $data['total_categories'] = $this->sticker_model->count_categories();
        $data['total_stickers'] = $this->sticker_model->count_stickers();
        $data['total_users'] = $this->user_model->count_users();
        $data['total_trades'] = $this->trade_model->count_trades();
        
        // Get daftar kategori dengan progress
        $data['categories'] = $this->sticker_model->get_categories_with_progress();
        
        $this->load->view('admin/dashboard', $data);
    }
} 