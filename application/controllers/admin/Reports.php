<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->check_admin();
    }
    
    public function index() {
        $period = $this->input->get('period') ?: 'monthly';
        $start_date = $this->input->get('start_date') ?: date('Y-m-d', strtotime('-1 year'));
        $end_date = $this->input->get('end_date') ?: date('Y-m-d');
        
        // Statistik umum
        $data['total_users'] = $this->user_model->count_users();
        $data['total_collections'] = $this->sticker_model->count_collections();
        $data['total_stickers'] = $this->sticker_model->count_stickers();
        $data['total_trades'] = $this->trade_model->count_trades();
        
        // Laporan pengguna baru
        $data['new_users'] = $this->user_model->get_new_users_report($period);
        
        // Laporan pengguna aktif
        $data['active_users'] = $this->user_model->get_active_users_report($period);
        
        // Laporan pertukaran
        $data['trades'] = $this->trade_model->get_trades_report($start_date, $end_date, $period);
        
        // Progress koleksi pengguna
        $data['collection_progress'] = $this->user_model->get_collection_progress_report();
        
        // Parameter laporan
        $data['period'] = $period;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        
        $this->load->view('admin/reports/index', $data);
    }
    
    public function export_users() {
        $format = $this->input->post('format');
        $fields = $this->input->post('fields');
        
        if(!$format || !$fields) {
            $this->session->set_flashdata('error', 'Parameter export tidak valid');
            redirect('admin/users');
            return;
        }
        
        $users = $this->user_model->get_users_for_export($fields);
        $filename = 'users_export_' . date('Y-m-d_His');
        
        if($format === 'csv') {
            $this->export_to_csv($users, $fields, $filename);
        } else if($format === 'excel') {
            $this->export_to_excel($users, $fields, $filename);
        } else {
            $this->session->set_flashdata('error', 'Format file tidak valid');
            redirect('admin/users');
        }
    }
    
    private function export_to_csv($data, $fields, $filename) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'.csv"');
        
        $output = fopen('php://output', 'w');
        
        // Header baris pertama
        $header = array_map(function($field) {
            return ucwords(str_replace('_', ' ', $field));
        }, $fields);
        fputcsv($output, $header);
        
        // Data
        foreach($data as $row) {
            $line = array_map(function($field) use ($row) {
                if($field === 'created_at' || $field === 'last_login') {
                    return $row->$field ? date('d M Y H:i', strtotime($row->$field)) : '-';
                }
                return $row->$field;
            }, $fields);
            fputcsv($output, $line);
        }
        
        fclose($output);
        exit;
    }
    
    private function export_to_excel($data, $fields, $filename) {
        require_once APPPATH . 'third_party/PHPExcel/PHPExcel.php';
        
        $excel = new PHPExcel();
        $excel->setActiveSheetIndex(0);
        $sheet = $excel->getActiveSheet();
        
        // Header
        $col = 0;
        foreach($fields as $field) {
            $sheet->setCellValueByColumnAndRow($col, 1, ucwords(str_replace('_', ' ', $field)));
            $col++;
        }
        
        // Data
        $row = 2;
        foreach($data as $item) {
            $col = 0;
            foreach($fields as $field) {
                $value = $item->$field;
                if($field === 'created_at' || $field === 'last_login') {
                    $value = $value ? date('d M Y H:i', strtotime($value)) : '-';
                }
                $sheet->setCellValueByColumnAndRow($col, $row, $value);
                $col++;
            }
            $row++;
        }
        
        // Auto-size kolom
        foreach(range(0, count($fields)-1) as $col) {
            $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
        }
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');
        
        $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $writer->save('php://output');
        exit;
    }
} 