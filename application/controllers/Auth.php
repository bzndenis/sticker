<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('form_validation');
    }
    
    public function index() {
        if(!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        redirect('dashboard');
    }
    
    public function login() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
            return;
        }

        $data['title'] = 'Login';
        
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            
            $user = $this->user_model->get_user_by_email($email);
            
            if ($user && password_verify($password, $user->password)) {
                $this->session->set_userdata([
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'username' => $user->username,
                    'logged_in' => TRUE
                ]);
                redirect('dashboard');
                return;
            } else {
                $this->session->set_flashdata('error', 'Email atau password salah');
            }
        }
        
        $this->load->view('templates/header', $data);
        $this->load->view('auth/login');
    }
    
    public function register() {
        if($this->session->userdata('user_id')) {
            redirect('dashboard');
        }
        
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');
        
        if($this->form_validation->run() === FALSE) {
            $this->load->view('auth/register');
            return;
        }
        
        $user_data = array(
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s')
        );
        
        if($this->user_model->register($user_data)) {
            $this->session->set_flashdata('success', 'Registrasi berhasil, silakan login');
            redirect('auth/login');
        } else {
            $this->session->set_flashdata('error', 'Gagal melakukan registrasi');
            redirect('auth/register');
        }
    }
    
    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
} 