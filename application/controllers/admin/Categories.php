<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('sticker_model');
        
        // Check if user is admin
        if(!$this->session->userdata('is_admin')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['categories'] = $this->sticker_model->get_categories_with_stats();
        $this->load->view('admin/categories/index', $data);
    }

    public function edit($id) {
        $data['category'] = $this->sticker_model->get_category($id);
        $data['stickers'] = $this->sticker_model->get_category_stickers($id);
        
        if ($this->input->post()) {
            $config['upload_path'] = './uploads/stickers/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $upload_data = $this->upload->data();
                $image_path = $upload_data['file_name'];
                
                // Update sticker data
                $this->sticker_model->update_sticker_image($data['stickers']['sticker']->id, [
                    'image_path' => $image_path,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                $this->session->set_flashdata('success', 'Gambar stiker berhasil diupload');
            }

            // Update sticker quantity
            $quantities = $this->input->post('quantities');
            if ($quantities) {
                foreach($quantities as $number => $quantity) {
                    $this->sticker_model->update_sticker_quantity(
                        $data['stickers']['sticker']->id, 
                        $number, 
                        $quantity
                    );
                }
                $this->session->set_flashdata('success', 'Jumlah stiker berhasil diupdate');
            }

            redirect('admin/categories/edit/'.$id);
        }

        $this->load->view('admin/categories/edit', $data);
    }
} 