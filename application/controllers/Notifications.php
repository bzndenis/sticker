<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'time']);
    }

    public function index() {
        if (!$this->check_login()) return;

        $data['title'] = 'Notifikasi';
        $data['notifications'] = $this->notification_model->get_user_notifications($this->user_id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('notifications/index', $data);
        $this->load->view('templates/footer');
    }

    public function mark_all_read() {
        if (!$this->check_login(false)) return;
        $this->notification_model->mark_all_read($this->user_id);
        echo json_encode(['status' => 'success']);
    }

    public function delete_all() {
        if (!$this->check_login(false)) return;
        $this->notification_model->delete_all($this->user_id);
        echo json_encode(['status' => 'success']);
    }
} 