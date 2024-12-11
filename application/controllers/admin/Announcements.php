<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcements extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('announcement_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper('url');
        
        if (!$this->session->userdata('logged_in') || !$this->session->userdata('is_admin')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['title'] = 'Manajemen Pengumuman';
        $data['announcements'] = $this->announcement_model->get_all_announcements();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/announcements/index');
        $this->load->view('admin/templates/footer');
    }

    public function add() {
        $this->form_validation->set_rules('title', 'Judul', 'required');
        $this->form_validation->set_rules('content', 'Konten', 'required');
        $this->form_validation->set_rules('type', 'Tipe', 'required');
        $this->form_validation->set_rules('start_date', 'Tanggal Mulai', 'required');
        
        if ($this->form_validation->run()) {
            $data = [
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'type' => $this->input->post('type'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date') ?: NULL,
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'created_by' => $this->session->userdata('user_id'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $result = $this->announcement_model->add_announcement($data);
            
            if ($result) {
                $this->session->set_flashdata('success', 'Pengumuman berhasil ditambahkan');
                redirect('admin/announcements');
            }
        }
        
        $data['title'] = 'Tambah Pengumuman';
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/announcements/form');
        $this->load->view('admin/templates/footer');
    }

    public function edit($id) {
        $announcement = $this->announcement_model->get_announcement($id);
        if (!$announcement) show_404();
        
        $this->form_validation->set_rules('title', 'Judul', 'required');
        $this->form_validation->set_rules('content', 'Konten', 'required');
        $this->form_validation->set_rules('type', 'Tipe', 'required');
        $this->form_validation->set_rules('start_date', 'Tanggal Mulai', 'required');
        
        if ($this->form_validation->run()) {
            $data = [
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'type' => $this->input->post('type'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date') ?: NULL,
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $result = $this->announcement_model->update_announcement($id, $data);
            
            if ($result) {
                $this->session->set_flashdata('success', 'Pengumuman berhasil diperbarui');
                redirect('admin/announcements');
            }
        }
        
        $data['title'] = 'Edit Pengumuman';
        $data['announcement'] = $announcement;
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/announcements/form');
        $this->load->view('admin/templates/footer');
    }

    public function delete($id) {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $result = $this->announcement_model->delete_announcement($id);
        echo json_encode(['success' => $result]);
    }

    public function toggle_status($id) {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $status = $this->input->post('status');
        $result = $this->announcement_model->update_announcement($id, ['is_active' => $status]);
        echo json_encode(['success' => $result]);
    }
} 