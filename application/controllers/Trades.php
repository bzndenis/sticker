<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trades extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->check_login();
        $this->load->model(['trade_model', 'sticker_model']);
    }

    public function get_tradeable_stickers() {
        $user_id = $this->session->userdata('user_id');
        $stickers = $this->sticker_model->get_tradeable_stickers($user_id);
        
        // Debug log
        log_message('debug', 'Tradeable stickers for user ' . $user_id . ': ' . print_r($stickers, true));
        
        header('Content-Type: application/json');
        echo json_encode($stickers);
    }
} 