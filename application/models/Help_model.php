<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Help_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_faqs() {
        return $this->db->get('faqs')->result();
    }

    public function get_guides() {
        return $this->db->get('guides')->result();
    }

    public function get_guide_by_slug($slug) {
        return $this->db->where('slug', $slug)->get('guides')->row();
    }

    public function save_contact($data) {
        return $this->db->insert('contacts', $data);
    }

    public function save_bug_report($data) {
        return $this->db->insert('bug_reports', $data);
    }

    public function get_prev_guide($current_id) {
        return $this->db
            ->where('id <', $current_id)
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get('guides')
            ->row();
    }

    public function get_next_guide($current_id) {
        return $this->db
            ->where('id >', $current_id)
            ->order_by('id', 'ASC')
            ->limit(1)
            ->get('guides')
            ->row();
    }
} 