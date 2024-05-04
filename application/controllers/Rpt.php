<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class rpt extends CI_Controller 
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
	
	public function summary()
	{
		try
		{
			$this->data['selectedperiod']=$this->data['selectedbranch']=$this->data['selecteddate']=$this->data['selectedmonth']=$this->data['selectedyear']=$this->data['selectedfrom']=$this->data['selectedto']=null;
			$this->data['timestart']= null;
			
			if ($this->input->post('btnView'))
			{
				$this->form_validation->set_rules('branch', 'Branch & Area', 'trim|required|xss_clean');
				//$this->form_validation->set_rules('period', 'Period', 'trim|required|xss_clean');
				
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
					redirect('rpt/summary/');
				}
				
				$this->data['timestart']= date('Y-m-d H:i:s');
				$this->data['selectedbranch']=$this->input->post('branch');
				$this->data['selectedperiod']='D';
				$this->data['selecteddate']=$this->input->post('date');
				$this->data['selectedmonth']=$this->input->post('month');
				$this->data['selectedyear']=$this->input->post('year');
				$this->data['selectedfrom']=$this->input->post('datefrom');
				$this->data['selectedto']=$this->input->post('dateto');
				
			}
			else if ($this->input->post('btnPrint'))
			{
				$this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
				$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');
				//$this->form_validation->set_rules('period', 'Period', 'trim|required|xss_clean');
				
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
					redirect('rpt/summary/');
				}
				
				redirect('rptprint/summary/'.$this->input->post('branch').'/'.$this->input->post('date'));
			}
			
			$this->data['branches']=$this->tools_model->getuserbranches($this->session->userdata('lmsmemberid'));

			
			$this->data['mainmenu']='report';
			$this->data['submenu']='summary';
			$this->load->view('templates/header',$this->data);
			$this->load->view('report/summary');
			$this->load->view('templates/footer');
		}
		catch (Exception $e) 
		{
			$this->session->set_userdata('alertred', $e->getMessage());
			redirect('rpt/summary/');
		}
	}

	public function newsummary()
	{
		try
		{
			$this->data['selectedperiod']=$this->data['selectedbranch']=$this->data['selecteddate']=$this->data['selectedmonth']=$this->data['selectedyear']=$this->data['selectedfrom']=$this->data['selectedto']=null;
			$this->data['timestart']= null;
			
			if ($this->input->post('btnView'))
			{
				$this->form_validation->set_rules('branch', 'Branch & Area', 'trim|required|xss_clean');
				//$this->form_validation->set_rules('period', 'Period', 'trim|required|xss_clean');
				
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
					redirect('rpt/newsummary/');
				}
				
				$this->data['timestart']= date('Y-m-d H:i:s');
				$this->data['selectedbranch']=$this->input->post('branch');
				$this->data['selectedperiod']='D';
				$this->data['selecteddate']=$this->input->post('date');
				$this->data['selectedmonth']=$this->input->post('month');
				$this->data['selectedyear']=$this->input->post('year');
				$this->data['selectedfrom']=$this->input->post('datefrom');
				$this->data['selectedto']=$this->input->post('dateto');
				
			}
			else if ($this->input->post('btnPrint'))
			{
				$this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
				$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');
				//$this->form_validation->set_rules('period', 'Period', 'trim|required|xss_clean');
				
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
					redirect('rpt/newsummary/');
				}
				
				redirect('rptprint/newsummary/'.$this->input->post('branch').'/'.$this->input->post('date'));
			}
			
			$this->data['branches']=$this->tools_model->getuserbranches($this->session->userdata('lmsmemberid'));

			
			$this->data['mainmenu']='report';
			$this->data['submenu']='newsummary';
			$this->load->view('templates/header',$this->data);
			$this->load->view('report/newSummary');
			$this->load->view('templates/footer');
		}
		catch (Exception $e) 
		{
			$this->session->set_userdata('alertred', $e->getMessage());
			redirect('rpt/newsummary/');
		}
	}
	
	
	public function summary2()
	{
		try
		{
			$this->data['selectedperiod']=$this->data['selectedbranch']=$this->data['selecteddate']=$this->data['selectedmonth']=$this->data['selectedyear']=$this->data['selectedfrom']=$this->data['selectedto']=null;
			if ($this->input->post('btnView'))
			{
				$this->form_validation->set_rules('branch', 'Branch & Area', 'trim|required|xss_clean');
				//$this->form_validation->set_rules('period', 'Period', 'trim|required|xss_clean');
				
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
					redirect('rpt/summary/');
				}
				
				$this->data['selectedbranch']=$this->input->post('branch');
				$this->data['selectedperiod']='D';
				$this->data['selecteddate']=$this->input->post('date');
				$this->data['selectedmonth']=$this->input->post('month');
				$this->data['selectedyear']=$this->input->post('year');
				$this->data['selectedfrom']=$this->input->post('datefrom');
				$this->data['selectedto']=$this->input->post('dateto');
				
			}
			
			$this->data['branches']=$this->tools_model->getuserbranches($this->session->userdata('lmsmemberid'));

			
			$this->data['mainmenu']='report';
			$this->data['submenu']='summary';
			$this->load->view('templates/header',$this->data);
			$this->load->view('report/summary');
			$this->load->view('templates/footer');
		}
		catch (Exception $e) 
		{
			$this->session->set_userdata('alertred', $e->getMessage());
			redirect('rpt/summary/');
		}
	}
	
	public function collectionlist()
	{
		try
		{
			$this->data['areas']=$this->data['list']=$this->data['selectedarea']=$this->data['selectedbranch']=$this->data['selectedstatus']=null;
			$this->data['selectedsort']=1;
			$this->data['timestart']= date('Y-m-d H:i:s');
			if ($this->input->post('btnView'))
			{
				$this->data['list']=$this->report_model->getcollectionlist($this->input->post('area'),$this->input->post('status'),$this->input->post('sortby'));
				$this->data['areas']=$this->tools_model->getcollectorsbranchesareasactivebyuser($this->input->post('branch'),$this->session->userdata('lmsmemberid'));
				
				$this->data['selectedbranch']=trim($this->input->post('branch'));
				$this->data['selectedarea']=trim($this->input->post('area'));
				$this->data['selectedstatus']=trim($this->input->post('status'));
				$this->data['selectedsort']=trim($this->input->post('sortby'));
			}
			else if ($this->input->post('btnPrint'))
			{
				$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');
				$this->form_validation->set_rules('area', 'Area', 'trim|required|xss_clean');
				$this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean');
				
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
					redirect('rpt/collectionlist/');
				}
				
				redirect('rptprint/collectionlist/'.$this->input->post('branch').'/'.$this->input->post('area').'/'.$this->input->post('status').'/'.$this->input->post('sortby'));
				
			}
			else
			{
				$this->data['areas']==$this->tools_model->getcollectorsbranchesareasactivebyuser($this->session->userdata('selectedbranch'),$this->session->userdata('lmsmemberid'));
			}
			
			
			
			$this->data['branches']=$this->tools_model->getuserbranches($this->session->userdata('lmsmemberid'));
			
			$this->data['mainmenu']='report';
			$this->data['submenu']='collectionlist';
			$this->load->view('templates/header',$this->data);
			$this->load->view('report/collectionlist');
			$this->load->view('templates/footer');
		}
		catch (Exception $e) 
		{
			$this->session->set_userdata('alertred', $e->getMessage());
			redirect('rpt/collectionlist/');
		}
	}
	

	public function collectionlistv2()
	{
		try
		{
			$this->data['areas']=$this->data['list']=$this->data['selectedarea']=$this->data['selectedbranch']=$this->data['selectedstatus']=null;
			$this->data['selectedsort']=1;
			$this->data['timestart']= date('Y-m-d H:i:s');
			if ($this->input->post('btnView'))
			{
				$this->data['list']=$this->report_model->getcollectionlist($this->input->post('area'),$this->input->post('status'),$this->input->post('sortby'));
				$this->data['areas']=$this->tools_model->getcollectorsbranchesareasactivebyuser($this->input->post('branch'),$this->session->userdata('lmsmemberid'));
				
				$this->data['selectedbranch']=trim($this->input->post('branch'));
				$this->data['selectedarea']=trim($this->input->post('area'));
				$this->data['selectedstatus']=trim($this->input->post('status'));
				$this->data['selectedsort']=trim($this->input->post('sortby'));
			}
			else if ($this->input->post('btnPrint'))
			{
				$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');
				$this->form_validation->set_rules('area', 'Area', 'trim|required|xss_clean');
				$this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean');
				
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
					redirect('rpt/collectionlistv2/');
				}
				
				redirect('rptprint/collectionlistv2/'.$this->input->post('branch').'/'.$this->input->post('area').'/'.$this->input->post('status').'/'.$this->input->post('sortby'));
				
			}
			else
			{
				$this->data['areas']==$this->tools_model->getcollectorsbranchesareasactivebyuser($this->session->userdata('selectedbranch'),$this->session->userdata('lmsmemberid'));
			}
			
			
			
			$this->data['branches']=$this->tools_model->getuserbranches($this->session->userdata('lmsmemberid'));
			
			$this->data['mainmenu']='report';
			$this->data['submenu']='collectionlistv2';
			$this->load->view('templates/header',$this->data);
			$this->load->view('report/collectionlistv2');
			$this->load->view('templates/footer');
		}
		catch (Exception $e) 
		{
			$this->session->set_userdata('alertred', $e->getMessage());
			redirect('rpt/collectionlist/');
		}
	}
	public function servicecharge()
	{
		try
		{
			$this->data['areas']=$this->data['list']=$this->data['selectedareas']=$this->data['selectedbranch']=null;
			
			if ($this->input->post('btnView'))
			{
				$this->data['list']=$this->report_model->getloancharge($this->input->post('branch'),$this->input->post('area'),$this->input->post('datefrom'),$this->input->post('dateto'));
				$this->data['areas']=$this->tools_model->getareasbybranch($this->session->userdata('selectedbranch'));
				
				$this->session->set_userdata('selectedarea',  trim($this->input->post('area')));
				$this->session->set_userdata('selectedfrom',  $this->input->post('datefrom'));
				$this->session->set_userdata('selectedto',  $this->input->post('dateto'));
			}
			else if (!empty($this->input->post('branch')))
			{

				$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');
		
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
					redirect('rpt/collectionlist/');
				}
				
				$this->data['areas']=$this->tools_model->getareasbybranch($this->input->post('branch'));
				$this->session->set_userdata('selectedbranch',  trim($this->input->post('branch')));
			}
			else
			{
				$this->data['areas']=$this->tools_model->getareasbybranch($this->session->userdata('selectedbranch'));
			}
			
			
			
			$this->data['branches']=$this->tools_model->getuserbranches($this->session->userdata('lmsmemberid'));
			
			$this->data['mainmenu']='report';
			$this->data['submenu']='servicecharge';
			$this->load->view('templates/header',$this->data);
			$this->load->view('report/servicecharge');
			$this->load->view('templates/footer');
		}
		catch (Exception $e) 
		{
			$this->session->set_userdata('alertred', $e->getMessage());
			redirect('rpt/servicecharge/');
		}
	}
	
	public function passbookcharge()
	{
		try
		{
			$this->data['areas']=$this->data['list']=$this->data['selectedareas']=$this->data['selectedbranch']=null;
			
			if ($this->input->post('btnView'))
			{
				$this->data['list']=$this->report_model->getloancharge($this->input->post('branch'),$this->input->post('area'),$this->input->post('datefrom'),$this->input->post('dateto'));
				$this->data['areas']=$this->tools_model->getareasbybranch($this->session->userdata('selectedbranch'));
				
				$this->session->set_userdata('selectedarea',  trim($this->input->post('area')));
				$this->session->set_userdata('selectedfrom',  $this->input->post('datefrom'));
				$this->session->set_userdata('selectedto',  $this->input->post('dateto'));
			}
			else if (!empty($this->input->post('branch')))
			{

				$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');
		
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
					redirect('rpt/collectionlist/');
				}
				
				$this->data['areas']=$this->tools_model->getareasbybranch($this->input->post('branch'));
				$this->session->set_userdata('selectedbranch',  trim($this->input->post('branch')));
			}
			else
			{
				$this->data['areas']=$this->tools_model->getareasbybranch($this->session->userdata('selectedbranch'));
			}
			
			
			
			$this->data['branches']=$this->tools_model->getuserbranches($this->session->userdata('lmsmemberid'));
			
			$this->data['mainmenu']='report';
			$this->data['submenu']='passbookcharge';
			$this->load->view('templates/header',$this->data);
			$this->load->view('report/passbookcharge');
			$this->load->view('templates/footer');
		}
		catch (Exception $e) 
		{
			$this->session->set_userdata('alertred', $e->getMessage());
			redirect('rpt/passbookcharge/');
		}
	}
	
	public function lendersattendance()
	{
		$this->data['start']= new DateTime("now");
		try
		{
			$this->data['areas']=$this->data['list']=$this->data['selectedareas']=$this->data['selectedbranch']=$this->data['badaccountwithpayments']=$this->data['listpaid']=$this->data['newloan']=null;
			$this->data['selectedsort']=1;
			
			if ($this->input->post('btnView'))
			{
				$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');
				$this->form_validation->set_rules('area', 'Area', 'trim|required|xss_clean');
				$this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
				$this->form_validation->set_rules('type', 'Type', 'trim|required|xss_clean');
				
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
					redirect('rpt/lendersattendance/');
				}
				
				if ($this->input->post('type')!='BadAccounts')
				{
					$this->data['list']=$this->report_model->getlenderscollection($this->input->post('branch'),$this->input->post('area'),$this->input->post('date'),$this->input->post('sortby'));
				}
				else
				{
					$this->data['list']=$this->report_model->getlenderscollection_allbadaccounts($this->input->post('branch'),$this->input->post('area'),$this->input->post('date'),$this->input->post('sortby'));  
				}
				
				$this->data['badaccountwithpayments']=$this->report_model->getlenderscollection_badaccounts($this->input->post('branch'),$this->input->post('area'),$this->input->post('date'),$this->input->post('sortby'));
				
				$this->data['newloan']=$this->report_model->getnewloanperdateandbrancharea2($this->input->post('branch'),$this->input->post('area'),$this->input->post('date'));
				$this->data['newbad']=$this->report_model->getnewbadaccounts($this->input->post('branch'),$this->input->post('area'),date("Y-m-d", strtotime($this->input->post('date') . "-1 days")));
				
				
				
				if ($this->input->post('type')=='Paid')
				{
					$this->data['listpaid']=$this->report_model->getlenderscollection_fullypaid($this->input->post('branch'),$this->input->post('area'),$this->input->post('date'));
				}
				
				
				$this->data['areas']=$this->tools_model->getareasbybranch($this->session->userdata('selectedbranch'));
				$this->session->set_userdata('selectedtype',  trim($this->input->post('type')));
				$this->session->set_userdata('selectedbranch',  trim($this->input->post('branch')));
				$this->session->set_userdata('selectedarea',  trim($this->input->post('area')));
				$this->session->set_userdata('selecteddate',  $this->input->post('date'));
				$this->data['selectedsort']=$this->input->post('sortby');
			}
			else if ($this->input->post('btnPrint'))
			{
				$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');
				$this->form_validation->set_rules('area', 'Area', 'trim|required|xss_clean');
				$this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
				$this->form_validation->set_rules('type', 'Type', 'trim|required|xss_clean');
				
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
					redirect('rpt/lendersattendance/');
				}
				
				redirect('rptprint/lendersattenadance/'.$this->input->post('branch').'/'.$this->input->post('area').'/'.$this->input->post('date').'/'.$this->input->post('type').'/'.$this->input->post('sortby'));
			}
			else if (!empty($this->input->post('branch')))
			{

				$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');
		
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
					redirect('rpt/collectionlist/');
				}
				
				$this->data['areas']=$this->tools_model->getareasbybranch($this->input->post('branch'));
				$this->session->set_userdata('selectedbranch',  trim($this->input->post('branch')));
			}
			else
			{
				$this->data['areas']=$this->tools_model->getareasbybranch($this->session->userdata('selectedbranch'));
			}
			
			
		
			
			$this->data['branches']=$this->tools_model->getuserbranches($this->session->userdata('lmsmemberid'));
			
			$this->data['mainmenu']='report';
			$this->data['submenu']='lendersattendance';
			$this->load->view('templates/header',$this->data);
			if ($this->input->post('type')=='Active')
			{
				$this->load->view('report/lendersattendance_active');
			}
			else if ($this->input->post('type')=='BadAccounts')
			{
				$this->load->view('report/lendersattendance_badaccounts');
			}
			else
			{
				$this->load->view('report/lendersattendance');
			}
			$this->load->view('templates/footer');
		}
		catch (Exception $e) 
		{
			$this->session->set_userdata('alertred', $e->getMessage());
			redirect('rpt/lendersattendance/');
		}
	}


	public function test(){
		
		$this->benchmark->mark('start');
		$this->report_model->optimization();
		$this->benchmark->mark('end');
		echo 'Elapsed time: ' . $this->benchmark->elapsed_time('start', 'end');
		die();
	}
		

	
	
	

}