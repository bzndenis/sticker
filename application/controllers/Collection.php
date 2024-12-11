<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Collection extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('sticker_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        
        $data['title'] = 'Koleksi Saya';
        $data['categories'] = $this->sticker_model->get_categories();
        $data['collection'] = $this->sticker_model->get_user_collection($user_id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('collection/index');
        $this->load->view('templates/footer');
    }

    public function update_quantity() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $sticker_id = $this->input->post('sticker_id');
        $quantity = $this->input->post('quantity');
        $user_id = $this->session->userdata('user_id');
        
        $result = $this->sticker_model->update_sticker_quantity($user_id, $sticker_id, $quantity);
        echo json_encode(['success' => $result]);
    }
} 