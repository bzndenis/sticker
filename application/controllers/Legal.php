<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Legal extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function terms() {
        $this->load->view('legal/terms');
    }

    public function privacy() {
        $this->load->view('legal/privacy');
    }

    public function cookies() {
        $this->load->view('legal/cookies');
    }

    public function license() {
        $this->load->view('legal/license');
    }
} 