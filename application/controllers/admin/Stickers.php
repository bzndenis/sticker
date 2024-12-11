<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stickers extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('sticker_model');
        $this->load->library(['session', 'form_validation', 'upload']);
        $this->load->helper(['url', 'file']);
        
        if (!$this->session->userdata('logged_in') || !$this->session->userdata('is_admin')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['title'] = 'Manajemen Sticker';
        $data['stickers'] = $this->sticker_model->get_all_stickers();
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/stickers/index');
        $this->load->view('admin/templates/footer');
    }

    public function add() {
        $data['title'] = 'Tambah Sticker';
        $data['categories'] = $this->sticker_model->get_categories();
        
        $this->form_validation->set_rules('name', 'Nama Sticker', 'required|is_unique[stickers.name]');
        $this->form_validation->set_rules('category_id', 'Kategori', 'required');
        $this->form_validation->set_rules('description', 'Deskripsi', 'required');
        
        if ($this->form_validation->run()) {
            // Konfigurasi upload gambar
            $config['upload_path'] = './assets/images/stickers/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = TRUE;
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('image')) {
                $upload_data = $this->upload->data();
                
                $data = [
                    'name' => $this->input->post('name'),
                    'category_id' => $this->input->post('category_id'),
                    'description' => $this->input->post('description'),
                    'image' => $upload_data['file_name'],
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                $result = $this->sticker_model->add_sticker($data);
                
                if ($result) {
                    $this->session->set_flashdata('success', 'Sticker berhasil ditambahkan');
                    redirect('admin/stickers');
                }
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
            }
        }
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/stickers/form');
        $this->load->view('admin/templates/footer');
    }

    public function edit($id) {
        $sticker = $this->sticker_model->get_sticker($id);
        if (!$sticker) show_404();
        
        $data['title'] = 'Edit Sticker';
        $data['sticker'] = $sticker;
        $data['categories'] = $this->sticker_model->get_categories();
        
        $this->form_validation->set_rules('name', 'Nama Sticker', 'required');
        $this->form_validation->set_rules('category_id', 'Kategori', 'required');
        $this->form_validation->set_rules('description', 'Deskripsi', 'required');
        
        if ($this->form_validation->run()) {
            $update_data = [
                'name' => $this->input->post('name'),
                'category_id' => $this->input->post('category_id'),
                'description' => $this->input->post('description'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            // Jika ada upload gambar baru
            if ($_FILES['image']['name']) {
                $config['upload_path'] = './assets/images/stickers/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 2048;
                $config['encrypt_name'] = TRUE;
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('image')) {
                    // Hapus gambar lama
                    if ($sticker->image && file_exists('./assets/images/stickers/'.$sticker->image)) {
                        unlink('./assets/images/stickers/'.$sticker->image);
                    }
                    
                    $upload_data = $this->upload->data();
                    $update_data['image'] = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('admin/stickers/edit/'.$id);
                }
            }
            
            $result = $this->sticker_model->update_sticker($id, $update_data);
            
            if ($result) {
                $this->session->set_flashdata('success', 'Sticker berhasil diperbarui');
                redirect('admin/stickers');
            }
        }
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/stickers/form');
        $this->load->view('admin/templates/footer');
    }

    public function delete($id) {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $sticker = $this->sticker_model->get_sticker($id);
        
        if ($sticker) {
            // Hapus gambar
            if ($sticker->image && file_exists('./assets/images/stickers/'.$sticker->image)) {
                unlink('./assets/images/stickers/'.$sticker->image);
            }
            
            $result = $this->sticker_model->delete_sticker($id);
            echo json_encode(['success' => $result]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function bulk_upload() {
        if ($this->input->post('submit')) {
            $config['upload_path'] = './assets/temp/';
            $config['allowed_types'] = 'xlsx|xls';
            $config['max_size'] = 2048;
            
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('excel_file')) {
                $upload_data = $this->upload->data();
                
                // Proses file Excel
                require_once APPPATH . 'third_party/PHPExcel/PHPExcel.php';
                
                $file = $upload_data['full_path'];
                $objPHPExcel = PHPExcel_IOFactory::load($file);
                $sheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                
                $success = 0;
                $failed = 0;
                
                // Mulai dari baris kedua (header di baris pertama)
                for ($i = 2; $i <= count($sheet); $i++) {
                    $data = [
                        'name' => $sheet[$i]['A'],
                        'category_id' => $sheet[$i]['B'],
                        'description' => $sheet[$i]['C'],
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    
                    if ($this->sticker_model->add_sticker($data)) {
                        $success++;
                    } else {
                        $failed++;
                    }
                }
                
                unlink($file);
                
                $this->session->set_flashdata('success', "Berhasil mengimpor $success sticker. Gagal: $failed");
                redirect('admin/stickers');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
            }
        }
        
        $data['title'] = 'Import Sticker';
        
        $this->load->view('admin/templates/header', $data);
        $this->load->view('admin/templates/sidebar');
        $this->load->view('admin/stickers/bulk_upload');
        $this->load->view('admin/templates/footer');
    }
} 