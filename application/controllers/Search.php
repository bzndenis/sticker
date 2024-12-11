<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['sticker_model', 'trade_model']);
        $this->load->library('session');
        $this->load->helper(['url', 'trade']);
        
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $keyword = $this->input->get('keyword');
        $category = $this->input->get('category');
        $status = $this->input->get('status'); // owned/needed/tradeable
        $user_id = $this->session->userdata('user_id');
        
        $data['title'] = 'Cari Sticker';
        $data['categories'] = $this->sticker_model->get_categories();
        $data['results'] = [];
        
        if ($keyword || $category || $status) {
            $data['results'] = $this->sticker_model->search_stickers([
                'keyword' => $keyword,
                'category' => $category,
                'status' => $status,
                'user_id' => $user_id
            ]);
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('search/index');
        $this->load->view('templates/footer');
    }

    public function ajax_search() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $keyword = $this->input->get('keyword');
        $user_id = $this->session->userdata('user_id');
        
        $results = $this->sticker_model->quick_search_stickers($keyword, $user_id);
        echo json_encode(['results' => $results]);
    }
} 