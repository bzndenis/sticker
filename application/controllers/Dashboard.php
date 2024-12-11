<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['sticker_model', 'trade_model']);
        $this->load->library('session');
        $this->load->helper(['url', 'trade']);
        
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        
        $data['title'] = 'Dashboard';
        $data['stats'] = [
            'total_stickers' => $this->sticker_model->count_all_stickers(),
            'owned_stickers' => $this->sticker_model->count_owned_stickers($user_id),
            'tradeable_stickers' => $this->sticker_model->count_tradeable_stickers($user_id),
            'pending_trades' => $this->trade_model->count_pending_trades($user_id)
        ];
        
        $data['recent_activities'] = $this->sticker_model->get_recent_activities($user_id, 5);
        $data['category_progress'] = $this->sticker_model->get_category_progress($user_id);
        $data['trade_history'] = $this->trade_model->get_recent_trades($user_id, 5);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('dashboard/index');
        $this->load->view('templates/footer');
    }

    public function get_notifications() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $user_id = $this->session->userdata('user_id');
        $this->load->model('notification_model');
        
        $notifications = $this->notification_model->get_unread_notifications($user_id);
        echo json_encode(['notifications' => $notifications]);
    }
} 