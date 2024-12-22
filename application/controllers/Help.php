<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Help extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('help_model');
        $this->load->library('form_validation');
        $this->load->helper(['url', 'form', 'guide']);
    }

    public function index() {
        $data['faqs'] = $this->help_model->get_faqs();
        $data['guides'] = $this->help_model->get_guides();
        $this->load->view('help/index', $data);
    }

    public function contact() {
        // Validasi form kontak
        $this->form_validation->set_rules('name', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('subject', 'Subjek', 'required');
        $this->form_validation->set_rules('message', 'Pesan', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('help#contact');
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'subject' => $this->input->post('subject'),
                'message' => $this->input->post('message'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->help_model->save_contact($data)) {
                $this->session->set_flashdata('success', 'Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengirim pesan. Silakan coba lagi.');
            }
            redirect('help#contact');
        }
    }

    public function report_bug() {
        // Validasi form laporan bug
        $this->form_validation->set_rules('title', 'Judul Bug', 'required');
        $this->form_validation->set_rules('page', 'Halaman/Fitur', 'required');
        $this->form_validation->set_rules('severity', 'Tingkat Keseriusan', 'required');
        $this->form_validation->set_rules('description', 'Deskripsi Bug', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('help#report');
        } else {
            // Upload screenshot jika ada
            $config['upload_path'] = './uploads/bugs/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $screenshot = '';

            if (!empty($_FILES['screenshot']['name'])) {
                if ($this->upload->do_upload('screenshot')) {
                    $screenshot = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('help#report');
                }
            }

            $data = [
                'title' => $this->input->post('title'),
                'page' => $this->input->post('page'),
                'severity' => $this->input->post('severity'),
                'description' => $this->input->post('description'),
                'screenshot' => $screenshot,
                'user_id' => $this->session->userdata('user_id'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->help_model->save_bug_report($data)) {
                $this->session->set_flashdata('success', 'Laporan bug berhasil dikirim. Terima kasih atas kontribusi Anda.');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengirim laporan bug. Silakan coba lagi.');
            }
            redirect('help#report');
        }
    }

    public function guide($slug = '') {
        if (empty($slug)) {
            redirect('help#guide');
        }

        // Get current guide
        $data['guide'] = $this->help_model->get_guide_by_slug($slug);
        if (!$data['guide']) {
            show_404();
        }
        
        // Parse guide content
        $data['guide']->content = parse_guide_content($data['guide']->content);

        // Get all guides for sidebar
        $data['guides'] = $this->help_model->get_guides();

        // Get previous and next guides
        $data['prev_guide'] = $this->help_model->get_prev_guide($data['guide']->id);
        $data['next_guide'] = $this->help_model->get_next_guide($data['guide']->id);

        $this->load->view('help/guide', $data);
    }
} 