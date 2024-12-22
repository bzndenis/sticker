<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Collections extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->check_admin();
    }
    
    public function index() {
        $category_id = $this->input->get('category');
        $search = $this->input->get('search');
        
        $data['collections'] = $this->sticker_model->get_collections_with_stats($category_id, $search);
        $data['categories'] = $this->sticker_model->get_categories();
        $data['selected_category'] = $category_id;
        $data['search'] = $search;
        
        $this->load->view('admin/collections/index', $data);
    }
    
    public function add() {
        $this->form_validation->set_rules('name', 'Nama Koleksi', 'required|is_unique[sticker_collections.name]');
        $this->form_validation->set_rules('category_id', 'Kategori', 'required');
        
        if($this->form_validation->run() === FALSE) {
            $data['categories'] = $this->sticker_model->get_categories();
            $this->load->view('admin/collections/add', $data);
            return;
        }
        
        $collection_data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'category_id' => $this->input->post('category_id'),
            'total_stickers' => 0,
            'created_at' => date('Y-m-d H:i:s')
        );
        
        if($this->sticker_model->add_collection($collection_data)) {
            $this->session->set_flashdata('success', 'Koleksi berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menambahkan koleksi');
        }
        
        redirect('admin/collections');
    }
    
    public function edit($id) {
        $data['collection'] = $this->sticker_model->get_collection($id);
        if(!$data['collection']) {
            show_404();
            return;
        }
        
        $this->form_validation->set_rules('name', 'Nama Koleksi', 'required|callback_check_unique_name['.$id.']');
        $this->form_validation->set_rules('category_id', 'Kategori', 'required');
        
        if($this->form_validation->run() === FALSE) {
            $data['categories'] = $this->sticker_model->get_categories();
            $data['stickers'] = $this->sticker_model->get_collection_stickers($id);
            $this->load->view('admin/collections/edit', $data);
            return;
        }
        
        $collection_data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'category_id' => $this->input->post('category_id')
        );
        
        if($this->sticker_model->update_collection($id, $collection_data)) {
            $this->session->set_flashdata('success', 'Koleksi berhasil diperbarui');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui koleksi');
        }
        
        redirect('admin/collections');
    }
    
    public function delete($id) {
        $collection = $this->sticker_model->get_collection($id);
        if(!$collection) {
            show_404();
            return;
        }
        
        if($this->sticker_model->delete_collection($id)) {
            $this->session->set_flashdata('success', 'Koleksi berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus koleksi');
        }
        
        redirect('admin/collections');
    }
    
    public function check_unique_name($name, $id) {
        $existing = $this->db->where('name', $name)
                            ->where('id !=', $id)
                            ->get('sticker_collections')
                            ->row();
                            
        if($existing) {
            $this->form_validation->set_message('check_unique_name', 'Nama koleksi sudah digunakan');
            return FALSE;
        }
        return TRUE;
    }
} 