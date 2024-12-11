<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tradeable extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['sticker_model', 'trade_model']);
        $this->load->library('session');
        $this->load->helper('url');
        
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        
        $data['title'] = 'Sticker Dapat Ditukar';
        $data['tradeable_stickers'] = $this->sticker_model->get_tradeable_stickers($user_id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('tradeable/index');
        $this->load->view('templates/footer');
    }

    public function update_status() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $sticker_id = $this->input->post('sticker_id');
        $is_tradeable = $this->input->post('is_tradeable');
        $user_id = $this->session->userdata('user_id');
        
        $result = $this->sticker_model->update_tradeable_status($user_id, $sticker_id, $is_tradeable);
        echo json_encode(['success' => $result]);
    }

    public function set_minimum_quantity() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $sticker_id = $this->input->post('sticker_id');
        $min_quantity = $this->input->post('min_quantity');
        $user_id = $this->session->userdata('user_id');
        
        $result = $this->sticker_model->set_minimum_tradeable_quantity($user_id, $sticker_id, $min_quantity);
        echo json_encode(['success' => $result]);
    }
} 