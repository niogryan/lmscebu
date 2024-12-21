<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class site extends CI_Controller 
{
	
	function __construct()
	{	
		parent::__construct();
		
		if (IsMaintenance=='T')
		{
			$this->session->sess_destroy();
			$this->maintenance();
		}
		
		$this->session->set_userdata('Version','2.0.0');
		$this->load->helper('cookie');
		$this->loan_model->updateloanstatus();
		$this->Usercookies_model->updateExpiredCookies();
		
	}
	
	public function index()
	{
		$this->session->sess_destroy();
		$this->load->view('login');
	}
	
	public function authentication()
	{
		try
		{

			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			if ($this->form_validation->run() == FALSE)
			{
				throw new Exception('Access Denied');
			}

			if ($this->input->post('btnSignIn'))
			{ 
				$result=$this->system_model->validateuseraccount(trim($this->input->post('email')),trim($this->input->post('password')));
				if ($result)
				{
					if ($result[0]['role']!='Administrator')
					{
						$this->load->library('user_agent');
		
		  				if ($this->agent->is_mobile())
		 				{
							echo 'Not allowed in mobile';
							die();
		 				}

						$isCookieFeature = 1;
						if ($isCookieFeature == 1 && $result[0]['isstrictmachineaccess'] == '1') {
							$clientsCookie = null;
							$clientsCookie = $this->input->cookie('lms_user_cebu_cookie', TRUE);
							if ($clientsCookie == null) {
								$clientsCookie = $this->doCookiesCreation($result[0]['userid']);
							}

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


						$check=0;
						$branch=$this->tools_model->getuserbranches($result[0]['userid']);
						if (!empty($branch))
						{
							if (count($branch)>1)
							{
								foreach($branch as $row)
								{
									
									if (empty($branch[0]['ipaddress']))
									{
										$ctr=1;
										break;
									}
									if (trim($row['ipaddress'])==trim($this->input->post('hidloc')))
									{
										$ctr=1;
										break;
									}
									
								}
							}
							else
							{
								if (empty($branch[0]['ipaddress']))
								{
									$ctr=1;
								}
								else if (trim($branch[0]['ipaddress'])==trim($this->input->post('hidloc')))
								{
									$ctr=1;
								}
							}
							
							
							if ($ctr==0)
							{
								redirect('site/unknown');
							}
						}
						else
						{
							echo '<h1>User no assigned branch</h1>';
							die();
						}
					}
					
					$data = array
									(
										'lmsmemberid' 	=> $result[0]['userid'],
										'username' 		=> $result[0]['emailaddress'],
										'role' 			=> $result[0]['role'],
										'roleid' 		=> $result[0]['roleid'],
										'name' 			=> ucwords(strtolower(ascii_to_entities($result[0]['firstname'].' '.$result[0]['lastname']))),
									);

					$this->session->set_userdata($data);
					redirect('app/');	
				}
				else
				{	
					$this->session->set_userdata('alert','Access Denied');
				}
			}
			
			redirect('/');
		}
		catch (Exception $e) 
		{
			$this->session->set_userdata('alert',  $this->mylibraries->show_message('Please contact the administrator.'));
			redirect('/');
		}
	}

	
	public function accessdenied()
	{
		$this->session->sess_destroy();
		$data['param1']=$this->uri->segment(3);
		$this->load->view('templates/siteheader',$data);
		$this->load->view('accessdenied');
		$this->load->view('templates/datafooter');
	}
	
	public function maintenance()
	{
		if (IsMaintenance=='F')
		{
			redirect('/');
		}
		echo 'The site is temporarily closed for maintenance';
		die();

	}
	
	public function unknown()
	{
		$this->load->view('unknown');
	}
	
	
	public function loginas()
	{
		$result = $this->system_model->loginas();
		if ($result)
		{
			$data = array
							(
								'lmsmemberid' 	=> $result[0]['userid'],
								'username' 		=> $result[0]['emailaddress'],
								'role' 			=> $result[0]['role'],
								'roleid' 		=> $result[0]['roleid'],
								'name' 			=> ucwords(strtolower(ascii_to_entities($result[0]['firstname'].' '.$result[0]['lastname']))),
							);

			$this->session->set_userdata($data);
			redirect('app/');	
		}
		
		redirect('/');
	}
	
	public function signinas()
	{
		if($this->mylibraries->encrypt('1qaz45'.$this->uri->segment(3))!=$this->uri->segment(4))
		{
			redirect('/');
		}
		
		
		$result = $this->system_model->signinas($this->uri->segment(3));
		if ($result)
		{
			$data = array
							(
								'lmsmemberid' 	=> $result[0]['userid'],
								'username' 		=> $result[0]['emailaddress'],
								'role' 			=> $result[0]['role'],
								'roleid' 		=> $result[0]['roleid'],
								'name' 			=> ucwords(strtolower(ascii_to_entities($result[0]['firstname'].' '.$result[0]['lastname']))),
							);

			$this->session->set_userdata($data);
			redirect('app/');	
		}
		
		redirect('/');
	}
	
	
	
	
	public function logout()
	{
		$this->session->sess_destroy();
	}
	
	
	public function migration()
	{
		// $profile=$loan=$payments=null;
		
		// $profile=$this->olddb_model->migrationprofile();
		
		// echo '<pre>';
		// print_r($profile);
		
		// $profilectr=1;
		// foreach($profile as $row)
		// {
			// echo 'Processing. . .('.$profilectr.'/'.count($profile).')<br />';
			// $loan=$this->olddb_model->migrationloan($row['customerid']);
			// $ctr=0;
			// foreach($loan as $rowloan)
			// {
				// $resultpayments=null;
				// $resultpayments=$this->olddb_model->migrationloanpayments($rowloan['loanid']);
				// if (!empty($resultpayments))
				// {
					// $loan[$ctr]['status']='OK';
					// $payments[$rowloan['loanid']]=$resultpayments;
				// }
				// else
				// {
					// $loan[$ctr]['status']='None';
				// }
				// $ctr++;
				
			// }
			// $profilectr ++;
			// $this->olddb_model->migrationprocess($row,$loan,$payments);
			
		// }
		
		

		echo '<h1>Done</h1>';
		die();
	}
	
	public function migrationtool()
	{
		$data['branches']=$this->olddb_model->getbranch();
		
		if ($this->input->post('btnSave'))
		{
			foreach($data['branches'] as $row)
			{

				$result=$this->olddb_model->updatebranch($row['uqid'],$this->input->post('branch'.$row['uqid']));

			}
			
			redirect('site/migrationtool');	
		}
		else if ($this->input->post('btnMigrate'))
		{
			$profile=$loan=$payments=null;
		
			$profile=$this->olddb_model->migrationprofile();
			
		
			
			$profilectr=1;
			foreach($profile as $row)
			{
				$loan=$this->olddb_model->migrationloan($row['customerid']);
				$ctr=0;
				foreach($loan as $rowloan)
				{
					$resultpayments=null;
					$resultpayments=$this->olddb_model->migrationloanpayments($rowloan['loanid']);
					if (!empty($resultpayments))
					{
						$loan[$ctr]['status']='OK';
						$payments[$rowloan['loanid']]=$resultpayments;
					}
					else
					{
						$loan[$ctr]['status']='None';
					}
					$ctr++;
					
				}
				$profilectr ++;
				$this->olddb_model->migrationprocess($row,$loan,$payments);
				
			}
			
			//$this->archiving_model->index();
			
			echo '<h1>Done</h1>';
			echo '<pre>';
			print_r($this->olddb_model->migrationprofilestatus());
			
			die();
		}
		
	
		$data['branchesareas']=$this->tools_model->getbranchesareas();	
		$this->load->view('migrationtool',$data);
	}
	
	public function migrationstatus()
	{
		echo '<pre>';
		print_r($this->olddb_model->migrationprofilestatus());
		die();
	}
	
	public function archive()
	{
		$this->archiving_model->index();
	}
	
	public function backup()
	{
		try
		{ 
			$this->load->helper('file');
			$this->load->dbutil();

			$prefs = array('format' => 'zip', 'filename' => 'Database-backup_' . date('Y-m-d_H-i'));
			$backup = $this->dbutil->backup($prefs);
			
			if (write_file(FCPATH . '/bkp/Full/BD-Full' . date('Y-m-d_H-i') . '.zip', $backup) == FALSE)
			{
			   echo 'Unable to write the file';
			} 
			else 
			{
				echo 'File written!';                           
			}
			die();
			
		
		}
		catch (Exception $e) 
		{
			echo $e->getMessage();
			die();
		}
	}
	
	public function updatebalance()
	{
		$result=$this->loan_model->get123456();
		foreach($result as $row)
		{
			$this->loan_model->updatebalance($row['loanid']);
		}
		
	}

	private function doCookiesCreation($userid){
		try{
			$pendingCookies = $this->Usercookies_model->getPendingCookies( $userid);
			if (!$pendingCookies){
				$cookieValue = bin2hex(random_bytes(16)); // Unique cookie value
				$userAgent = $_SERVER['HTTP_USER_AGENT'];
				$remoteAddress = $_SERVER['REMOTE_ADDR'];
				$clientSignature = sha1($userAgent . $remoteAddress); // User-Agent + IP
				$cookieValue = $cookieValue. $clientSignature;

				$cookie = array(
					'name'   => 'lms_user_cebu_cookie',
					'value'  => $cookieValue,
					'expire' => 31536000, // 1 year
					'secure' => FALSE,
					'httponly' => TRUE,
				);
				$this->input->set_cookie($cookie);
				// Save cookie details in the database
				$parameter = [
					'user_id' 		=> $userid,
					'cookie_value' 	=> $cookieValue,
					'created_at' 	=> date('Y-m-d H:i:s'),
					'status' 		=> 'Pending',
					'expires_at' 	=> date('Y-m-d H:i:s', strtotime('+1 year')),
					'user_agent'	=> $userAgent,
					'ip_address'	=> $remoteAddress
					];
				$this->Usercookies_model->saveCookie($parameter);
				return $cookieValue;
			}
			else{
				echo 'Clientside authentication pending. Please contact the administrator.';
				die();
			}
		}
		catch (Exception $e){
			echo $e->getMessage();
			die();
		}
	}
	
	public function clean(){
		delete_cookie('lms_user_cebu_cookie');
		if (isset($_COOKIE['lms_user_cebu_cookie'])) {
			echo 'Unable to delete. Please contact the administrator';
		}
		else{
			echo 'Machine authentication cleaned';
		}
	}
}
