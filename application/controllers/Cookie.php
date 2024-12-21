<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cookie extends CI_Controller 
{

	public function checkUserCookie($userID)
	{
		try
		{ 
            $clientsCookie = null;
            $userDetails = $this->system_model->getUserDetails($userID);
            if ($userDetails['isstrictmachineaccess']=='T'){
                $clientsCookie = $this->input->cookie('lms_user_cebu_cookie', TRUE);
                $cookie = $this->Usercookies_model->getCookie($clientsCookie);
                if ($cookie) {
                    //check if the cookie has not expired and authenticated
                    if ($cookie['expires_at'] < date('Y-m-d H:i:s')) {
                        delete_cookie('lms_user_cebu_cookie');
                        $this->session->set_userdata('alert',  $this->mylibraries->show_message('Clientside authentication expired <br /> Please login again'));
                        redirect('/site');
                    }

                    if ($cookie['status'] == 'Pending') {
                        $this->session->set_userdata('alert',  $this->mylibraries->show_message('Clientside authentication pending <br />Please contact the administrator'));
                        redirect('/site');
                    }

                    if ($cookie['status'] == 'Expired') {
                        delete_cookie('lms_user_cebu_cookie');
                        $this->session->set_userdata('alert',  $this->mylibraries->show_message('Clientside authentication expired <br /> Please login again'));
                        redirect('/site');
                    }

                    if ($cookie['status'] != 'Active') {
                        $this->session->set_userdata('alert',  $this->mylibraries->show_message('E01: Clientside authentication failed <br />Please contact the administrator'));
                        redirect('/site');
                    }
                }
                else {
                    $this->session->set_userdata('alert',  $this->mylibraries->show_message('E02: Clientside authentication failed<br /> Please contact the administrator'));
                    redirect('/site');
                }
            }
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            die();
        }
    }
}