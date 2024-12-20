<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class transaction extends CI_Controller 
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
		//$this->mylibraries->echodie($this->data['accessmenu']);
		$this->data['selectedsearchtype']=null;
	}
	
	public function cashonhand()
	{
		$this->data['list']=null;
		$this->data['selectedbranch']=null;
		
		if ($this->input->post('btnSave'))
		{
			
			$this->form_validation->set_rules('branchoption', 'Branch', 'trim|required|xss_clean');
			$this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
			$this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('transaction/cashonhand/');
			}
			else
			{
				
				$result=$this->transaction_model->cashonhand
										(	$this->input->post('branchoption')
											,$this->input->post('date')
											,$this->input->post('amount')
											,$this->input->post('remarks')
											,$this->session->userdata('lmsmemberid')
										);				

				if($result['error_number']==0)
				{
					$this->session->set_userdata('alertgreen', 'success');
				}
				else
				{
					$this->session->set_userdata('alertdanger', $this->mylibraries->show_message($result['error_message']));
				}
				redirect('transaction/cashonhand/');
				
			}	

			redirect('transaction/cashonhand/');
		}
		else if ($this->input->post('btnForward'))
		{
			$this->form_validation->set_rules('forwardbranch', 'Branch', 'trim|required|xss_clean');
			$this->form_validation->set_rules('forwarddate', 'Date', 'trim|required|xss_clean');
			$this->form_validation->set_rules('temp', 'hDate', 'trim|required|xss_clean');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertdanger',  $this->mylibraries->show_message(validation_errors()));
				redirect('app/cashonhand/');
			}
			else
			{
				$result=$this->transaction_model->getcashonhanddetails($this->input->post('temp'));
				$amountreleased=$this->mylibraries->loanreleasedamountbybranchdate($this->input->post('forwardbranch'),$this->input->post('temp'));
				$expenses=$this->mylibraries->expensesperdatebranch($this->input->post('forwardbranch'),$this->input->post('temp'));
				$transamount=$this->mylibraries->transactionamountperdate($this->input->post('temp'));
				$servicecharge=$this->mylibraries->loansservicechargebybranchdate($this->input->post('forwardbranch'),$this->input->post('temp'));
				
				$totalcashonhand=0;
				foreach($result as $row)
				{
					$totalcashonhand += $row['amount'];
				}
				
				$totalcashonhand=($totalcashonhand+$servicecharge)-($transamount+$expenses+$amountreleased);
				
				$this->transaction_model->cashonhand
										(	$this->input->post('forwardbranch')
											,$this->input->post('temp')
											,($totalcashonhand* -1)
											,'Forwarded Remaining Cash to '.$this->input->post('forwarddate')
											,$this->session->userdata('oslmsuserid')
										);				
				
				$this->transaction_model->cashonhand
										(	$this->input->post('forwardbranch')
											,$this->input->post('forwarddate')
											,$totalcashonhand
											,'Remaining Cash from '.$this->input->post('temp')
											,$this->session->userdata('oslmsuserid')
										);	
							
				$this->session->set_userdata('alertsuccess', $this->mylibraries->show_message('processcomplete'));
				redirect('app/cashonhand/');
				
			}
		}
		else if (!empty($this->input->post('branch')))
		{

			$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');
	
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('transaction/cashonhand/');
			}
			
			$this->data['list']=$this->transaction_model->getcashonhand($this->input->post('branch'));
			$this->session->set_userdata('selectedbranch',  trim($this->input->post('branch')));
			$this->data['selectedbranch']=$this->input->post('branch');
		}
		else if (trim($this->uri->segment(3))=='d')
		{

			if($this->mylibraries->encrypt('dexs'.$this->uri->segment(4))!=$this->uri->segment(5))
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
				redirect('transaction/cashonhand/');
			}
			
			$result=$this->transaction_model->deleteexpenses
									(	$this->uri->segment(4)
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
			
			redirect('transaction/cashonhand/');
			
		}
		else
		{
			if (!empty($this->session->userdata('selectedbranch')))
			{
				$this->data['list']=$this->transaction_model->getcashonhand($this->session->userdata('selectedbranch'));
				$this->data['selectedbranch']=$this->session->userdata('selectedbranch');
			}
		}
		
		
		
		$this->data['branches']=$this->tools_model->getuserbranches($this->session->userdata('lmsmemberid'));
		
		$this->data['mainmenu']='transactions';
		$this->data['submenu']='cashonhand';
		$this->load->view('templates/header',$this->data);
		$this->load->view('transaction/cashonhand');
		$this->load->view('templates/footer');
	}
	
	public function remittance()
	{
		$this->data['remittance']=null;
		if ($this->input->post('btnSave'))
		{
			$this->form_validation->set_rules('optionbranch', 'Branch', 'trim|required|xss_clean');
			$this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean');
			$this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
	
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('transaction/remittance/');
			}
			
			$result=$this->transaction_model->saveremittance
									(	$this->input->post('hid')
										,$this->input->post('optionbranch')
										,$this->input->post('date')
										,$this->input->post('amount')
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

			redirect('transaction/remittance/');
		}
		else if (!empty($this->input->post('branch')))
		{

			$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');
	
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('transaction/remittance/');
			}
			
			$this->data['remittance']=$this->transaction_model->getbranchremittances($this->input->post('branch'));
			$this->data['summary']=$this->transaction_model->getbranchremittancessummary($this->input->post('branch'));
			$this->session->set_userdata('selectedbranch',  trim($this->input->post('branch')));
		}
		else if (trim($this->uri->segment(3))=='d')
		{

			if($this->mylibraries->encrypt('drem'.$this->uri->segment(4))!=$this->uri->segment(5))
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
				redirect('transaction/expenses/');
			}
			
			$result=$this->transaction_model->deleteremittance
									(	$this->uri->segment(4)
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
			
			redirect('transaction/remittance/');
		}
		else
		{
			$this->data['remittance']=$this->transaction_model->getbranchremittances($this->session->userdata('selectedbranch'));
			$this->data['summary']=$this->transaction_model->getbranchremittancessummary($this->session->userdata('selectedbranch'));
			
		}
		
		$this->data['branches']=$this->tools_model->getuserbranches($this->session->userdata('lmsmemberid'));
		
		$this->data['mainmenu']='transactions';
		$this->data['submenu']='remittance';
		$this->load->view('templates/header',$this->data);
		$this->load->view('transaction/remittance');
		$this->load->view('templates/footer');
	}
	
	public function expenses()
	{
		$this->data['loans']=null;
		$this->data['expenses']=null;
		
		if ($this->input->post('btnSave'))
		{
			
			$this->form_validation->set_rules('hid', 'Unique ID', 'trim|required|xss_clean');
			$this->form_validation->set_rules('optionbranch', 'Branch', 'trim|required');
			$this->form_validation->set_rules('type', 'Type', 'trim|required|xss_clean');
			$this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
			$this->form_validation->set_rules('payee', 'Payee', 'trim|required|xss_clean');
			$this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean');
			$this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('transaction/expenses/');
			}

			$result=$this->transaction_model->saveexpenses
									(	$this->input->post('hid')
										,$this->input->post('optionbranch')
										,$this->input->post('type')
										,$this->input->post('date')
										,$this->input->post('voucher')
										,$this->input->post('payee')
										,$this->input->post('description')
										,$this->input->post('amount')
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

			redirect('transaction/expenses/');
		}
		else if (!empty($this->input->post('branch')))
		{

			$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');
	
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('transaction/expenses/');
			}
			
			$this->data['expenses']=$this->transaction_model->getbranchexpenses($this->input->post('branch'));
			$this->data['summary']=$this->transaction_model->getbranchexpensessummary($this->input->post('branch'));
			$this->session->set_userdata('selectedbranch',  trim($this->input->post('branch')));
		}
		else if (trim($this->uri->segment(3))=='d')
		{

			if($this->mylibraries->encrypt('dexs'.$this->uri->segment(4))!=$this->uri->segment(5))
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
				redirect('transaction/expenses/');
			}
			
			$result=$this->transaction_model->deleteexpenses
									(	$this->uri->segment(4)
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
			
			redirect('transaction/expenses/');
			
		}
		else
		{
			if (!empty($this->session->userdata('selectedbranch')))
			{
				$this->data['expenses']=$this->transaction_model->getbranchexpenses($this->session->userdata('selectedbranch'));
				$this->data['summary']=$this->transaction_model->getbranchexpensessummary($this->session->userdata('selectedbranch'));
			}
		}
		
		
		$this->data['expensestype']=$this->transaction_model->getexpensestype();
		$this->data['branches']=$this->tools_model->getuserbranches($this->session->userdata('lmsmemberid'));
		
		$this->data['mainmenu']='transactions';
		$this->data['submenu']='expenses';
		$this->load->view('templates/header',$this->data);
		$this->load->view('transaction/expenses');
		$this->load->view('templates/footer');
	}
	
	
	
	
	function systemfunction()
	{
		if($_POST['type']=='a')
		{
			$result=$this->transaction_model->getbranchexpensesdetails($_POST['paramid']);
			echo json_encode($result);
		}
		else if($_POST['type']=='b')
		{
			$result=$this->transaction_model->getbranchremittancesdetails($_POST['paramid']);
			echo json_encode($result);
		}
		

	}
	
	
}