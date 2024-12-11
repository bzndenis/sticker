<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function login() {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Login';
            $this->load->view('auth/login', $data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            
            $user = $this->user_model->check_login($username, $password);
            
            if ($user) {
                $userdata = array(
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'logged_in' => TRUE
                );
                
                $this->session->set_userdata($userdata);
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah');
                redirect('auth/login');
            }
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    public function register() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');
        $this->form_validation->set_rules('terms', 'Syarat dan Ketentuan', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Register';
            $this->load->view('auth/register', $data);
        } else {
            $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s')
            );
            
            if ($this->user_model->register($data)) {
                $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Terjadi kesalahan saat registrasi');
                redirect('auth/register');
            }
        }
    }
} 