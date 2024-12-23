<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feed extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->check_login();
        $this->load->model(['sticker_model', 'user_model', 'Feed_model']);
    }
    
    public function index() {
        // Load library pagination
        $this->load->library('pagination');
        
        // Konfigurasi pagination
        $config['base_url'] = base_url('feed/index');
        $config['total_rows'] = $this->Feed_model->count_available_stickers($this->session->userdata('user_id'));
        $config['per_page'] = 12;
        $config['uri_segment'] = 3;
        
        // Styling pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['title'] = 'Feed';
        $data['user'] = $this->db->get_where('users', ['id' => $this->session->userdata('user_id')])->row_array();
        $user_id = $this->session->userdata('user_id');

        // Query untuk mendapatkan stiker yang tersedia untuk ditukar
        $this->db->select('us.*, s.number, s.id, sc.name as category_name, u.username')
                 ->from('user_stickers us')
                 ->join('stickers s', 's.id = us.sticker_id')
                 ->join('sticker_categories sc', 'sc.id = s.category_id')
                 ->join('users u', 'u.id = us.user_id')
                 ->where('us.is_for_trade', 1)
                 ->where('us.quantity >', 0)
                 ->where('us.user_id !=', $user_id);

        $query = $this->db->get();

        $data['stickers'] = $query->result_array();
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('feed/index', $data);
        $this->load->view('templates/footer');
    }
    
    // Add search method
    public function search() {
        $user_id = $this->session->userdata('user_id');
        $category_id = $this->input->get('category');
        
        $data['feed_items'] = $this->sticker_model->get_feed_items($user_id, 20, $category_id);
        $data['categories'] = $this->sticker_model->get_categories();
        $data['selected_category'] = $category_id;
        
        $this->load->view('feed/index', $data);
    }
} 