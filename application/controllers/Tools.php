<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tools extends CI_Controller 
{
	function __construct()
	{	
		parent::__construct();
	
		if (IsMaintenance=='T')
		{
			redirect('site/maintenance');
		}
		
		if (!$this->session->userdata('lmsmemberid'))
		{ 
			$this->session->set_userdata('alert',  'Access Denied');
			redirect('site/');
		}
		$this->data['accessmenu']=$this->tools_model->getuseraccessmenu($this->session->userdata('roleid'));
		$this->data['selectedsearchtype']=null;
	}
	
	
	public function index()
	{
		$this->data['mainmenu']='';
		$this->data['submenu']='';
		$this->load->view('templates/header',$this->data);
		$this->load->view('index');
		$this->load->view('templates/footer');
	}
	
	public function areas()
	{
		
		if ($this->input->post('btnSave'))
		{
			$this->form_validation->set_rules('areacity', 'City', 'trim|required|xss_clean');
			$this->form_validation->set_rules('areaname', 'Area Name', 'trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('tools/areas/');
			}
			else
			{
				$result=$this->tools_model->saveareas
										(	$this->input->post('hid')
											,$this->input->post('areacity')
											,$this->input->post('areaname')
											,$this->input->post('areastatus')
											,$this->session->userdata('lmsmemberid')
										);				
				
				if($result['error_number']==0)
				{
					$this->session->set_userdata('alertgreen', 'success');
				}
				else
				{
					$this->session->set_userdata('alertred', $this->mylibraries->show_message($result['error_message']));
				}
		
				
				redirect('tools/areas/');
			}
		}
		
		$this->data['areas']=$this->tools_model->getareas();
		
		$this->data['mainmenu']='tools';
		$this->data['submenu']='areas';
		$this->load->view('templates/header',$this->data);
		$this->load->view('tools/areas');
		$this->load->view('templates/footer');
	}
	
	public function branches()
	{
		
		if ($this->input->post('btnSave'))
		{
			$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('tools/branches/');
			}
			else
			{
				$result=$this->tools_model->savebranches
										(	$this->input->post('hid')
											,$this->input->post('name')
											,$this->input->post('shortdesc')
											,$this->input->post('address')
											,$this->input->post('contactperson')
											,$this->input->post('contactnumber')
											,$this->input->post('ipaddress')
											,$this->session->userdata('lmsmemberid')
										);				
				
				if($result['error_number']==0)
				{
					$this->session->set_userdata('alertgreen', 'success');
				}
				else
				{
					$this->session->set_userdata('alertred', $this->mylibraries->show_message($result['error_message']));
				}
		
				
				redirect('tools/branches/');
			}
		}
		
		$this->data['branches']=$this->tools_model->getbranches();
		
		$this->data['mainmenu']='tools';
		$this->data['submenu']='branches';
		$this->load->view('templates/header',$this->data);
		$this->load->view('tools/branches');
		$this->load->view('templates/footer');
	}
	
	public function branchesareas()
	{
		
		if ($this->input->post('btnSave'))
		{
			$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');
			$this->form_validation->set_rules('area', 'Area', 'trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('tools/branchesareas/');
			}
			else
			{
				$result=$this->tools_model->savebranchesareas
										(	$this->input->post('hid')
											,$this->input->post('branch')
											,$this->input->post('area')
											,null
											,null
											,null
											,$this->input->post('status')
											,$this->session->userdata('lmsmemberid')
										);				
				
				if($result['error_number']==0)
				{
					$this->session->set_userdata('alertgreen', 'success');
				}
				else
				{
					$this->session->set_userdata('alertred', $this->mylibraries->show_message($result['error_message']));
				}
		
				
				redirect('tools/branchesareas/');
			}
		}
		
		
		$this->data['areas']=$this->tools_model->getareas();
		$this->data['branches']=$this->tools_model->getbranches();
		$this->data['branchesareas']=$this->tools_model->getbranchesareas();
		
		
		$this->data['mainmenu']='tools';
		$this->data['submenu']='branchesareas';
		$this->load->view('templates/header',$this->data);
		$this->load->view('tools/branchesareas');
		$this->load->view('templates/footer');
	}
	
	
	
	
	public function servicecharge()
	{
		
		if ($this->input->post('btnSave'))
		{
			$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('tools/branches/');
			}
			else
			{
				$result=$this->tools_model->savebranches
										(	$this->input->post('hid')
											,$this->input->post('name')
											,$this->input->post('shortdesc')
											,$this->input->post('address')
											,$this->input->post('contactperson')
											,$this->input->post('contactnumber')
											,$this->session->userdata('lmsmemberid')
										);				
				
				if($result['error_number']==0)
				{
					$this->session->set_userdata('alertgreen', 'success');
				}
				else
				{
					$this->session->set_userdata('alertred', $this->mylibraries->show_message($result['error_message']));
				}
		
				
				redirect('tools/branches/');
			}
		}
		else
		{
			if($this->mylibraries->encrypt('vsc'.$this->uri->segment(3))!=$this->uri->segment(4))
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
				redirect('tools/branch/');
			}
		}
		
		
		
		$this->data['servicecharge']=$this->tools_model->getservicecharge($this->uri->segment(3));
		$this->data['branch']=$this->tools_model->getbranchesdetails($this->uri->segment(3));
		
		$this->data['mainmenu']='tools';
		$this->data['submenu']='branches';
		$this->load->view('templates/header',$this->data);
		$this->load->view('tools/servicecharge');
		$this->load->view('templates/footer');
	}
	
	public function holidays()
	{
		
		if ($this->input->post('btnSave'))
		{
			$this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
			$this->form_validation->set_rules('holidayname', 'Holiday Name', 'trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('tools/holidays/');
			}
			else
			{
				$hid = (trim($this->input->post('hid'))=='' ? 0 : $this->input->post('hid'));
				
				$result=$this->tools_model->saveholiday
										(	$hid
											,$this->input->post('date')
											,$this->input->post('holidayname')
											,$this->input->post('isnational')
											,$this->input->post('remarks')
											,$this->session->userdata('lmsmemberid')
										);		

				if($result['error_number']==0)
				{
					if ($hid==0 && $this->input->post('isnational')=='Y')
					{
						$ctr=0;	
						$branchesareas=$this->tools_model->getbranches();	
						foreach($branchesareas as $row)
						{
							$this->tools_model->saveholidaybranch
													(	$result['returnid']
														,$row['branchid']
														,$ctr
													);	
							$ctr=1;	
						}

						$this->session->set_userdata('alertgreen', 'success');
						redirect('tools/holidaydetails/'.$result['returnid'].'/'.$this->mylibraries->encrypt('vh'.$result['returnid']));						
					}
					else if ($hid>0 && $this->input->post('isnational')=='N')
					{
						$this->tools_model->saveholidaybranch
													(	$hid
														,NULL
														,0
													);	
													
						$this->session->set_userdata('alertgreen', 'success');
						redirect('tools/holidaydetails/'.$hid.'/'.$this->mylibraries->encrypt('vh'.$hid));									
					}
					else if ($hid>0 && $this->input->post('isnational')=='Y')
					{
						$ctr=0;	
						$branchesareas=$this->tools_model->getbranchesareas();	
						foreach($branchesareas as $row)
						{
							$this->tools_model->saveholidaybranch
													(	$hid
														,$row['branchareaid']
														,$ctr
													);	
							$ctr=1;	
						}
													
						$this->session->set_userdata('alertgreen', 'success');
						redirect('tools/holidaydetails/'.$hid.'/'.$this->mylibraries->encrypt('vh'.$hid));									
					}
					
					
					
				}
				else
				{
					$this->session->set_userdata('alertred', $this->mylibraries->show_message($result['error_message']));
					redirect('tools/holidays/');
				}
		
				
				
			}
		}
		
		
		$this->data['holidays']=$this->tools_model->getholidays();
		// $this->data['branches']=$this->tools_model->getbranches();
		// $this->data['branchesareas']=$this->tools_model->getbranchesareas();
		
		
		$this->data['mainmenu']='tools';
		$this->data['submenu']='holidays';
		$this->load->view('templates/header',$this->data);
		$this->load->view('tools/holidays');
		$this->load->view('templates/footer');
	}
	
	public function holidaydetails()
	{
		$this->data['param1']=$this->uri->segment(3);
		$this->data['param2']=$this->uri->segment(4);
		
		if ($this->input->post('btnSave'))
		{
			$ctr=0;
			if ($this->input->post('branch'))
			{
				foreach($this->input->post('branch') as $row)
				{
					$this->tools_model->saveholidaybranch
											(	$this->data['param1']
												,$row
												,$ctr
											);	
					$ctr=1;						
				}
			}
			else
			{
				$this->tools_model->deleteholidaybranchareas($this->data['param1']);
			}
			
			
			
			$this->session->set_userdata('alertgreen', 'success');
			redirect('tools/holidaydetails/'.$this->data['param1'].'/'.$this->data['param2']);
			
		}
		else
		{
			if($this->mylibraries->encrypt('vh'.$this->uri->segment(3))!=$this->uri->segment(4))
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
				redirect('tools/holidays/');
			}
		}
		
		
		
		$this->data['holidays']=$this->tools_model->getholidaydetails($this->uri->segment(3));
		$this->data['branches']=$this->tools_model->getbranches();
		$this->data['holidaybranches']=$this->tools_model->getholidaybranches($this->uri->segment(3));
		

		
		
		$this->data['mainmenu']='tools';
		$this->data['submenu']='holidays';
		$this->load->view('templates/header',$this->data);
		$this->load->view('tools/holidaydetails');
		$this->load->view('templates/footer');
	}
	
	public function roles()
	{
		if ($this->input->post('btnSave'))
		{
			$this->form_validation->set_rules('rolename', 'Name', 'trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('tools/roles/');
			}
			else
			{
				$hid = (trim($this->input->post('hid'))=='' ? 0 : $this->input->post('hid'));
				
				$result=$this->tools_model->saverole
										(	$hid
											,$this->input->post('rolename')
											,$this->input->post('status')
											,$this->input->post('remarks')
											,$this->session->userdata('lmsmemberid')
										);		

				if($result['error_number']==0 && $hid==0)
				{
					$this->session->set_userdata('alertgreen', 'success');
					redirect('tools/roledetails/'.$result['returnid'].'/'.$this->mylibraries->encrypt('vr'.$result['returnid']));	
				}
				else if($result['error_number']==0)
				{
					$this->session->set_userdata('alertgreen', 'success');
					redirect('tools/roles/');
				}
				else
				{
					$this->session->set_userdata('alertred', $this->mylibraries->show_message($result['error_message']));
					redirect('tools/roles/');
				}
			}
		}
		

		$this->data['roles']=$this->tools_model->getroles();

		$this->data['mainmenu']='tools';
		$this->data['submenu']='roles';
		$this->load->view('templates/header',$this->data);
		$this->load->view('tools/roles');
		$this->load->view('templates/footer');
	}
	
	public function roledetails()
	{
		$this->data['param1']=$this->uri->segment(3);
		$this->data['param2']=$this->uri->segment(4);
		
		if ($this->input->post('btnSave'))
		{
			if ($this->input->post('menu'))
			{
				$ctr=0;
				foreach($this->input->post('menu') as $row)
				{
					$isedit=$isdelete=$isadd='F';
					if($this->input->post('isedit'))
					{
						if(in_array($row, $this->input->post('isedit')))
						{
							$isedit='T';
						}
					}
					if($this->input->post('isdelete'))
					{						
						if(in_array($row, $this->input->post('isdelete')))
						{
							$isdelete='T';
						}
					}
					if($this->input->post('isadd'))
					{						
						if(in_array($row, $this->input->post('isadd')))
						{
							$isadd='T';
						}
					}
					
					$this->tools_model->saveuseraccessmenu($ctr,$row,$this->uri->segment(3),$isadd,$isedit,$isdelete);
					$ctr=1;
				}
				
			}
			else
			{
				$this->tools_model->saveuseraccessmenu(2,null,$this->uri->segment(3),null,null,null);
			}
				
			$this->session->set_userdata('alertgreen', 'success');
			redirect('tools/roledetails/'.$this->uri->segment(3).'/'.$this->uri->segment(4));	
		}
		else
		{
			if($this->mylibraries->encrypt('vr'.$this->data['param1'])!=$this->data['param2'])
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
				redirect('tools/roles/');
			}
		}
		

		$this->data['details']=$this->tools_model->getroledetails($this->data['param1']);
		$this->data['usermenu']=$this->tools_model->getuseraccessmenu($this->data['param1']);
		
		

		$this->data['mainmenu']='tools';
		$this->data['submenu']='roles';
		$this->load->view('templates/header',$this->data);
		$this->load->view('tools/roledetails');
		$this->load->view('templates/footer');
	}
	
	public function useraccounts()
	{
		if ($this->input->post('btnSave'))
		{
			$this->form_validation->set_rules('emailaddress', 'Email Address', 'trim|required|xss_clean');
			$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('firstname', 'First Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('role', 'Role', 'trim|required|xss_clean');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('tools/useraccounts/');
			}
			
			if($this->input->post('password')!=$this->input->post('confirmpassword'))
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->show_message('Password and Confirm Password do not match'));
				redirect('tools/useraccounts/');
			}

			$parameters = array(
				'id'				=> 0,
				'emailaddress' 		=> $this->input->post('emailaddress'),
				'password' 			=> $this->mylibraries->encrypt($this->input->post('password')),
				'lastname' 			=> $this->input->post('lastname'),
				'firstname' 		=> $this->input->post('firstname'),
				'middleinitial' 	=> $this->input->post('middleinitial'),
				'mobilenumber' 		=> $this->input->post('mobilenumber'),
				'address' 			=> $this->input->post('address'),
				'roleid' 			=> $this->input->post('role'),
				'isactive' 			=> 'T',
				'remarks' 			=> $this->input->post('remarks'),
				'dateaccess'		=> '1',
				'ipaddress'			=> '::1',
				'branch'			=> $this->input->post('userbranch'),
				'entryuserid' 		=>	$this->session->userdata('lmsmemberid'),
				'entrydate' 		=>  date("Y-m-d H:i:s"),
				'isstrictmachineaccess' => $this->input->post('isstrictmachineaccess')
				);
			
			$result=$this->tools_model->saveuseraccount($parameters,$this->session->userdata('lmsmemberid'));	
			if($result['error_number']==0)
			{
				$this->session->set_userdata('alertgreen', 'success');
				redirect('tools/userdetails/'.$result['returnid'].'/'.$this->mylibraries->encrypt('vu'.$result['returnid']));	
			}
			else
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message($result['error_message']));
				redirect('tools/useraccounts/');
			}
		}
		

		$this->data['useraccounts']=$this->tools_model->getuseraccounts();
		$this->data['roles']=$this->tools_model->getactiveroles();
		$this->data['branches']=$this->tools_model->getbranches();

		$this->data['mainmenu']='tools';
		$this->data['submenu']='useraccounts';
		$this->load->view('templates/header',$this->data);
		$this->load->view('tools/useraccounts');
		$this->load->view('templates/footer');
	}
	
	public function userdetails()
	{
		$this->data['param1']=$this->uri->segment(3);
		$this->data['param2']=$this->uri->segment(4);
		
		if ($this->input->post('btnSave'))
		{
			$this->form_validation->set_rules('emailaddress', 'Email Address', 'trim|required|xss_clean');
			$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('firstname', 'First Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('role', 'Role', 'trim|required|xss_clean');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('tools/userdetails/'.$this->data['param1'].'/'.$this->data['param2']);	
			}
			
			$password = null;
			
			if($this->input->post('password')!='' && $this->input->post('confirmpassword')!='')
			{
				$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
				$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'trim|required|xss_clean');
				
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
					rredirect('tools/userdetails/'.$this->data['param1'].'/'.$this->data['param2']);	
				}
				
				if($this->input->post('password')!=$this->input->post('confirmpassword'))
				{
					$this->session->set_userdata('alertred',  $this->mylibraries->show_message('Password and Confirm Password do not match'));
					redirect('tools/userdetails/'.$this->data['param1'].'/'.$this->data['param2']);	
				}
				
				$password = $this->input->post('password');
			}

			$parameters = array(
				'id'				=> $this->data['param1'],
				'emailaddress' 		=> $this->input->post('emailaddress'),
				'password' 			=> $this->mylibraries->encrypt($password),
				'lastname' 			=> $this->input->post('lastname'),
				'firstname' 		=> $this->input->post('firstname'),
				'middleinitial' 	=> $this->input->post('middleinitial'),
				'mobilenumber' 		=> $this->input->post('mobilenumber'),
				'address' 			=> $this->input->post('address'),
				'roleid' 			=> $this->input->post('role'),
				'isactive' 			=> $this->input->post('status'),
				'remarks' 			=> $this->input->post('remarks'),
				'dateaccess'		=> $this->input->post('collectiondateaccess'),
				'ipaddress'			=> '::1',
				'branch'			=> $this->input->post('userbranch'),
				'entryuserid' 		=>	$this->session->userdata('lmsmemberid'),
				'entrydate' 		=>  date("Y-m-d H:i:s"),
				'isstrictmachineaccess' => $this->input->post('isstrictmachineaccess')
				);

			if (trim($password) == null) {
				unset($parameters['password']);
			}
			
			$result=$this->tools_model->saveuseraccount($parameters,$this->session->userdata('lmsmemberid'));	

			if($result['error_number']==0)
			{
				$this->session->set_userdata('alertgreen', 'success');
			}
			else
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message($result['error_message']));
			}
			
			redirect('tools/userdetails/'.$this->data['param1'].'/'.$this->data['param2']);	
		}
		else if ($this->input->post('btnSaveBranch'))
		{
			if ($this->input->post('branch'))
			{
				$ctr=0;
				foreach($this->input->post('branch') as $row)
				{
					$this->tools_model->saveuseraccessbranch($ctr,$row,$this->data['param1']);
					$ctr=1;
				}
			}
			else
			{
				$this->tools_model->saveuseraccessbranch(2,$row,$this->data['param1']);
			}
			
			$this->session->set_userdata('alertgreen', 'success');
			redirect('tools/userdetails/'.$this->data['param1'].'/'.$this->data['param2']);	
		}
		else if ($this->input->post('btnSaveArea'))
		{
			if ($this->input->post('areas'))
			{
				$ctr=0;
				foreach($this->input->post('areas') as $row)
				{
					$this->tools_model->saveuseraccessarea($ctr,$row,$this->data['param1']);
					$ctr=1;
				}
			}
			else
			{
				$this->tools_model->saveuseraccessarea(2,$row,$this->data['param1']);
			}
			
			$this->session->set_userdata('alertgreen', 'success');
			redirect('tools/userdetails/'.$this->data['param1'].'/'.$this->data['param2']);	
		}
		else{
			if($this->mylibraries->encrypt('vu'.$this->data['param1'])!=$this->data['param2'])
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
				redirect('tools/useraccounts/');
			}
		}
		

		$this->data['details']=$this->tools_model->getuseraccountsdetails($this->data['param1']);
		$this->data['usermenu']=$this->tools_model->getuseraccessmenu($this->data['param1']);
		$this->data['roles']=$this->tools_model->getactiveroles();
		$this->data['branches']=$this->tools_model->getbranches();
		$this->data['userbranch']=$this->tools_model->getuseraccessbranches($this->data['param1']);
		$this->data['userareas']=$this->tools_model->getuseraccessareas($this->data['param1']);

		$this->data['mainmenu']='tools';
		$this->data['submenu']='useraccounts';
		$this->load->view('templates/header',$this->data);
		$this->load->view('tools/userdetails');
		$this->load->view('templates/footer');
	}

	public function usermachinevalidation(){

		if ($this->uri->segment(3) == 'cookie'){
			if ($this->uri->segment(4)==1){
				$this->Usercookies_model->updateCookieStatus($this->uri->segment(5),'Active');
			}
			else if ($this->uri->segment(4)==0){
				$this->Usercookies_model->updateCookieStatus($this->uri->segment(5),'Unathorize');
			}
			else if ($this->uri->segment(4)==2){
				$this->Usercookies_model->updateCookieStatus($this->uri->segment(5),'Expired');
			}
			redirect('tools/usermachinevalidation/');
		}

		$this->data['cookiesPending']=$this->Usercookies_model->getUserCookies(null,null,'Pending');
		$this->data['cookiesActive']=$this->Usercookies_model->getUserCookies(null,null,'Active');
		$this->data['cookiesUnathorize']=$this->Usercookies_model->getUserCookies(null,null,'Unathorize');
		$this->data['cookiesOthers']=$this->Usercookies_model->getUserCookies(null,null,'Expired');
		
		$this->data['mainmenu']='tools';
		$this->data['submenu']='usermachinevalidation';
		$this->load->view('templates/header',$this->data);
		$this->load->view('tools/usermachineverification');
		$this->load->view('templates/footer');
	}
	
	
	
	
	public function ajxsrc()
	{
		if ($this->uri->segment(3)=='areas')
		{
			$result=$this->tools_model->getareasdetails($this->input->post('paramid'));
			echo json_encode($result);
		}
		else if ($this->uri->segment(3)=='branches')
		{
			$result=$this->tools_model->getbranchesdetails($this->input->post('paramid'));
			echo json_encode($result);
		}
		else if ($this->uri->segment(3)=='branchesareas')
		{
			$result=$this->tools_model->branchesareasdetails($this->input->post('paramid'));
			echo json_encode($result);
		}
		else if ($this->uri->segment(3)=='holiday')
		{
			$result=$this->tools_model->getholidaydetails($this->input->post('paramid'));
			echo json_encode($result);
		}
		else if ($this->uri->segment(3)=='role')
		{
			$result=$this->tools_model->getroledetails($this->input->post('paramid'));
			echo json_encode($result);
		}
		
		
	}
	
	
	
	
}

