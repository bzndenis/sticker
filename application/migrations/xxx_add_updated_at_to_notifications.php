<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_updated_at_to_notifications extends CI_Migration {
    public function up() {
        $this->dbforge->add_column('notifications', [
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
                'after' => 'created_at'
            ]
        ]);
    }

    public function down() {
        $this->dbforge->drop_column('notifications', 'updated_at');
    }
} 