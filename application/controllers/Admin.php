<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->check_admin();
        $this->load->model(['sticker_model', 'user_model', 'trade_model']);
    }
    
    public function index() {
        // Statistik untuk dashboard
        $data['total_users'] = $this->user_model->count_users();
        $data['total_stickers'] = $this->sticker_model->count_stickers();
        $data['total_categories'] = $this->sticker_model->count_categories();
        
        // Get daftar kategori dengan statistik
        $data['categories'] = $this->sticker_model->get_categories_with_stats();
        
        // Get statistik pertukaran
        $trade_stats = $this->trade_model->get_trade_stats();
        $data['total_trades'] = $trade_stats['total_trades'];
        $data['pending_trades'] = $trade_stats['pending_trades'];
        
        // Get user baru
        $data['recent_users'] = $this->user_model->get_recent_users(5);
        
        // Get progress koleksi user
        $data['collection_progress'] = $this->user_model->get_collection_progress_report();
        
        $this->load->view('admin/dashboard', $data);
    }
    
    public function collections() {
        $data['collections'] = $this->sticker_model->get_collections_with_progress();
        $this->load->view('admin/collections', $data);
    }
    
    public function add_collection() {
        $this->form_validation->set_rules('name', 'Nama Koleksi', 'required|trim');
        $this->form_validation->set_rules('description', 'Deskripsi', 'trim');
        
        if($this->form_validation->run() === FALSE) {
            $data['categories'] = $this->sticker_model->get_categories();
            $this->load->view('admin/add_collection', $data);
            return;
        }
        
        $collection_data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'category_id' => $this->input->post('category_id'),
            'created_at' => date('Y-m-d H:i:s')
        );
        
        if($this->sticker_model->add_collection($collection_data)) {
            $this->session->set_flashdata('success', 'Koleksi berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan koleksi');
        }
        
        redirect('admin/collections');
    }
    
    public function users() {
        $data['users'] = $this->user_model->get_all_users();
        $this->load->view('admin/users', $data);
    }
    
    public function trades() {
        $data['trades'] = $this->trade_model->get_all_trades();
        $this->load->view('admin/trades', $data);
    }
    
    public function reports() {
        // Get data untuk grafik
        $data['new_users'] = $this->user_model->get_new_users_report();
        $data['active_users'] = $this->user_model->get_active_users_report();
        $data['collection_progress'] = $this->user_model->get_collection_progress_report();
        
        $this->load->view('admin/reports', $data);
    }
    
    public function categories() {
        $data['categories'] = $this->sticker_model->get_categories_with_stats();
        $this->load->view('admin/categories', $data);
    }
    
    public function add_category() {
        // Validasi form menggunakan form_validation
        $this->form_validation->set_rules('name', 'Nama Kategori', 'required|trim');
        $this->form_validation->set_rules('description', 'Deskripsi', 'trim');
        
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/dashboard');
            return;
        }
        
        $name = $this->input->post('name', TRUE);
        
        // Cek duplikasi menggunakan model
        if ($this->sticker_model->get_category_by_name($name)) {
            $this->session->set_flashdata('error', 'Nama kategori sudah digunakan');
            redirect('admin/dashboard');
            return;
        }
        
        // Siapkan data dengan slug
        $data = [
            'name' => $name,
            'slug' => url_title($name, 'dash', TRUE),
            'description' => $this->input->post('description'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => null
        ];
        
        $this->db->trans_start();
        
        // Simpan kategori
        if ($this->sticker_model->add_category($data)) {
            $category_id = $this->db->insert_id();
            // Inisialisasi 9 slot stiker kosong
            $this->sticker_model->initialize_category_stickers($category_id);
            $this->session->set_flashdata('success', 'Kategori berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan kategori');
        }
        
        $this->db->trans_complete();
        
        if (!$this->db->trans_status()) {
            $this->session->set_flashdata('error', 'Gagal menambahkan kategori');
        }
        
        redirect('admin/dashboard');
    }
    
    public function fix_stickers() {
        $this->load->model('sticker_model');
        $this->sticker_model->fix_sticker_numbers();
        redirect('admin/stickers');
    }
} 