<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    
    protected $user_id = null;
    protected $is_logged_in = false;

    public function __construct() {
        parent::__construct();
        
        // Inisialisasi status login
        $this->is_logged_in = (bool) $this->session->userdata('logged_in');
        $this->user_id = $this->session->userdata('user_id');
        
        // Load model yang sering digunakan
        $this->load->model(['user_model', 'notification_model']);
    }

    protected function check_login($redirect = true) {
        if (!$this->is_logged_in) {
            if ($this->input->is_ajax_request()) {
                $this->output->set_status_header(401);
                echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
                exit;
            } else if ($redirect) {
                // Simpan URL yang dicoba diakses
                $this->session->set_userdata('redirect_url', current_url());
                redirect('auth/login');
            }
            return false;
        }
        return true;
    }
} 