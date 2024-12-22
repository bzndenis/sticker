<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('time_elapsed_string')) {
    function time_elapsed_string($datetime) {
        $CI =& get_instance();
        
        $now = new DateTime();
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'tahun',
            'm' => 'bulan',
            'w' => 'minggu',
            'd' => 'hari',
            'h' => 'jam',
            'i' => 'menit',
            's' => 'detik',
        );

        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v;
            } else {
                unset($string[$k]);
            }
        }

        if (!$string) {
            return 'baru saja';
        }

        $string = array_slice($string, 0, 1);
        return $string[key($string)] . ' yang lalu';
    }
} 