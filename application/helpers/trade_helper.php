<?php
if (!function_exists('get_status_badge')) {
    function get_status_badge($status) {
        switch($status) {
            case 'pending':
                return 'warning';
            case 'accepted':
                return 'success';
            case 'rejected':
                return 'danger';
            case 'cancelled':
                return 'secondary';
            default:
                return 'info';
        }
    }
} 