<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['category_model', 'sticker_model']);
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'file']);
        
        if (!$this->session->userdata('logged_in') || !$this->session->userdata('is_admin')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['title'] = 'Manajemen Kategori';
        $data['categories'] = $this->category_model->get_categories_with_stats();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/categories/index');
        $this->load->view('admin/templates/footer');
    }

    public function add() {
        $this->form_validation->set_rules('name', 'Nama Kategori', 'required|is_unique[sticker_categories.name]');
        $this->form_validation->set_rules('description', 'Deskripsi', 'required');
        
        if ($this->form_validation->run()) {
            $config['upload_path'] = './assets/images/categories/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = TRUE;
            
            $this->load->library('upload', $config);
            
            $data = [
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description')
            ];
            
            if ($this->upload->do_upload('icon')) {
                $upload_data = $this->upload->data();
                $data['icon'] = $upload_data['file_name'];
            }
            
            $result = $this->category_model->add_category($data);
            
            if ($result) {
                $this->session->set_flashdata('success', 'Kategori berhasil ditambahkan');
                redirect('admin/categories');
            }
        }
        
        $data['title'] = 'Tambah Kategori';
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/categories/form');
        $this->load->view('admin/templates/footer');
    }

    public function edit($id) {
        $category = $this->category_model->get_category($id);
        if (!$category) show_404();
        
        $this->form_validation->set_rules('name', 'Nama Kategori', 'required');
        if ($category->name != $this->input->post('name')) {
            $this->form_validation->set_rules('name', 'Nama Kategori', 'required|is_unique[sticker_categories.name]');
        }
        $this->form_validation->set_rules('description', 'Deskripsi', 'required');
        
        if ($this->form_validation->run()) {
            $data = [
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description')
            ];
            
            if ($_FILES['icon']['name']) {
                $config['upload_path'] = './assets/images/categories/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048;
                $config['encrypt_name'] = TRUE;
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('icon')) {
                    // Delete old icon
                    if ($category->icon && file_exists('./assets/images/categories/'.$category->icon)) {
                        unlink('./assets/images/categories/'.$category->icon);
                    }
                    
                    $upload_data = $this->upload->data();
                    $data['icon'] = $upload_data['file_name'];
                }
            }
            
            $result = $this->category_model->update_category($id, $data);
            
            if ($result) {
                $this->session->set_flashdata('success', 'Kategori berhasil diperbarui');
                redirect('admin/categories');
            }
        }
        
        $data['title'] = 'Edit Kategori';
        $data['category'] = $category;
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/categories/form');
        $this->load->view('admin/templates/footer');
    }

    public function delete($id) {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $result = $this->category_model->delete_category($id);
        if (!$result) {
            echo json_encode([
                'success' => false,
                'message' => 'Kategori tidak dapat dihapus karena masih memiliki sticker'
            ]);
            return;
        }
        
        echo json_encode(['success' => true]);
    }
} 