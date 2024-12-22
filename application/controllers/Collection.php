<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Collection extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('sticker_model');
        
        if(!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');

        // Get collection stats
        $data['stats'] = (object) [
            'total_stickers' => $this->sticker_model->count_user_stickers($user_id),
            'unique_stickers' => $this->sticker_model->count_unique_stickers($user_id),
            'tradeable_stickers' => $this->sticker_model->count_tradeable_stickers($user_id),
            'completion_rate' => $this->sticker_model->get_collection_completion_rate($user_id)
        ];

        // Get collections with progress
        $data['collections'] = $this->sticker_model->get_collections_with_progress($user_id);

        $this->load->view('collection/index', $data);
    }

    public function toggle_trade() {
        $sticker_id = $this->input->post('sticker_id');
        $status = $this->input->post('status');
        
        $result = $this->sticker_model->toggle_trade_status(
            $sticker_id, 
            $this->session->userdata('user_id'),
            $status
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => $result
            ]));
    }
} 