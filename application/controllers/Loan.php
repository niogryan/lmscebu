<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class loan extends CI_Controller 
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
		//$this->mylibraries->echodie($this->data['accessmenu']);
	}
	
	public function index()
	{
		$this->data['loans']=null;
		$this->data['selectedsortby']=1;
		if ($this->input->post('btnView'))
		{
			$this->form_validation->set_rules('branch', 'Branch & Area', 'trim|required|xss_clean');
	
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('loan/index/');
			}
			
			$this->data['loans']=$this->loan_model->searchcustomerloan($this->input->post('area'),$this->input->post('sortby'));
			$this->data['areas']=$this->tools_model->getcollectorsbranchesareasactivebyuser($this->input->post('branch'),$this->session->userdata('lmsmemberid'));
				
			$this->data['selectedbranch']=trim($this->input->post('branch'));
			$this->data['selectedarea']=trim($this->input->post('area'));
			$this->data['selectedsortby']=trim($this->input->post('sortby'));
		}
		
		$this->data['branches']=$this->tools_model->getuserbranches($this->session->userdata('lmsmemberid'));
		$this->data['branchesareas']=$this->tools_model->getbranchesareasactivebyuser($this->session->userdata('lmsmemberid'));
		
		$this->data['mainmenu']='loan';
		$this->data['submenu']='loanindex';
		$this->load->view('templates/header',$this->data);
		$this->load->view('loan/index');
		$this->load->view('templates/footer');
	}
	
	public function details()
	{
		$this->data['param1']=$this->uri->segment(3);
		$this->data['param2']=$this->uri->segment(4);
		
		$this->session->unset_userdata('selectedbranch');
		$this->session->unset_userdata('selectedprofile');
		
		if ($this->input->post('btnSave'))
		{
			if (!$this->checkDateFormat($this->input->post('paymentdate')))
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message('Invalid date'));
				rredirect('loan/details/'.$this->data['param1'].'/'.$this->data['param2']);
			}
			
			
			$this->form_validation->set_rules('paymenttype', 'Type', 'trim|required');
			$this->form_validation->set_rules('paymentamount', 'Amount', 'trim|required|xss_clean');
			$this->form_validation->set_rules('paymentdate', 'Date', 'trim|required');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('loan/details/'.$this->data['param1'].'/'.$this->data['param2']);
			}
			
			$result=$this->loan_model->savepayment
									(	$this->data['param1']
										,$this->input->post('paymentdate')
										,$this->input->post('paymenttype')
										,$this->input->post('paymentamount')
										,$this->input->post('remarks')
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
			
			redirect('loan/details/'.$this->data['param1'].'/'.$this->data['param2']);

		}
		else if ($this->input->post('btnUpdate'))
		{
			$this->form_validation->set_rules('editpaymenttype', 'Type', 'trim|required');
			$this->form_validation->set_rules('editpaymentamount', 'Amount', 'trim|required|xss_clean');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('loan/details/'.$this->data['param1'].'/'.$this->data['param2']);
			}
			
			$result=$this->loan_model->updatepayment
									(	
										$this->data['param1']
										,$this->input->post('edithid')
										,$this->input->post('editpaymentdateadmin')
										,$this->input->post('editpaymenttype')
										,$this->input->post('editpaymentamount')
										//,$this->input->post('editremarks').'<br /> Edited By '.$this->session->userdata('name').' '.date("Y-m-d  H:i")
										,'Edited By '.$this->session->userdata('name').' '.date("Y-m-d  H:i")
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
			
			redirect('loan/details/'.$this->data['param1'].'/'.$this->data['param2']);

		}
		else if ($this->input->post('btnDelete'))
		{
			$this->data['param1']=$this->uri->segment(3);
			$this->data['param2']=$this->uri->segment(4);
			
			
			$result=$this->loan_model->deleteloan
									(	$this->data['param1']
										,$this->session->userdata('lmsmemberid')
									);				
			
			if($result['error_number']==0)
			{
				$this->session->set_userdata('alertgreen', 'success');
				redirect('loan/index/');
			}
			else
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message($result['error_message']));
				redirect('loan/details/'.$this->data['param1'].'/'.$this->data['param2']);
			}		
		}
		else if (trim($this->uri->segment(3))=='d')
		{

			if($this->mylibraries->encrypt('d'.$this->uri->segment(4).$this->uri->segment(5))!=$this->uri->segment(6))
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
				redirect('loan/index/');
			}
			
			$result=$this->loan_model->deletepayment
									(	$this->uri->segment(4)
										,$this->uri->segment(5)
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
			
			redirect('loan/details/'.$this->uri->segment(5).'/'.$this->mylibraries->encrypt('v'.$this->uri->segment(5)));
			
		}
		else
		{
			if($this->mylibraries->encrypt('v'.$this->uri->segment(3))!=$this->uri->segment(4))
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
				redirect('loan/index/');
			}
		}
		
	
		
		
		$this->data['loandetails']=$this->loan_model->getloandetails($this->data['param1']);
		if (!$this->data['loandetails'])
		{
			$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
			redirect('loan/index/');
		}
		
		$this->loan_model->updatebalance($this->data['param1']);
		
		
		$this->data['selectedprofile']=$this->customer_model->getcustomerprofiledetails($this->data['loandetails'][0]['customerid']);
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
		$this->data['payments']=$this->loan_model->getloanpayments($this->data['param1']);
		$this->data['totalpayments']=$this->loan_model->gettotalloanpayments($this->data['param1']);




		
		$this->data['mainmenu']='loan';
		$this->data['submenu']='index';
		$this->load->view('templates/header',$this->data);
		$this->load->view('loan/details');
		$this->load->view('templates/footer');
	}
	
	public function payments()
	{
		$this->data['param1']=$this->uri->segment(3);
		$this->data['param2']=$this->uri->segment(4);
		
		$this->data['loans']=$this->data['selectedprofile']=$this->data['image']=$tempfile=null;
		
		if ($this->input->post('btnSave'))
		{
			$this->form_validation->set_rules('hid', 'Unique ID', 'trim|required|xss_clean');
			$this->form_validation->set_rules('paymenttype', 'Type', 'trim|required');
			$this->form_validation->set_rules('paymentamount', 'Amount', 'trim|required|xss_clean');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('loan/payments/'.$this->data['param1'].'/'.$this->data['param2']);
			}

			$result=$this->loan_model->savepayment
									(	$this->input->post('hid')
										,date("Y-m-d")
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

			redirect('loan/payments/p/'.$this->data['param2']);
		}
		else if (!empty($this->input->post('branch')))
		{

			$this->form_validation->set_rules('branch', 'Branch & Area', 'trim|required|xss_clean');
	
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('loan/payments/');
			}
			
			$this->data['loans']=$this->loan_model->searchcustomeractiveloan($this->input->post('branch'));
			$this->session->set_userdata('selectedbranch',  trim($this->input->post('branch')));
		}
		else if (trim($this->uri->segment(3))=='p')
		{

			//echo $this->uri->segment(3);
			
			$this->session->set_userdata('selectedloan', $this->uri->segment(4));
			$this->data['loandetails']=$this->loan_model->getloandetails($this->uri->segment(4));
			if (!$this->data['loandetails'])
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
				redirect('loan/payments/');
			}
			
			$this->data['selectedprofile']=$this->customer_model->getcustomerprofiledetails($this->data['loandetails'][0]['customerid']);
			if (empty($this->data['selectedprofile']))
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
				redirect('loan/payments/');
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
			
			$this->data['loans']=$this->loan_model->searchcustomeractiveloan($this->session->userdata('selectedbranch'));
			$this->data['totalpayments']=$this->loan_model->gettotalloanpayments($this->uri->segment(4));
		}
		else
		{
			$this->data['loans']=$this->data['selectedprofile']=$this->data['loandetails']=null;
			
		}
		
		//$this->data['branchesareas']=$this->tools_model->getbranchesareasactive();
		
		
		$this->data['branchesareas']=$this->tools_model->getcollectorsbranchesareasactivebyuser($this->session->userdata('lmsmemberid'));
		$this->data['payments']=$this->loan_model->getloanpayments($this->uri->segment(4));

		$this->data['mainmenu']='loanpayment';
		$this->data['submenu']='payments';
		$this->load->view('templates/header',$this->data);
		$this->load->view('loan/payment');
		$this->load->view('templates/footer');
	}
	
	
	public function add()
	{
		$this->data['param1']=$this->uri->segment(3);
		$this->data['param2']=$this->uri->segment(4);
		
		$this->data['selectedcustomer']=$tempfile=$this->data['selectedarea']=$this->data['selectedbranch']=null;
		$this->data['selectedprofile']=$this->data['image']=$tempfile=$this->data['areas']=$this->data['profile']=null;
		
		if ($this->input->post('btnContinue'))
		{
			$this->form_validation->set_rules('hid', 'Unique ID', 'trim|required|xss_clean');
			$this->form_validation->set_rules('hbranch', 'Branch Area', 'trim|required|xss_clean');
			$this->form_validation->set_rules('releasedate', 'Date Released', 'trim|required|xss_clean|callback_checkDateFormat', array('checkDateFormat'  => 'Invalid Date Format'));
			$this->form_validation->set_rules('duedate', 'Due Date', 'trim|required|callback_checkDateFormat', array('checkDateFormat'  => 'Invalid Date Format'));
			$this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean');
			$this->form_validation->set_rules('interest', 'Interest', 'trim|required|xss_clean');
			$this->form_validation->set_rules('dailydues', 'Daily Dues', 'trim|required|xss_clean');
			$this->form_validation->set_rules('servicecharge', 'Service Charge', 'trim|required|xss_clean');
			$this->form_validation->set_rules('passbokcharge', 'Passbook Charge', 'trim|required|xss_clean');
			$this->form_validation->set_rules('totalamountreleased', 'Total Amount Release', 'trim|required|xss_clean');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('loan/add/'.$this->data['param1'].'/'.$this->data['param2']);
			}
			
				$loancomputation=$this->mylibraries->loancomputation($this->input->post('branch'),$this->input->post('releasedate'),$this->input->post('amount'),$this->input->post('passbokcharge'));
				
				$result=$this->loan_model->saveloan
										(	$this->input->post('hid')
											,$this->input->post('hbranch')
											,$this->input->post('hbrancharea')
											,$this->input->post('releasedate')
											,$loancomputation['duedate']
											,$this->input->post('amount')
											,$loancomputation['interest']
											,$loancomputation['servicecharge']
											,$loancomputation['dailydues']
											,$loancomputation['count']
											,$loancomputation['specialpayment']
											,$this->input->post('passbokcharge')
											,$this->input->post('advancepayment')
											,$loancomputation['totalamountrelease']
											,$this->input->post('remarks')
											,$this->session->userdata('lmsmemberid')
										);								
				
				if($result['error_number']==0)
				{
					$this->session->set_userdata('alertgreen', 'success');
					redirect('loan/details/'.$result['returnid'].'/'.$this->mylibraries->encrypt('v'.$result['returnid']));
				}
				else
				{
					$this->session->set_userdata('alertred', $this->mylibraries->show_message($result['error_message']));
				}		
				
				redirect('loan/add/'.$this->data['param1'].'/'.$this->data['param2']);
			
			
		}
		else if ($this->input->post('btnView'))
		{
			$this->data['profile']=null;
			
			$this->data['selectedprofile']=$this->customer_model->getcustomerprofiledetails($this->input->post('customer'));
			
			if (empty($this->data['selectedprofile']))
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
				redirect('loan/add/');
			}

			$imageresult=$this->customer_model->getcustomerprofileimage($this->uri->segment(4));	
			if($imageresult)	
			{
				foreach($imageresult as $row)
				{
					$tempfile .= $row['content'];
				}
				$this->data['image']=$tempfile ;
			}
			
			$this->data['selectedcustomer']=$this->input->post('customer');
			$this->data['selectedbranch']=$this->input->post('branch');
			$this->data['selectedarea']=$this->input->post('area');

			$this->data['areas']=$this->tools_model->getareasbybranch($this->input->post('branch'));
			$this->data['profile']=$this->loan_model->searchcustomerprofile($this->input->post('area'));
		}
		// else if (!empty($this->input->post('branch')) && !empty($this->input->post('area')))
		// {
			// $this->data['areas']=$this->tools_model->getareasbybranch($this->session->userdata('selectedbranch'));
			// $this->session->set_userdata('selectedarea',  trim($this->input->post('area')));
			// $this->data['profile']=$this->loan_model->searchcustomerprofile($this->input->post('area'));
			
		// }
		
		// else if (!empty($this->input->post('branch')))
		// {

			// $this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');
	
			// if ($this->form_validation->run() == FALSE)
			// {
				// $this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				// redirect('loan/add/');
			// }
			
			// $this->data['areas']=$this->tools_model->getareasbybranch($this->input->post('branch'));
			// $this->session->set_userdata('selectedbranch',  trim($this->input->post('branch')));
		// }
		
		
		// else
		// {
			// $this->data['areas']=$this->tools_model->getareasbybranch($this->session->userdata('selectedbranch'));
			// //$this->data['profile']=$this->loan_model->searchcustomerprofile($this->session->userdata('selectedarea'));
		//}
		
		$this->data['branches']=$this->tools_model->getuserbranches($this->session->userdata('lmsmemberid'));
		$this->data['branchesareas']=$this->tools_model->getbranchesareasactivebyuser($this->session->userdata('lmsmemberid'));

		$this->data['mainmenu']='loan';
		$this->data['submenu']='addloan';
		$this->load->view('templates/header',$this->data);
		$this->load->view('loan/add');
		$this->load->view('templates/footer');
	}
	
	function systemfunction()
	{
		if($_POST['type']=='a')
		{
			$result=null;
			$servicecharge=0;
			$startdate = $_POST['paramdate'];
			$paramamount=(trim($_POST['paramamount'])=='' ? 0 : trim($_POST['paramamount']));
			$parampassbook=(trim($_POST['parampassbook'])=='' || trim($_POST['parampassbook'])< '1'  ? 0 : trim($_POST['parampassbook']));
			//$paramadvancepayment=(trim($_POST['paramadvancepayment'])=='' || trim($_POST['paramadvancepayment'])< '1'  ? 0 : $_POST['paramadvancepayment']);
			
			$date_due = date("Y-m-d", strtotime($_POST['paramdate'] . " + 60 days"));
			$numberholiday=$this->tools_model->getnumberofholidays($_POST['parambranch'],$startdate,$date_due);
			$queryresult=$this->tools_model->getnumberofholidays($_POST['parambranch'],$startdate,$date_due);
			
			if ($paramamount>0 && trim($paramamount)!='' && $_POST['parambranch']!='')
			{
				$scresult=$this->tools_model->getservicechargebybranchamount($_POST['parambranch'],$paramamount);
				if ($scresult)
				{
					$servicecharge=$scresult[0]['servicechargeamount'];
				}
			}
			

			$result['dailydues'] =(($paramamount + ($paramamount * .20)) / 60);
			$result['interest'] = number_format(($paramamount * .20), 2, '.', ',');
			$result['formatamount'] = 'Php '.number_format($paramamount, 2, '.', ',');
			$result['duedate']=$date_due ;
			$result['count']=$queryresult;
			$result['servicecharge'] = number_format(($paramamount<1000 ? 50 : $servicecharge),2, '.', ',');
			$result['specialpayment'] = ($result['dailydues'] * $numberholiday);
			$result['amountinterest'] = number_format(($paramamount * .20) + $paramamount, 2, '.', ',');
				
				
			if ($paramamount>0 && trim($paramamount)!='' && $_POST['parambranch']!='')
			{
				$result['totalamountrelease'] = number_format($paramamount - ($result['servicecharge'] + $parampassbook), 2, '.', ',');
			}
			else
			{
				$result['totalamountrelease'] = null;
			}
			
			
			echo json_encode($result);
		}
		else if($_POST['type']=='b')
		{
			$result=null;
			$paramamount=(trim($_POST['paramamount'])=='' ? 0 : trim($_POST['paramamount']));
			$result['formatamount'] = 'Php '.number_format($paramamount, 2, '.', ',');
			echo json_encode($result);
		}
		else if($_POST['type']=='c')
		{
			$result=$this->loan_model->getloanpaymentdetails($_POST['paramid']);
			echo json_encode($result);
		}
		else if($_POST['type']=='d')
		{
			$areas=$this->tools_model->getareasbybranch($_POST['param']);
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
		else if($_POST['type']=='e')
		{

			$profile=$this->loan_model->searchcustomerprofile($_POST['param']);
			$output = '<option value="">Select an Option</option>';
			
			if ($profile)
			{
				foreach($profile as $row)
				{
					$output .= '<option value="'.$row['customerid'].'">'.$row['refnumber'].' '.$this->mylibraries->returnreplacespecialcharacter($row['lastname'].' '.$row['suffix'].', '.$row['firstname']).'</option>';
				}
			}
			
			echo json_encode($output);
		}
		

	}
	
	
	public function inquiry()
	{
		$this->data['selectedtype']=$this->data['selectedbranch']=$this->data['selecteddate']=$this->data['loans']=  null;
		
		
		if ($this->input->post('btnView'))
		{
			// $this->form_validation->set_rules('searchtype', 'Type', 'trim|required|xss_clean');
	
			// if ($this->form_validation->run() == FALSE)
			// {
				// $this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				// redirect('loan/inquiry/');
			// }
			
			if ($this->input->post('searchtype')==1)
			{
				$this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
				$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');
	
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
					redirect('loan/inquiry/');
				}
				
				$this->data['loans']=$this->loan_model->getcustomerloanbybranchdate($this->input->post('branch'),$this->input->post('date'));
				$this->data['selectedbranch']=$this->input->post('branch');
				$this->data['selecteddate']=$this->input->post('date');
				$this->data['customers']=$this->customer_model->getcustomerbybranch($this->input->post('paymentinquiry1branch'));
			}
			// else if ($this->input->post('searchtype')==1)
			// {
				// $this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
				// $this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');
	
				// if ($this->form_validation->run() == FALSE)
				// {
					// $this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
					// redirect('loan/inquiry/');
				// }
				
				// $this->data['loans']=$this->loan_model->getcustomerloanbybranchdate($this->input->post('branch'),$this->input->post('date'));
				// $this->data['selectedbranch']=$this->input->post('branch');
				// $this->data['selecteddate']=$this->input->post('date');
				// $this->data['customers']=$this->customer_model->getcustomerbybranch($this->input->post('paymentinquiry1branch'));
			// }
			
			
			
		}
		
		
		
		
		$this->data['branches']=$this->tools_model->getuserbranches($this->session->userdata('lmsmemberid'));
		
		$this->data['mainmenu']='loan';
		$this->data['submenu']='loaninquiry';
		$this->load->view('templates/header',$this->data);
		$this->load->view('loan/inquiry');
		$this->load->view('templates/footer');
		
	}
	
	function checkDateFormat($date) 
	{
		return $this->mylibraries->checkDateFormat($date);
	}
}
