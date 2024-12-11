<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['user_model', 'sticker_model', 'trade_model']);
        $this->load->library(['session', 'form_validation']);
        $this->load->helper('url');
        
        if (!$this->session->userdata('logged_in') || !$this->session->userdata('is_admin')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['title'] = 'Manajemen User';
        $data['users'] = $this->user_model->get_all_users_with_stats();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/users/index');
        $this->load->view('admin/templates/footer');
    }

    public function view($id) {
        $user = $this->user_model->get_user_detail($id);
        if (!$user) show_404();
        
        $data['title'] = 'Detail User';
        $data['user'] = $user;
        $data['stats'] = [
            'total_stickers' => $this->sticker_model->count_owned_stickers($id),
            'total_trades' => $this->trade_model->count_total_trades($id),
            'success_trades' => $this->trade_model->count_success_trades($id)
        ];
        $data['recent_trades'] = $this->trade_model->get_recent_trades($id, 5);
        $data['owned_stickers'] = $this->sticker_model->get_user_stickers($id);
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/users/view');
        $this->load->view('admin/templates/footer');
    }

    public function edit($id) {
        $user = $this->user_model->get_user_detail($id);
        if (!$user) show_404();
        
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[4]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        
        if ($this->input->post('password')) {
            $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'matches[password]');
        }
        
        if ($this->form_validation->run()) {
            $update_data = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'is_admin' => $this->input->post('is_admin') ? 1 : 0
            ];
            
            if ($this->input->post('password')) {
                $update_data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            }
            
            $result = $this->user_model->update_user($id, $update_data);
            
            if ($result) {
                $this->session->set_flashdata('success', 'Data user berhasil diperbarui');
                redirect('admin/users');
            }
        }
        
        $data['title'] = 'Edit User';
        $data['user'] = $user;
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/users/edit');
        $this->load->view('admin/templates/footer');
    }

    public function delete($id) {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        // Cek apakah user memiliki pertukaran aktif
        $active_trades = $this->trade_model->count_active_trades($id);
        
        if ($active_trades > 0) {
            echo json_encode([
                'success' => false,
                'message' => 'User masih memiliki '.$active_trades.' pertukaran aktif'
            ]);
            return;
        }
        
        // Hapus data user
        $result = $this->user_model->delete_user($id);
        echo json_encode(['success' => $result]);
    }

    public function ban($id) {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $duration = $this->input->post('duration'); // dalam hari
        $reason = $this->input->post('reason');
        
        $ban_data = [
            'user_id' => $id,
            'reason' => $reason,
            'banned_until' => date('Y-m-d H:i:s', strtotime("+$duration days")),
            'banned_by' => $this->session->userdata('user_id'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $result = $this->user_model->ban_user($id, $ban_data);
        echo json_encode(['success' => $result]);
    }

    public function unban($id) {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $result = $this->user_model->unban_user($id);
        echo json_encode(['success' => $result]);
    }

    public function export_users() {
        $users = $this->user_model->get_all_users_with_stats();
        
        // Load library Excel
        require_once APPPATH . 'third_party/PHPExcel/PHPExcel.php';
        
        $objPHPExcel = new PHPExcel();
        
        // Set properties
        $objPHPExcel->getProperties()
                    ->setCreator("Admin")
                    ->setTitle("Data Users")
                    ->setDescription("Daftar semua user");
        
        // Add header
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Username')
                    ->setCellValue('B1', 'Email')
                    ->setCellValue('C1', 'Total Sticker')
                    ->setCellValue('D1', 'Total Trade')
                    ->setCellValue('E1', 'Status')
                    ->setCellValue('F1', 'Tanggal Bergabung');
        
        // Add data
        $row = 2;
        foreach($users as $user) {
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A'.$row, $user->username)
                        ->setCellValue('B'.$row, $user->email)
                        ->setCellValue('C'.$row, $user->total_stickers)
                        ->setCellValue('D'.$row, $user->total_trades)
                        ->setCellValue('E'.$row, $user->is_active ? 'Aktif' : 'Nonaktif')
                        ->setCellValue('F'.$row, date('d/m/Y', strtotime($user->created_at)));
            $row++;
        }
        
        // Set column width
        foreach(range('A','F') as $column) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }
        
        // Set header
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="data_users_'.date('Y-m-d').'.xlsx"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
} 