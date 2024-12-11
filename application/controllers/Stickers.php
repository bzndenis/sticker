<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stickers extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('sticker_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        // Cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['categories'] = $this->sticker_model->get_categories();
        $data['title'] = 'Kategori Sticker';
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('stickers/categories');
        $this->load->view('templates/footer');
    }

    public function list($category_id) {
        $data['stickers'] = $this->sticker_model->get_stickers_by_category($category_id);
        $data['category'] = $this->sticker_model->get_category($category_id);
        $data['title'] = 'Daftar Sticker ' . $data['category']->name;
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('stickers/list');
        $this->load->view('templates/footer');
    }

    public function update_ownership() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $sticker_id = $this->input->post('sticker_id');
        $user_id = $this->session->userdata('user_id');
        
        // Cek apakah sudah ada di user_stickers
        $existing = $this->db->get_where('user_stickers', [
            'user_id' => $user_id,
            'sticker_id' => $sticker_id
        ])->row();
        
        if ($existing) {
            // Update quantity
            $this->db->where('id', $existing->id);
            $this->db->update('user_stickers', ['quantity' => $existing->quantity + 1]);
        } else {
            // Insert baru
            $this->db->insert('user_stickers', [
                'user_id' => $user_id,
                'sticker_id' => $sticker_id,
                'quantity' => 1
            ]);
        }
        
        echo json_encode(['success' => true]);
    }
}