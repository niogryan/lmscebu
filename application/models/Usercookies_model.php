<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usercookies_model extends CI_Model {


    public function saveCookie($data)
    {
        $this->db->insert('tbl_useraccounts_cookies', $data);
        return $this->db->insert_id();
    }

    public function getCookie($cookie_value)
    {
        $output = $this->db->get_where('tbl_useraccounts_cookies', [
            'cookie_value' => $cookie_value
        ])->result_array();

        if (count($output) > 0) {
            return $output[0];
        } else {
            return null;
        }
    }

    public function updateCookieStatus($cookieID, $status)
    {
        $this->db->where('usercookieid', $cookieID);
        $this->db->update('tbl_useraccounts_cookies', ['status' => $status]);
    }

    public function getUserCookies($cookieID, $userID, $status)
    {
        if ($status == 'Active') {
            $this->db->select('cookies.*, user.emailaddress, user.firstname, user.lastname');
            $this->db->from('tbl_useraccounts_cookies cookies');
            $this->db->join('tbl_user_accounts user', 'cookies.user_id = user.userid');
            if ($cookieID != null) {
                $this->db->where('cookies.usercookieid', $cookieID);
            }

            if ($userID != null) {
                $this->db->where('cookies.user_id', $userID);
            }

            $this->db->where('cookies.status', $status);
            $this->db->order_by('cookies.ip_address asc,cookies.usercookieid desc');
        }
        else{
            $this->db->select('cookies.*, user.emailaddress, user.firstname, user.lastname');
            $this->db->from('tbl_useraccounts_cookies cookies');
            $this->db->join('tbl_user_accounts user', 'cookies.user_id = user.userid');
            if ($cookieID != null) {
                $this->db->where('cookies.usercookieid', $cookieID);
            }

            if ($userID != null) {
                $this->db->where('cookies.user_id', $userID);
            }

            if ($status != null) {
                if ($status == 'Others') {
                $this->db->where_not_in('cookies.status', ['Pending', 'Active']);
                } else {
                $this->db->where('cookies.status', $status);
                }
            }

            $this->db->order_by('cookies.usercookieid', 'desc');
            $this->db->limit(5);
        }
        return $this->db->get()->result_array();
    }

    public function getPendingCookies($userID){
        $this->db->select('usercookieid');
        $this->db->from('tbl_useraccounts_cookies');
        $this->db->where('status', 'Pending');
        $this->db->where('user_id', $userID);
        return $this->db->get()->result_array();
    }

    //get all cookies that are active and greater than date today then set status to expired
    public function updateExpiredCookies(){
        $this->db->where('status', 'Active');
        $this->db->where('expires_at <', date('Y-m-d H:i:s'));
        $this->db->update('tbl_useraccounts_cookies', ['status' => 'Expired']);
    }

}