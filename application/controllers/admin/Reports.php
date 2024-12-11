<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['report_model', 'user_model']);
        $this->load->library(['session', 'form_validation']);
        $this->load->helper('url');
        
        if (!$this->session->userdata('logged_in') || !$this->session->userdata('is_admin')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['title'] = 'Manajemen Laporan';
        $data['reports'] = $this->report_model->get_all_reports();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/reports/index');
        $this->load->view('admin/templates/footer');
    }

    public function view($id) {
        $report = $this->report_model->get_report_detail($id);
        if (!$report) show_404();
        
        // Update status menjadi 'read' jika masih 'new'
        if ($report->status == 'new') {
            $this->report_model->update_report($id, ['status' => 'read']);
        }
        
        $data['title'] = 'Detail Laporan';
        $data['report'] = $report;
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/reports/view');
        $this->load->view('admin/templates/footer');
    }

    public function process($id) {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $this->form_validation->set_rules('response', 'Tanggapan', 'required');
        $this->form_validation->set_rules('action_taken', 'Tindakan', 'required');
        
        if ($this->form_validation->run()) {
            $data = [
                'response' => $this->input->post('response'),
                'action_taken' => $this->input->post('action_taken'),
                'processed_by' => $this->session->userdata('user_id'),
                'processed_at' => date('Y-m-d H:i:s'),
                'status' => 'processed'
            ];
            
            $result = $this->report_model->update_report($id, $data);
            
            if ($result) {
                // Jika ada tindakan ban user
                if ($this->input->post('ban_user')) {
                    $report = $this->report_model->get_report($id);
                    $ban_data = [
                        'user_id' => $report->reported_user_id,
                        'reason' => 'Banned berdasarkan laporan #'.$id.': '.$this->input->post('ban_reason'),
                        'duration' => $this->input->post('ban_duration'),
                        'banned_by' => $this->session->userdata('user_id'),
                        'banned_until' => date('Y-m-d H:i:s', strtotime('+'.$this->input->post('ban_duration').' days'))
                    ];
                    $this->user_model->ban_user($report->reported_user_id, $ban_data);
                }
                
                echo json_encode(['success' => true]);
                return;
            }
        }
        
        echo json_encode([
            'success' => false,
            'message' => validation_errors()
        ]);
    }

    public function delete($id) {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $result = $this->report_model->delete_report($id);
        echo json_encode(['success' => $result]);
    }

    public function bulk_action() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $ids = $this->input->post('ids');
        $action = $this->input->post('action');
        
        if (!$ids || !$action) {
            echo json_encode([
                'success' => false,
                'message' => 'Parameter tidak lengkap'
            ]);
            return;
        }
        
        $success = 0;
        $failed = 0;
        
        foreach ($ids as $id) {
            switch ($action) {
                case 'mark_read':
                    if ($this->report_model->update_report($id, ['status' => 'read'])) {
                        $success++;
                    } else {
                        $failed++;
                    }
                    break;
                    
                case 'delete':
                    if ($this->report_model->delete_report($id)) {
                        $success++;
                    } else {
                        $failed++;
                    }
                    break;
            }
        }
        
        echo json_encode([
            'success' => true,
            'message' => "Berhasil: $success, Gagal: $failed"
        ]);
    }
} 