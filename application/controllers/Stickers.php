<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stickers extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('sticker_model');
        
        if(!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }

    public function manage() {
        $data['categories'] = $this->sticker_model->get_categories_with_progress();
        $data['stickers'] = $this->sticker_model->get_user_stickers(
            $this->session->userdata('user_id'),
            $this->input->get('category'),
            $this->input->get('sort')
        );
        $this->load->view('stickers/manage', $data);
    }

    public function category($category_id) {
        $data['category'] = $this->sticker_model->get_category($category_id);
        if (!$data['category']) show_404();

        $data['stickers'] = $this->sticker_model->get_category_stickers($category_id);
        
        if ($this->input->post()) {
            $config['upload_path'] = './uploads/stickers/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $upload_data = $this->upload->data();
                
                // Get quantities
                $quantities = $this->input->post('quantities');
                
                // Update or insert user_stickers for each number
                foreach($quantities as $number => $quantity) {
                    $sticker_id = $data['stickers'][$number-1]->id;
                    
                    $user_sticker_data = [
                        'user_id' => $this->session->userdata('user_id'),
                        'sticker_id' => $sticker_id,
                        'quantity' => $quantity,
                        'is_for_trade' => $quantity > 1 ? 1 : 0,
                        'image_path' => $upload_data['file_name'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    // Check if user_sticker exists
                    $existing = $this->sticker_model->get_user_sticker(
                        $this->session->userdata('user_id'),
                        $sticker_id
                    );

                    if ($existing) {
                        $this->sticker_model->update_user_sticker($existing->id, $user_sticker_data);
                    } else {
                        $this->sticker_model->add_user_sticker($user_sticker_data);
                    }
                }

                $this->session->set_flashdata('success', 'Stiker berhasil diupdate');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
            }
            
            redirect('stickers/category/'.$category_id);
        }

        $this->load->view('stickers/category', $data);
    }

    public function toggle_trade() {
        $sticker_id = $this->input->post('sticker_id');
        $status = $this->input->post('status');
        
        $result = $this->sticker_model->toggle_trade_status(
            $sticker_id,
            $this->session->userdata('user_id'),
            $status
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => $result
            ]));
    }

    public function upload($category_id) {
        $this->check_login();
        
        // Validasi apakah stiker sudah ada
        $sticker = $this->sticker_model->get_sticker($this->input->post('sticker_id'));
        if (!$sticker) {
            $this->session->set_flashdata('error', 'Stiker tidak ditemukan');
            redirect('stickers/category/'.$category_id);
        }

        // Konfigurasi upload
        $config['upload_path'] = './uploads/stickers/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 2048; // 2MB
        $config['file_name'] = 'Sticker_'.time();
        
        $this->load->library('upload', $config);
        
        if ($this->upload->do_upload('image')) {
            $upload_data = $this->upload->data();
            
            // Update user_stickers, bukan stickers
            $user_sticker_data = [
                'user_id' => $this->session->userdata('user_id'),
                'sticker_id' => $sticker->id,
                'image_path' => $upload_data['file_name'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            // Simpan ke user_stickers
            if ($this->sticker_model->add_user_sticker($user_sticker_data)) {
                $this->session->set_flashdata('success', 'Stiker berhasil diupload');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan stiker');
                // Hapus file jika gagal menyimpan ke database
                unlink($config['upload_path'].$upload_data['file_name']);
            }
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
        }
        
        redirect('stickers/category/'.$category_id);
    }
} 