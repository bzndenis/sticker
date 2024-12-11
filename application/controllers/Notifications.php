<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('notification_model');
        $this->load->library('session');
        $this->load->helper('url');
        
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        
        $data['title'] = 'Notifikasi';
        $data['notifications'] = $this->notification_model->get_user_notifications($user_id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('notifications/index');
        $this->load->view('templates/footer');
    }

    public function mark_as_read() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $notification_id = $this->input->post('notification_id');
        $user_id = $this->session->userdata('user_id');
        
        $result = $this->notification_model->mark_as_read($notification_id, $user_id);
        echo json_encode(['success' => $result]);
    }

    public function get_unread_count() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $user_id = $this->session->userdata('user_id');
        $count = $this->notification_model->get_unread_count($user_id);
        
        echo json_encode(['count' => $count]);
    }
} 