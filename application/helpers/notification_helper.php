<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('get_notification_badge')) {
    function get_notification_badge($user_id) {
        $CI =& get_instance();
        if(!$CI->notification_model) {
            $CI->load->model('notification_model');
        }
        return $CI->notification_model->count_unread($user_id);
    }
}

if (!function_exists('get_unread_notifications_count')) {
    function get_unread_notifications_count() {
        $CI =& get_instance();
        $CI->load->model('notification_model');
        $user_id = $CI->session->userdata('user_id');
        
        if (!$user_id) return 0;
        
        return $CI->notification_model->count_unread($user_id);
    }
}

if (!function_exists('get_notification_count')) {
    function get_notification_count($user_id) {
        $CI =& get_instance();
        return $CI->notification_model->get_unread_notifications_count($user_id);
    }
} 