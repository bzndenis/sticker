<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image_handler {
    
    protected $CI;
    
    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
    }
    
    public function upload($field_name) {
        // Konfigurasi upload
        $config['upload_path'] = './uploads/stickers/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;
        
        // Buat direktori jika belum ada
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }
        
        $this->CI->load->library('upload', $config);
        
        if (!$this->CI->upload->do_upload($field_name)) {
            return [
                'status' => 'error',
                'message' => $this->CI->upload->display_errors('', '')
            ];
        }
        
        $upload_data = $this->CI->upload->data();
        return [
            'status' => 'success',
            'file_name' => $upload_data['file_name'],
            'image_hash' => md5_file($upload_data['full_path'])
        ];
    }
    
    public function delete($file_name) {
        $file_path = './uploads/stickers/' . $file_name;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
} 