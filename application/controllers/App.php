<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class app extends CI_Controller 
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
		$this->data['mainmenu']='home';
		$this->data['submenu']='';
		$this->load->view('templates/header',$this->data);
		$this->load->view('app/index');
		$this->load->view('templates/footer');
	}
	
	public function badaccounts()
	{
		$this->data['loans']=null;
		if ($this->input->post('btnSearch'))
		{

			$this->data['loans']=$this->customer_model->searchbadaccounts($this->input->post('searchtext'));
			$this->session->set_userdata('searchtext',  trim($this->input->post('searchtext')));
		}
		

		$this->data['mainmenu']='badaccounts';
		$this->data['submenu']='';
		$this->load->view('templates/header',$this->data);
		$this->load->view('app/badaccounts');
		$this->load->view('templates/footer');
	}
	
	public function changepassword()
	{
		if ($this->input->post('btnSave'))
		{
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'trim|required|xss_clean');

			
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('app/changepassword/');	
			}
			
			$password = $this->input->post('password');
			
			if($this->input->post('password')!=$this->input->post('confirmpassword'))
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->show_message('Password and Confirm Password do not match'));
				redirect('app/changepassword/');	
			}
			
			$result=$this->system_model->changepassword
										(	$this->session->userdata('lmsmemberid')
											,$password
										);	

			if($result['error_number']==0)
			{
				$this->session->set_userdata('alertgreen', 'success');
			}
			else
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message($result['error_message']));
			}
			
			redirect('app/changepassword/');	
		}
		
		
		$this->data['mainmenu']='changepassword';
		$this->data['submenu']='';
		$this->load->view('templates/header',$this->data);
		$this->load->view('app/changepassword');
		$this->load->view('templates/footer');
	}
}
