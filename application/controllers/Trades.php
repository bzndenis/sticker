<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trades extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        // Cek apakah user sudah login
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        // Load library yang diperlukan
        $this->load->library('form_validation');
        $this->load->model('trade_model');
        $this->load->model('chat_model');
    }

    public function index() {
        $data['trades'] = $this->trade_model->get_user_trades($this->session->userdata('user_id'));
        $data['stats'] = $this->trade_model->get_trade_stats($this->session->userdata('user_id'));
        
        $this->load->view('trades/index', $data);
    }

    public function create($sticker_id) {
        // Validasi sticker_id
        $sticker = $this->db->get_where('stickers', ['id' => $sticker_id])->row();
        if (!$sticker) {
            show_404();
            return;
        }

        // Dapatkan data user yang sedang login
        $user_id = $this->session->userdata('user_id');
        
        // Dapatkan stiker yang dimiliki user untuk ditawarkan
        $data['owned_stickers'] = $this->db->select('user_stickers.*, stickers.number as sticker_number')
                                         ->from('user_stickers')
                                         ->join('stickers', 'stickers.id = user_stickers.sticker_id')
                                         ->where('user_stickers.user_id', $user_id)
                                         ->where('user_stickers.is_for_trade', 1)
                                         ->where('user_stickers.quantity >', 0)
                                         ->get()->result();

        // Data stiker yang diminta
        $data['requested_sticker'] = $sticker;
        
        // Load view
        $this->load->view('trades/create', $data);
    }

    public function store() {
        // Validasi input
        $this->form_validation->set_rules('requested_sticker_id', 'Stiker yang Diminta', 'required|numeric');
        $this->form_validation->set_rules('offered_sticker_id', 'Stiker yang Ditawarkan', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('trades/create/'.$this->input->post('requested_sticker_id'));
            return;
        }

        // Data trade
        $data = [
            'requester_id' => $this->session->userdata('user_id'),
            'owner_id' => $this->db->get_where('user_stickers', ['sticker_id' => $this->input->post('requested_sticker_id')])->row()->user_id,
            'requested_sticker_id' => $this->input->post('requested_sticker_id'),
            'offered_sticker_id' => $this->input->post('offered_sticker_id'),
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Insert trade
        $this->db->insert('trades', $data);

        $this->session->set_flashdata('success', 'Permintaan pertukaran berhasil diajukan');
        redirect('trades');
    }

    public function view($id) {
        // Dapatkan data trade
        $trade = $this->trade_model->get_trade_detail($id);
        
        // Cek apakah trade ditemukan dan user berhak mengakses
        if (!$trade || ($trade->requester_id != $this->session->userdata('user_id') && 
            $trade->owner_id != $this->session->userdata('user_id'))) {
            show_404();
            return;
        }

        // Set status badge class
        $trade->status_class = [
            'pending' => 'warning',
            'accepted' => 'success',
            'rejected' => 'danger'
        ][$trade->status];

        // Set status text
        $trade->status_text = [
            'pending' => 'Menunggu',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak'
        ][$trade->status];

        $data['trade'] = $trade;
        
        // Load chat messages dari model
        $data['chat_messages'] = $this->trade_model->get_chat_messages($id);

        // Load view
        $this->load->view('trades/view', $data);
    }

    public function send_message() {
        if (!$this->input->is_ajax_request()) {
            show_404();
            return;
        }

        $user_id = $this->session->userdata('user_id');
        $trade_id = $this->input->post('trade_id');
        $message = trim($this->input->post('message'));

        // Validasi input
        if (empty($trade_id) || empty($message)) {
            echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
            return;
        }

        // Validasi akses ke trade
        $trade = $this->trade_model->get_trade($trade_id);
        if (!$trade || ($trade->requester_id != $user_id && $trade->owner_id != $user_id)) {
            echo json_encode(['success' => false, 'message' => 'Akses ditolak']);
            return;
        }

        $message_data = [
            'trade_id' => $trade_id,
            'user_id' => $user_id,
            'message' => $message,
            'is_delivered' => 1,
            'is_read' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->db->insert('chat_messages', $message_data)) {
            $new_message = $this->db->select('cm.*, u.username')
                                   ->from('chat_messages cm')
                                   ->join('users u', 'u.id = cm.user_id')
                                   ->where('cm.id', $this->db->insert_id())
                                   ->get()
                                   ->row();
                               
            echo json_encode([
                'success' => true,
                'message' => [
                    'id' => $new_message->id,
                    'message' => $new_message->message,
                    'username' => $new_message->username,
                    'created_at' => date('H:i', strtotime($new_message->created_at)),
                    'is_mine' => true
                ]
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal mengirim pesan']);
        }
    }

    public function get_chat_messages($trade_id) {
        $user_id = $this->session->userdata('user_id');
        $last_id = ($this->input->get('last_id')) ? $this->input->get('last_id') : 0;
        
        // Validasi akses ke trade
        $trade = $this->trade_model->get_trade($trade_id);
        if(!$trade || ($trade->requester_id != $user_id && $trade->owner_id != $user_id)) {
            $this->output->set_status_header(403);
            echo json_encode(['success' => false, 'message' => 'Akses ditolak']);
            return;
        }
        
        // Ambil pesan baru
        $messages = $this->chat_model->get_messages_after($trade_id, $last_id);
        
        // Mark messages as read
        if(!empty($messages)) {
            $this->chat_model->mark_messages_as_read($trade_id, $user_id);
        }
        
        echo json_encode([
            'success' => true,
            'messages' => array_map(function($msg) use ($user_id) {
                return [
                    'id' => $msg->id,
                    'message' => $msg->message,
                    'is_mine' => $msg->user_id == $user_id,
                    'is_read' => $msg->is_read,
                    'created_at' => time_elapsed_string($msg->created_at)
                ];
            }, $messages)
        ]);
    }

    public function mark_messages_read($trade_id) {
        if (!$this->input->is_ajax_request()) {
            show_404();
            return;
        }

        $user_id = $this->session->userdata('user_id');
        
        // Update semua pesan yang belum dibaca
        $this->db->where('trade_id', $trade_id)
                 ->where('user_id !=', $user_id)
                 ->where('is_read', 0)
                 ->update('chat_messages', [
                     'is_read' => 1,
                     'read_at' => date('Y-m-d H:i:s')
                 ]);

        echo json_encode(['success' => true]);
    }

    public function reject($trade_id) {
        // Validasi akses ke trade
        $trade = $this->trade_model->get_trade($trade_id);
        $user_id = $this->session->userdata('user_id');
        
        if (!$trade || ($trade->owner_id != $user_id && $trade->requester_id != $user_id)) {
            show_404();
            return;
        }
        
        // Hanya pemilik stiker yang bisa menolak pertukaran
        if ($trade->owner_id != $user_id) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk menolak pertukaran ini');
            redirect('trades/view/' . $trade_id);
            return;
        }
        
        // Pastikan status masih pending
        if ($trade->status !== 'pending') {
            $this->session->set_flashdata('error', 'Pertukaran ini tidak dapat ditolak karena status sudah ' . $trade->status);
            redirect('trades/view/' . $trade_id);
            return;
        }
        
        // Update status trade menjadi rejected
        $this->db->where('id', $trade_id)
                 ->update('trades', [
                     'status' => 'rejected',
                     'updated_at' => date('Y-m-d H:i:s')
                 ]);
        
        // Set flash message
        $this->session->set_flashdata('success', 'Pertukaran berhasil ditolak');
        
        // Redirect ke halaman detail trade
        redirect('trades/view/' . $trade_id);
    }
} 