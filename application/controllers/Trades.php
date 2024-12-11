<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trades extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['sticker_model', 'trade_model']);
        $this->load->library('session');
        $this->load->helper('url');
        
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function requests() {
        $user_id = $this->session->userdata('user_id');
        
        $data['title'] = 'Permintaan Tukar';
        $data['incoming_requests'] = $this->trade_model->get_incoming_requests($user_id);
        $data['outgoing_requests'] = $this->trade_model->get_outgoing_requests($user_id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('trades/requests');
        $this->load->view('templates/footer');
    }

    public function create_request() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $sticker_id = $this->input->post('sticker_id');
        $owner_id = $this->input->post('owner_id');
        $message = $this->input->post('message');
        $requester_id = $this->session->userdata('user_id');
        
        $result = $this->trade_model->create_trade_request($requester_id, $owner_id, $sticker_id, $message);
        echo json_encode(['success' => $result]);
    }

    public function update_request_status() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $request_id = $this->input->post('request_id');
        $status = $this->input->post('status');
        $user_id = $this->session->userdata('user_id');
        
        $result = $this->trade_model->update_request_status($request_id, $status, $user_id);
        echo json_encode(['success' => $result]);
    }

    public function history() {
        $user_id = $this->session->userdata('user_id');
        
        $data['title'] = 'Riwayat Pertukaran';
        $data['trades'] = $this->trade_model->get_trade_history($user_id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('trades/history');
        $this->load->view('templates/footer');
    }

    public function delete_history($id) {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $user_id = $this->session->userdata('user_id');
        $result = $this->trade_model->delete_trade_history($id, $user_id);
        
        echo json_encode(['success' => $result]);
    }

    public function search($sticker_id) {
        $data['title'] = 'Cari Pemilik Sticker';
        $data['sticker'] = $this->sticker_model->get_sticker_detail($sticker_id);
        $data['owners'] = $this->trade_model->get_sticker_owners($sticker_id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('trades/search');
        $this->load->view('templates/footer');
    }
} 