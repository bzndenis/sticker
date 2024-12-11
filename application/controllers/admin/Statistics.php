<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistics extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['sticker_model', 'trade_model', 'user_model']);
        $this->load->library(['session']);
        $this->load->helper(['url', 'date']);
        
        if (!$this->session->userdata('logged_in') || !$this->session->userdata('is_admin')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['title'] = 'Statistik';
        
        // Statistik umum
        $data['general_stats'] = [
            'total_users' => $this->user_model->count_all_users(),
            'total_stickers' => $this->sticker_model->count_all_stickers(),
            'total_trades' => $this->trade_model->count_all_trades(),
            'success_trades' => $this->trade_model->count_success_trades()
        ];
        
        // Statistik per kategori
        $data['category_stats'] = $this->sticker_model->get_category_statistics();
        
        // Statistik pertukaran bulanan
        $data['monthly_trades'] = $this->trade_model->get_monthly_statistics();
        
        // Top users
        $data['top_collectors'] = $this->user_model->get_top_collectors(5);
        $data['top_traders'] = $this->user_model->get_top_traders(5);
        
        // Sticker terpopuler
        $data['popular_stickers'] = $this->sticker_model->get_popular_stickers(5);
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/statistics/index');
        $this->load->view('admin/templates/footer');
    }

    public function export_report() {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        
        // Validasi tanggal
        if (!$start_date || !$end_date) {
            $this->session->set_flashdata('error', 'Tanggal awal dan akhir harus diisi');
            redirect('admin/statistics');
        }
        
        $data['period'] = [
            'start' => $start_date,
            'end' => $end_date
        ];
        
        // Ambil data statistik sesuai periode
        $data['trade_stats'] = $this->trade_model->get_trade_statistics_by_period($start_date, $end_date);
        $data['user_stats'] = $this->user_model->get_user_statistics_by_period($start_date, $end_date);
        $data['sticker_stats'] = $this->sticker_model->get_sticker_statistics_by_period($start_date, $end_date);
        
        // Load library PDF
        $this->load->library('pdf');
        
        // Generate PDF
        $html = $this->load->view('admin/statistics/report_pdf', $data, true);
        $this->pdf->createPDF($html, 'laporan_statistik_'.date('Y-m-d'), true);
    }

    public function get_chart_data() {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $type = $this->input->get('type');
        $period = $this->input->get('period');
        
        switch($type) {
            case 'trades':
                $data = $this->trade_model->get_trade_chart_data($period);
                break;
            case 'users':
                $data = $this->user_model->get_user_chart_data($period);
                break;
            case 'stickers':
                $data = $this->sticker_model->get_sticker_chart_data($period);
                break;
            default:
                $data = [];
        }
        
        echo json_encode($data);
    }
} 