<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class payment extends CI_Controller 
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
		$this->data['userdetails']=$this->tools_model->getuseraccountsdetails($this->session->userdata('lmsmemberid'));
		$this->data['selectedsearchtype']=null;
	}
	
	
	public function add()
	{
		$this->data['param1']=$this->uri->segment(3);
		$this->data['param2']=$this->uri->segment(4);
		
		$this->data['customerloans']=$this->data['selectedprofile']=$this->data['image']=$this->data['selectedloan']=$tempfile=$this->data['payments']=null;
		
		if ($this->input->post('btnSave'))
		{
			if (!$this->checkDateFormat($this->input->post('paymentdate')))
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message('Invalid date'));
				redirect('loan/payments/'.$this->data['param1'].'/'.$this->data['param2']);
			}

			
			$this->form_validation->set_rules('hid', 'Unique ID', 'trim|required|xss_clean');
			$this->form_validation->set_rules('paymenttype', 'Type', 'trim|required');
			$this->form_validation->set_rules('paymentamount', 'Amount', 'trim|required|xss_clean');
			$this->form_validation->set_rules('paymentdate', 'Date', 'trim|required');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('loan/payments/'.$this->data['param1'].'/'.$this->data['param2']);
			}

			$result=$this->loan_model->savepayment
									(	$this->input->post('hid')
										,$this->input->post('paymentdate')
										,'Regular'
										,$this->input->post('paymentamount')
										,$this->input->post('remarks')
										,$this->session->userdata('lmsmemberid')
									);		

			// print_r($result);
			// die();			
			
			if($result['error_number']==0)
			{
				$this->session->set_userdata('alertgreen', 'success');
			}
			else
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message($result['error_message']));
			}		

			redirect('payment/add/'.$this->input->post('customerloan').'/'.$this->mylibraries->encrypt($this->input->post('customerloan')));
			
			
			$this->data['selectedloan']=$this->input->post('customerloan');
			$this->data['selectedbranch']=$this->input->post('branch');
			$this->data['selectedarea']=$this->input->post('area');
			
			$this->data['loandetails']=$this->loan_model->getloandetails($this->input->post('customerloan'));
			$this->data['selectedprofile']=$this->customer_model->getcustomerprofiledetails($this->data['loandetails'][0]['customerid']);
			$this->data['areas']=$this->tools_model->getcollectorsbranchesareasactivebyuser($this->data['selectedbranch'],$this->session->userdata('lmsmemberid'));
			$this->data['customerloans']=$this->loan_model->searchcustomeractiveloan($this->data['selectedarea']);
			$this->data['totalpayments']=$this->loan_model->gettotalloanpayments($this->data['selectedloan']);
			$this->data['payments']=$this->loan_model->getloanpayments($this->data['selectedloan']);
			
			
		}
		else if ($this->uri->segment(3)!='')
		{

			if ($this->uri->segment(4)!=$this->mylibraries->encrypt($this->uri->segment(3)))
			{
				redirect('payment/add/');
			}
	
			$this->data['selectedloan']=$this->session->userdata('selectedloan');
			$this->data['selectedbranch']=$this->session->userdata('selectedbranch');
			$this->data['selectedarea']=$this->session->userdata('selectedarea');
			
			//$this->data['loandetails']=$this->loan_model->getloandetails(	$this->data['selectedloan']);
			//$this->data['selectedprofile']=$this->customer_model->getcustomerprofiledetails($this->data['loandetails'][0]['customerid']);
			//$this->data['areas']=$this->tools_model->getcollectorsbranchesareasactivebyuser($this->data['selectedbranch'],$this->session->userdata('lmsmemberid'));
			//$this->data['customerloans']=$this->loan_model->searchcustomeractiveloan($this->data['selectedarea']);
			//$this->data['totalpayments']=$this->loan_model->gettotalloanpayments($this->data['selectedloan']);
			//$this->data['payments']=$this->loan_model->getloanpayments($this->data['selectedloan']);
			
			$this->data['loandetails']=$this->loan_model->getloandetails($this->data['selectedloan']);
			if (!$this->data['loandetails'])
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
				redirect('payment/add/');
			}
			
			$this->data['selectedprofile']=$this->customer_model->getcustomerprofiledetails($this->data['loandetails'][0]['customerid']);
			if (empty($this->data['selectedprofile']))
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
					redirect('payment/add/');
			}
			
			$this->data['image']=$tempfile=null;
			$imageresult=$this->customer_model->getcustomerprofileimage($this->data['loandetails'][0]['customerid']);	
				
			if($imageresult)	
			{
				foreach($imageresult as $row)
				{
					$tempfile .= $row['content'];
				}
				$this->data['image']=$tempfile ;
			}
			
			
			
			$this->data['areas']=$this->tools_model->getcollectorsbranchesareasactivebyuser($this->data['selectedbranch'],$this->session->userdata('lmsmemberid'));
			$this->data['customerloans']=$this->loan_model->searchcustomeractiveloan($this->data['selectedarea']);
			$this->data['totalpayments']=$this->loan_model->gettotalloanpayments($this->data['selectedloan']);
			$this->data['payments']=$this->loan_model->getloanpayments($this->data['selectedloan']);
			
			$this->loan_model->updatebalance($this->data['selectedloan']);
			
		}
		else if ($this->input->post('btnView'))
		{
			$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');
			$this->form_validation->set_rules('area', 'Area', 'trim|required|xss_clean');
			$this->form_validation->set_rules('customerloan', 'Customer Loan', 'trim|required|xss_clean');
	
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('payment/add/');
			}
			
			$this->session->set_userdata('selectedloan', $this->input->post('customerloan'));
			$this->session->set_userdata('selectedbranch', $this->input->post('branch'));
			$this->session->set_userdata('selectedarea', $this->input->post('area'));
			
			redirect('payment/add/'.$this->input->post('customerloan').'/'.$this->mylibraries->encrypt($this->input->post('customerloan')));
			
			
			$this->data['selectedloan']=$this->input->post('customerloan');
			$this->data['selectedbranch']=$this->input->post('branch');
			$this->data['selectedarea']=$this->input->post('area');
		
			$this->session->set_userdata('selectedloan', $this->input->post('customerloan'));
			$this->session->set_userdata('selectedbranch', $this->input->post('branch'));
			$this->session->set_userdata('selectedarea', $this->input->post('area'));
			$this->loan_model->updatebalance($this->data['selectedloan']);
			// $this->data['loandetails']=$this->loan_model->getloandetails($this->input->post('customerloan'));
			// if (!$this->data['loandetails'])
			// {
				// $this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
				// redirect('payment/add/');
			// }
			
		
			
			// $this->data['selectedprofile']=$this->customer_model->getcustomerprofiledetails($this->data['loandetails'][0]['customerid']);
			// if (empty($this->data['selectedprofile']))
			// {
				// $this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
					// redirect('payment/add/');
			// }
			
			// $this->data['image']=$tempfile=null;
			// $imageresult=$this->customer_model->getcustomerprofileimage($this->data['loandetails'][0]['customerid']);	
				
			// if($imageresult)	
			// {
				// foreach($imageresult as $row)
				// {
					// $tempfile .= $row['content'];
				// }
				// $this->data['image']=$tempfile ;
			// }
			
			
			
			// $this->data['areas']=$this->tools_model->getcollectorsbranchesareasactivebyuser($this->data['selectedbranch'],$this->session->userdata('lmsmemberid'));
			// $this->data['customerloans']=$this->loan_model->searchcustomeractiveloan($this->data['selectedarea']);
			// $this->data['totalpayments']=$this->loan_model->gettotalloanpayments($this->data['selectedloan']);
			// $this->data['payments']=$this->loan_model->getloanpayments($this->data['selectedloan']);
			
			
		}
		

		$this->data['branches']=$this->tools_model->getuserbranches($this->session->userdata('lmsmemberid'));
		

		$this->data['mainmenu']='payment';
		$this->data['submenu']='add';
		$this->load->view('templates/header',$this->data);
		$this->load->view('payments/add');
		$this->load->view('templates/footer');
	}
	
	
	public function inquiry()
	{
		$this->data['selectedfrom']=$this->data['selectedto']=$this->data['selectedcustomer']=$this->data['selectedsearchtype']=$this->data['searchlist']=$this->data['selectedbranch']=$this->data['selectedarea']= null;
		$this->data['selectedbranch1']=$this->data['selectedbranch2']= null;
		
		
		if ($this->input->post('btnView'))
		{
			$this->form_validation->set_rules('searchtype', 'Type', 'trim|required|xss_clean');
	
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('payment/inquiry/');
			}
			
			if ($this->input->post('searchtype')==1)
			{
				$this->form_validation->set_rules('customer', 'Customer', 'trim|required|xss_clean');
	
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
					redirect('payment/inquiry/');
				}
				
				$this->data['searchlist']=$this->loan_model->getloanpaymentsby_customer($this->input->post('customer'));
				$this->data['selectedbranch1']=$this->input->post('paymentinquiry1branch');
				$this->data['selectedcustomer']=$this->input->post('customer');
				$this->data['selectedsearchtype']=$this->input->post('searchtype');
				$this->data['customers']=$this->customer_model->getcustomerbybranch($this->input->post('paymentinquiry1branch'));
			}
			else if ($this->input->post('searchtype')==2)
			{
				$this->form_validation->set_rules('datefrom', 'Date From', 'trim|required|xss_clean');
				$this->form_validation->set_rules('dateto', 'Date To', 'trim|required|xss_clean');
	
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
					redirect('payment/inquiry/');
				}
				
				$this->data['searchlist']=$this->loan_model->getloanpaymentsby_dates($this->input->post('paymentinquiry2branch'),$this->input->post('datefrom'),$this->input->post('dateto'));
				$this->data['selectedto']=$this->input->post('dateto');
				$this->data['selectedfrom']=$this->input->post('datefrom');
				$this->data['selectedsearchtype']=$this->input->post('searchtype');
				$this->data['selectedbranch2']=$this->input->post('paymentinquiry2branch');
				
			}
			else if ($this->input->post('searchtype')==3)
			{
				$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');
				$this->form_validation->set_rules('area', 'Area', 'trim|required|xss_clean');
				$this->form_validation->set_rules('datefrom', 'Date From', 'trim|required|xss_clean');
				$this->form_validation->set_rules('dateto', 'Date To', 'trim|required|xss_clean');
	
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
					redirect('payment/inquiry/');
				}
				
				$this->data['areas']=$this->tools_model->getcollectorsbranchesareasactivebyuser($this->input->post('branch'),$this->session->userdata('lmsmemberid'));
				$this->data['searchlist']=$this->loan_model->getloanpaymentsby_aresdates($this->input->post('area'),$this->input->post('datefrom'),$this->input->post('dateto'));
				
				
				$this->data['selectedto']=$this->input->post('dateto');
				$this->data['selectedfrom']=$this->input->post('datefrom');
				$this->data['selectedbranch']=$this->input->post('branch');
				$this->data['selectedarea']=$this->input->post('area');
				$this->data['selectedsearchtype']=$this->input->post('searchtype');
				
				
			}
			
			
			
		}
		
		
		
		
		$this->data['branches']=$this->tools_model->getuserbranches($this->session->userdata('lmsmemberid'));
		
		$this->data['mainmenu']='payment';
		$this->data['submenu']='inquiry';
		$this->load->view('templates/header',$this->data);
		$this->load->view('payments/inquiry');
		$this->load->view('templates/footer');
		
	}
	
	
	
	function systemfunction()
	{
		
		if($_POST['type']=='a')
		{

			$areas=$this->tools_model->getcollectorsbranchesareasactivebyuser($_POST['param'],$this->session->userdata('lmsmemberid'));
			$output = '<option value="">Select an Option</option>';
			if ($areas)
			{
				foreach($areas as $row)
				{
					$output .='<option value="'.$row['branchareaid'].'">'.$row['areaname'].'</option>';
				}
			}
			
			echo json_encode($output);
		}
		else if($_POST['type']=='b')
		{

			$loans=$this->loan_model->searchcustomeractiveloan($_POST['param']);
			$output = '<option value="">Select an Option</option>';
			
			if ($loans)
			{
				foreach($loans as $row)
				{
					$output .= '<option value="'.$row['loanid'].'">'.$row['referencenumber'].' '.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname']).'</option>';
				}
			}
			
			echo json_encode($output);
		}
		else if($_POST['type']=='c')
		{

			$profile=$this->customer_model->getcustomerbybranch($_POST['param']);
			$output = '<option value="">Select an Option</option>';
			
			if ($profile)
			{
				foreach($profile as $row)
				{
					$output .= '<option value="'.$row['customerid'].'">'.$row['refnumber'].' - '.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname']).'</option>';
				}
			}
			
			echo json_encode($output);
		}
		
		


	}
	
	function checkDateFormat($date) 
	{
		if (!empty(trim($date)))
		{
			if (strlen($date)>10)
			{
				return false;
			}
			if(checkdate(substr($date, 5, 2), substr($date, 8, 2), substr($date, 0, 4)))
			{
				return true;
			}
			else
			{
				return false;
			}

		}
		else
		{
			return true;
		}
	}
	
	
}