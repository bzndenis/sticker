<?php

class Admin extends CI_Controller {

    public function users() {
        $search = $this->input->get('search');
        $status = $this->input->get('status');
        $sort = $this->input->get('sort');
        
        $data['users'] = $this->user_model->search_users($search, $status, $sort);
        $this->load->view('admin/users', $data);
    }

    public function toggle_user_status($id) {
        if($this->user_model->toggle_status($id)) {
            $this->session->set_flashdata('success', 'Status pengguna berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengubah status pengguna');
        }
        redirect('admin/users');
    }
} 