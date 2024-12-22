<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trades extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->check_admin();
    }
    
    public function index() {
        $status = $this->input->get('status');
        
        switch($status) {
            case 'pending':
                $data['trades'] = $this->trade_model->get_all_pending_trades();
                break;
            case 'completed':
                $data['trades'] = $this->trade_model->get_all_completed_trades();
                break;
            case 'rejected':
                $data['trades'] = $this->trade_model->get_all_rejected_trades();
                break;
            default:
                $data['trades'] = $this->trade_model->get_all_trades();
        }
        
        $data['selected_status'] = $status;
        $data['trade_stats'] = $this->trade_model->get_trade_stats();
        
        $this->load->view('admin/trades/index', $data);
    }
    
    public function view($id) {
        $data['trade'] = $this->trade_model->get_trade($id);
        if(!$data['trade']) {
            show_404();
            return;
        }
        
        // Get chat messages
        $data['chat_messages'] = $this->chat_model->get_messages($id);
        
        $this->load->view('admin/trades/view', $data);
    }
    
    public function delete($id) {
        $trade = $this->trade_model->get_trade($id);
        if(!$trade) {
            show_404();
            return;
        }
        
        // Hapus chat messages
        $this->db->where('trade_request_id', $id)->delete('chat_messages');
        
        // Hapus notifications
        $this->db->where('trade_request_id', $id)->delete('notifications');
        
        // Hapus trade request
        $this->db->where('id', $id)->delete('trade_requests');
        
        $this->session->set_flashdata('success', 'Pertukaran berhasil dihapus');
        redirect('admin/trades');
    }
    
    public function export() {
        $start_date = $this->input->post('start_date') ?: date('Y-m-d', strtotime('-1 month'));
        $end_date = $this->input->post('end_date') ?: date('Y-m-d');
        
        $trades = $this->trade_model->get_trades_report($start_date, $end_date, 'daily');
        $filename = 'trades_export_' . date('Y-m-d_His');
        
        // Export ke CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'.csv"');
        
        $output = fopen('php://output', 'w');
        
        // Header
        fputcsv($output, ['Tanggal', 'Total', 'Diterima', 'Ditolak', 'Pending']);
        
        // Data
        foreach($trades as $trade) {
            fputcsv($output, [
                $trade->period,
                $trade->total,
                $trade->accepted,
                $trade->rejected,
                $trade->pending
            ]);
        }
        
        fclose($output);
        exit;
    }
} 