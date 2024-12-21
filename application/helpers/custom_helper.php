<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('is_cookie_active'))
{
    function is_cookie_active() {
        $CI =& get_instance(); // Get CI instance
        $CI->load->helper('cookie'); // Load the cookie helper if not already loaded
        $CI->load->model('Usercookies_model'); // Load the model

        $clientsCookie = $CI->input->cookie('lms_user_cebu_cookie', TRUE);
        if ($clientsCookie == null) {
            $CI->session->set_userdata('alert',  $CI->mylibraries->show_message('E02: Clientside authentication failed<br /> Please contact the administrator'));
            redirect('/site');
        }

        $cookie = $CI->Usercookies_model->getCookie($clientsCookie);
        if ($cookie) {
            // Check if the cookie has not expired and authenticated
            if ($cookie['expires_at'] < date('Y-m-d H:i:s') || $cookie['status'] == 'Expired') {
                delete_cookie('lms_user_cebu_cookie');
                $CI->session->set_userdata('alert',  $CI->mylibraries->show_message('Clientside authentication expired <br /> Please login again'));
                redirect('/site');
            }

            if ($cookie['status'] == 'Pending') {
                $CI->session->set_userdata('alert',  $CI->mylibraries->show_message('Clientside authentication pending <br />Please contact the administrator'));
                redirect('/site');
            }

            if ($cookie['status'] != 'Active') {
                $CI->session->set_userdata('alert',  $CI->mylibraries->show_message('E01: Clientside authentication failed <br />Please contact the administrator'));
                redirect('/site');
            }
        } else {
            $CI->session->set_userdata('alert',  $CI->mylibraries->show_message('E02: Clientside authentication failed<br /> Please contact the administrator'));
            redirect('/site');
        }
        
        return false; // Cookie is not active or does not exist
    }
}
