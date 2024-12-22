<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Collections extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->check_login();
        $this->load->model(['sticker_model', 'user_model']);
        $this->load->library('image_handler');
    }
    
    public function index() {
        $user_id = $this->session->userdata('user_id');
        
        // Get semua kategori dengan progress
        $collections = $this->sticker_model->get_collections_with_progress($user_id);
        
        // Format data untuk view
        foreach($collections as $collection) {
            $collection->owned_count = $collection->owned; // Sesuaikan dengan nama properti yang digunakan di view
            $collection->total_count = $collection->total; // Jika diperlukan
        }
        
        $data['collections'] = $collections;
        
        // Get kategori untuk filter
        $data['categories'] = $this->sticker_model->get_categories();
        
        $this->load->view('collections/index', $data);
    }
    
    public function view($id) {
        $user_id = $this->session->userdata('user_id');
        
        // Get kategori
        $data['category'] = $this->sticker_model->get_category($id);
        if(!$data['category']) {
            show_404();
            return;
        }
        
        // Get stiker dalam kategori dengan info kepemilikan
        $data['stickers'] = $this->sticker_model->get_category_stickers($id, $user_id);
        
        // Tambahkan ini - gunakan category bukan collection
        $data['category']->total_stickers = $this->sticker_model->get_total_stickers($id);
        
        $this->load->view('collections/view', $data);
    }
    
    public function manage($id) {
        $user_id = $this->session->userdata('user_id');
        
        // Get kategori
        $data['category'] = $this->sticker_model->get_category($id);
        if(!$data['category']) {
            show_404();
            return;
        }
        
        // Get stiker dan quantities
        $result = $this->sticker_model->get_category_stickers($id, $user_id);
        $data['sticker'] = $result['sticker'];
        $data['quantities'] = $result['quantities'];
        
        $this->load->view('collections/manage', $data);
    }
    
    public function upload_sticker() {
        $category_id = $this->input->post('category_id');
        $quantities = $this->input->post('quantities');
        $user_id = $this->session->userdata('user_id');
        
        // Validasi perubahan quantity
        $existing_quantities = $this->sticker_model->get_category_stickers($category_id, $user_id);
        $has_changes = false;
        
        foreach($quantities as $number => $quantity) {
            $old_quantity = isset($existing_quantities['quantities'][$number]) ? 
                           $existing_quantities['quantities'][$number] : 0;
            if($quantity != $old_quantity) {
                $has_changes = true;
                break;
            }
        }
        
        // Jika ada perubahan quantity, harus ada upload gambar
        if($has_changes && empty($_FILES['image']['name'])) {
            $this->session->set_flashdata('error', 'Anda harus mengupload gambar stiker ketika mengubah jumlah');
            redirect('collections/manage/'.$category_id);
            return;
        }
        
        // Validasi kategori
        $category = $this->sticker_model->get_category($category_id);
        if(!$category) {
            show_404();
            return;
        }
        
        // Get existing sticker
        $existing_sticker = $this->sticker_model->get_category_stickers($category_id);
        
        // Jika ada upload gambar baru
        $image_data = null;
        if(!empty($_FILES['image']['name'])) {
            $config['upload_path'] = './uploads/stickers/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
            
            $this->load->library('upload', $config);
            
            if(!$this->upload->do_upload('image')) {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('collections/manage/'.$category_id);
                return;
            }
            
            $upload_data = $this->upload->data();
            $image_data = [
                'file_name' => $upload_data['file_name'],
                'image_hash' => md5_file($upload_data['full_path'])
            ];
        }
        
        // Update quantities untuk setiap nomor stiker
        if($existing_sticker['sticker']) {
            $this->db->trans_start();
            
            foreach($quantities as $number => $quantity) {
                if($quantity > 0) {
                    $this->user_model->update_sticker_quantity(
                        $user_id,
                        $existing_sticker['sticker']->id,
                        $number,
                        $quantity,
                        $image_data
                    );
                }
            }
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                if($image_data) {
                    unlink('./uploads/stickers/'.$image_data['file_name']);
                }
                $this->session->set_flashdata('error', 'Gagal menyimpan data stiker');
            } else {
                $this->session->set_flashdata('success', 'Stiker berhasil disimpan');
            }
        }
        
        redirect('collections/manage/'.$category_id);
    }
    
    public function update_quantity() {
        if(!$this->input->is_ajax_request()) {
            show_404();
            return;
        }
        
        $user_id = $this->session->userdata('user_id');
        $sticker_id = $this->input->post('sticker_id');
        $quantity = $this->input->post('quantity');
        
        $result = $this->sticker_model->update_sticker_quantity($user_id, $sticker_id, $quantity);
        
        echo json_encode(['success' => $result]);
    }
} 