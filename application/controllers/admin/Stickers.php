<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stickers extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->check_admin();
        $this->load->library(['upload', 'image_lib']);
    }
    
    public function add($category_id) {
        // Validasi category_id
        $category = $this->sticker_model->get_category($category_id);
        if(!$category) {
            show_404();
            return;
        }
        
        // Konfigurasi upload
        $config['upload_path'] = './uploads/stickers/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;
        
        // Buat direktori jika belum ada
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }
        
        $this->load->library('upload', $config);
        
        if(!$this->upload->do_upload('image')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('admin/categories/view/'.$category_id);
            return;
        }
        
        $upload_data = $this->upload->data();
        
        // Generate image hash
        $image_hash = md5_file($upload_data['full_path']);
        
        // Cek duplikasi stiker
        $existing_sticker = $this->sticker_model->get_sticker_by_hash($image_hash);
        if($existing_sticker) {
            unlink($upload_data['full_path']); // Hapus file yang baru diupload
            $this->session->set_flashdata('error', 'Stiker ini sudah ada dalam database');
            redirect('admin/categories/view/'.$category_id);
            return;
        }
        
        // Dapatkan nomor terakhir untuk kategori ini
        $last_number = $this->db->where('category_id', $category_id)
                               ->order_by('number', 'DESC')
                               ->limit(1)
                               ->get('stickers')
                               ->row();
        $next_number = $last_number ? $last_number->number + 1 : 1;
        
        // Simpan data stiker
        $sticker_data = array(
            'category_id' => $category_id,
            'number' => $next_number,
            'image_path' => $upload_data['file_name'],
            'image_hash' => $image_hash,
            'created_at' => date('Y-m-d H:i:s')
        );
        
        if($this->sticker_model->add_sticker($sticker_data)) {
            $this->session->set_flashdata('success', 'Stiker berhasil ditambahkan');
        } else {
            unlink($upload_data['full_path']); // Hapus file jika gagal simpan
            $this->session->set_flashdata('error', 'Gagal menambahkan stiker');
        }
        
        redirect('admin/categories/view/'.$category_id);
    }
    
    public function delete($id) {
        $sticker = $this->sticker_model->get_sticker($id);
        if(!$sticker) {
            show_404();
            return;
        }
        
        $collection_id = $sticker->collection_id;
        
        if($this->sticker_model->delete_sticker($id)) {
            // Hapus file gambar
            $image_path = './uploads/stickers/'.$sticker->image_path;
            if(file_exists($image_path)) {
                unlink($image_path);
            }
            
            $this->session->set_flashdata('success', 'Stiker berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus stiker');
        }
        
        redirect('admin/collections/edit/'.$collection_id);
    }
    
    private function resize_image($path) {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $path;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 800; // Maksimal lebar
        $config['height'] = 800; // Maksimal tinggi
        
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }
} 