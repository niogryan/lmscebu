<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use Dompdf\Dompdf;
class rptprint extends CI_Controller 
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
	
	public function expenses()
	{
		if($this->uri->segment(3)=='')
		{
			$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
			redirect('transaction/expenses');
		}

		$this->data['expenses']=$this->transaction_model->getbranchexpenses($this->uri->segment(3));
		$this->data['summary']=$this->transaction_model->getbranchexpensessummary($this->uri->segment(3));
		$this->data['branch']=$this->tools_model->getbranchesdetails($this->uri->segment(3));

		
		
		$output = $this->load->view('report/printexpenses',$this->data,TRUE);
		
		$dompdf = new Dompdf();
		
		$dompdf->loadHtml($output);

		$dompdf->setPaper('legal', 'landscape');

		$dompdf->render();
		
		$font = $dompdf->getFontMetrics()->get_font("helvetica", "regular");
		$dompdf->getCanvas()->page_text(120, 900, "THIS DOCUMENT IS SYSTEM GENERATED AND MAY CONTAINS CONFIDENTIAL INFORMATION.", $font, 8, array(0,0,0));
		$dompdf->getCanvas()->page_text(130, 910, "PLEASE ENFORCE DATA PRIVACY. KEEP, SAVE AND FILE THIS IN A SAFE LOCATION.", $font, 8, array(0,0,0));
		$dompdf->getCanvas()->page_text(270, 890, "{PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0,0,0));

		$dompdf->stream('Expenses Report.pdf',array('Attachment'=>0));
	}
	
	public function remittance()
	{
		if($this->uri->segment(3)=='')
		{
			$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
			redirect('transaction/remittance');
		}

		$this->data['remittance']=$this->transaction_model->getbranchremittances($this->uri->segment(3));
		$this->data['summary']=$this->transaction_model->getbranchremittancessummary($this->uri->segment(3));
		$this->data['branch']=$this->tools_model->getbranchesdetails($this->uri->segment(3));

		
		
		$output = $this->load->view('report/printremittance',$this->data,TRUE);
		
		$dompdf = new Dompdf();
		
		$dompdf->loadHtml($output);

		$dompdf->setPaper('legal', 'landscape');

		$dompdf->render();
		
		$font = $dompdf->getFontMetrics()->get_font("helvetica", "regular");
		$dompdf->getCanvas()->page_text(120, 900, "THIS DOCUMENT IS SYSTEM GENERATED AND MAY CONTAINS CONFIDENTIAL INFORMATION.", $font, 8, array(0,0,0));
		$dompdf->getCanvas()->page_text(130, 910, "PLEASE ENFORCE DATA PRIVACY. KEEP, SAVE AND FILE THIS IN A SAFE LOCATION.", $font, 8, array(0,0,0));
		$dompdf->getCanvas()->page_text(270, 890, "{PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0,0,0));

		$dompdf->stream('Remittance  Report.pdf',array('Attachment'=>0));
	}
	
	public function passbookcharge()
	{
		if($this->uri->segment(3)=='' || $this->uri->segment(4)=='' || $this->uri->segment(5)=='' || $this->uri->segment(6)=='')
		{
			$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
			redirect('rpt/passbookcharge');
		}

		$this->data['list']=$this->report_model->getloancharge($this->uri->segment(3),$this->uri->segment(4),$this->uri->segment(5),$this->uri->segment(6));

		
		
		$this->data['branch']=$this->tools_model->getbranchesdetails($this->uri->segment(3));
		$this->data['area']=($this->uri->segment(4)=='ALL' ? 'ALL Areas' : $this->tools_model->getareasdetails($this->uri->segment(4))[0]['areaname']);
		$this->data['datefrom']=date("F j, Y", strtotime($this->uri->segment(5)));
		$this->data['dateto']=date("F j, Y", strtotime($this->uri->segment(6)));
		//$this->load->view('report/printlendersattenadance',$this->data);
		
		
		
		
		
		$output = $this->load->view('report/printpassbookcharge',$this->data,TRUE);
		
		$dompdf = new Dompdf();
		
		$dompdf->loadHtml($output);

		$dompdf->setPaper('legal', 'landscape');

		$dompdf->render();
		
		$font = $dompdf->getFontMetrics()->get_font("helvetica", "regular");
		$dompdf->getCanvas()->page_text(120, 900, "THIS DOCUMENT IS SYSTEM GENERATED AND MAY CONTAINS CONFIDENTIAL INFORMATION.", $font, 8, array(0,0,0));
		$dompdf->getCanvas()->page_text(130, 910, "PLEASE ENFORCE DATA PRIVACY. KEEP, SAVE AND FILE THIS IN A SAFE LOCATION.", $font, 8, array(0,0,0));
		$dompdf->getCanvas()->page_text(270, 890, "{PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0,0,0));

		$dompdf->stream('Passbook Charge  Report.pdf',array('Attachment'=>0));
	}
	
	public function collectionlist()
	{
		$this->data['timestart']= date('Y-m-d H:i:s');
		if($this->uri->segment(3)=='' || $this->uri->segment(4)=='' || $this->uri->segment(5)=='')
		{
			$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
			redirect('rpt/collectionlist');
		}

		$this->data['list']=$this->report_model->getcollectionlist($this->uri->segment(4),$this->uri->segment(5),$this->uri->segment(6));

		
		$this->data['branch']=$this->tools_model->getbranchesdetails($this->uri->segment(3));
		$this->data['area']=($this->tools_model->branchesareasdetails($this->uri->segment(4))[0]['areaname']);
		$this->data['type']=ucfirst($this->uri->segment(5));
		
		$output = $this->load->view('report/collectionlist_print',$this->data,TRUE);
		
		$dompdf = new Dompdf();
		
		$dompdf->loadHtml($output);

		$dompdf->setPaper('legal', 'portrait');

		$dompdf->render();
		
		$font = $dompdf->getFontMetrics()->get_font("helvetica", "regular");
		$dompdf->getCanvas()->page_text(60, 970, "Collection List | Page  {PAGE_NUM} | Collector's Signature:___________________________________ | ".date("F j, Y H:i:s"), $font, 9, array(0,0,0));
		

		$dompdf->stream('Collection List Report.pdf',array('Attachment'=>0));
	}

	public function collectionlistv2()
	{
		$this->data['timestart']= date('Y-m-d H:i:s');
		if($this->uri->segment(3)=='' || $this->uri->segment(4)=='' || $this->uri->segment(5)=='')
		{
			$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
			redirect('rpt/collectionlistv2');
		}

		$this->data['list']=$this->report_model->getcollectionlist($this->uri->segment(4),$this->uri->segment(5),$this->uri->segment(6));

		
		$this->data['branch']=$this->tools_model->getbranchesdetails($this->uri->segment(3));
		$this->data['area']=($this->tools_model->branchesareasdetails($this->uri->segment(4))[0]['areaname']);
		$this->data['type']=ucfirst($this->uri->segment(5));
		
		$output = $this->load->view('report/collectionlistv2_print',$this->data,TRUE);
		
		$dompdf = new Dompdf();
		
		$dompdf->loadHtml($output);

		$dompdf->setPaper('legal', 'portrait');

		$dompdf->render();
		
		$font = $dompdf->getFontMetrics()->get_font("helvetica", "regular");
		$dompdf->getCanvas()->page_text(60, 970, "Collection List | Page  {PAGE_NUM} | Collector's Signature:___________________________________ | ".date("F j, Y H:i:s"), $font, 9, array(0,0,0));
		

		$dompdf->stream('Collection List Report.pdf',array('Attachment'=>0));
	}
	
	public function servicecharge()
	{
		if($this->uri->segment(3)=='' || $this->uri->segment(4)=='' || $this->uri->segment(5)=='' || $this->uri->segment(6)=='')
		{
			$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
			redirect('rpt/servicecharge');
		}

		$this->data['list']=$this->report_model->getloancharge($this->uri->segment(3),$this->uri->segment(4),$this->uri->segment(5),$this->uri->segment(6));

		
		
		$this->data['branch']=$this->tools_model->getbranchesdetails($this->uri->segment(3));
		$this->data['area']=($this->uri->segment(4)=='ALL' ? 'ALL Areas' : $this->tools_model->getareasdetails($this->uri->segment(4))[0]['areaname']);
		$this->data['datefrom']=date("F j, Y", strtotime($this->uri->segment(5)));
		$this->data['dateto']=date("F j, Y", strtotime($this->uri->segment(6)));

		$output = $this->load->view('report/printservicecharge',$this->data,TRUE);
		
		$dompdf = new Dompdf();
		
		$dompdf->loadHtml($output);

		$dompdf->setPaper('legal', 'landscape');

		$dompdf->render();
		
		$font = $dompdf->getFontMetrics()->get_font("helvetica", "regular");
		$dompdf->getCanvas()->page_text(120, 900, "THIS DOCUMENT IS SYSTEM GENERATED AND MAY CONTAINS CONFIDENTIAL INFORMATION.", $font, 8, array(0,0,0));
		$dompdf->getCanvas()->page_text(130, 910, "PLEASE ENFORCE DATA PRIVACY. KEEP, SAVE AND FILE THIS IN A SAFE LOCATION.", $font, 8, array(0,0,0));
		$dompdf->getCanvas()->page_text(270, 890, "{PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0,0,0));

		$dompdf->stream('Service Charge Report.pdf',array('Attachment'=>0));
	}
	
	public function summary()
	{
		if($this->uri->segment(3)=='' || $this->uri->segment(4)=='')
		{
			$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
			redirect('rpt/summary');
		}

		$this->data['selectedbranch']=$this->uri->segment(3);
		$this->data['selecteddate']=$this->uri->segment(4);
		
		
		$this->data['branch']=$this->tools_model->getbranchesdetails($this->uri->segment(3));
		$this->data['selecteddateformat']=date("F j, Y", strtotime($this->uri->segment(4)));

		//$this->load->view('report/summary_print',$this->data);
		$output = $this->load->view('report/summary_print',$this->data,TRUE);
		
		$dompdf = new Dompdf();
		
		$dompdf->loadHtml($output);

		$dompdf->setPaper('letter', 'landscape');

		$dompdf->render();
		
		$font = $dompdf->getFontMetrics()->get_font("helvetica", "regular");
		$dompdf->getCanvas()->page_text(350, 570, "Page  {PAGE_NUM} | ".date("F j, Y H:i:s"), $font, 10, array(0,0,0));

		$dompdf->stream('Daily Collection Summary Report.pdf',array('Attachment'=>0));
	}

	public function newsummary()
	{
		if($this->uri->segment(3)=='' || $this->uri->segment(4)=='')
		{
			$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
			redirect('rpt/newsummary');
		}

		$this->data['selectedbranch']=$this->uri->segment(3);
		$this->data['selecteddate']=$this->uri->segment(4);
		
		
		$this->data['branch']=$this->tools_model->getbranchesdetails($this->uri->segment(3));
		$this->data['selecteddateformat']=date("F j, Y", strtotime($this->uri->segment(4)));

		//$this->load->view('report/summary_print',$this->data);
		$output = $this->load->view('report/newSummary_print',$this->data,TRUE);
		
		$dompdf = new Dompdf();
		
		$dompdf->loadHtml($output);

		$dompdf->setPaper('letter', 'landscape');

		$dompdf->render();
		
		$font = $dompdf->getFontMetrics()->get_font("helvetica", "regular");
		$dompdf->getCanvas()->page_text(350, 570, "Page  {PAGE_NUM} | ".date("F j, Y H:i:s"), $font, 10, array(0,0,0));

		$dompdf->stream('Daily Collection Summary Report.pdf',array('Attachment'=>0));
	}
	
	
	
	public function lendersattenadance()
	{
		if($this->uri->segment(3)=='' || $this->uri->segment(4)=='' || $this->uri->segment(5)=='' || $this->uri->segment(6)=='')
		{
			$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
			redirect('rpt/lendersattendance');
		}
		
		$this->data['param1']=$this->uri->segment(3);
		$this->data['param2']=$this->uri->segment(4);
		$this->data['param3']=$this->uri->segment(5);
		$this->data['param4']=$this->uri->segment(6);
		$this->data['param5']=$this->uri->segment(7);
		
		$this->data['listbadaccount']=$this->data['listpaid']=null;
		
		
		if ($this->data['param4']=='BadAccounts')
		{
			$this->data['list']=$this->report_model->getlenderscollection_allbadaccounts($this->uri->segment(3),$this->uri->segment(4),$this->uri->segment(5),$this->data['param5']);
		}
		else
		{
			$this->data['list']=$this->report_model->getlenderscollection($this->uri->segment(3),$this->uri->segment(4),$this->uri->segment(5),$this->data['param5']);
			$this->data['newloan']=$this->report_model->getnewloanperdateandbrancharea2($this->uri->segment(3),$this->uri->segment(4),$this->uri->segment(5));
			
			
			$this->data['newbad']=$this->report_model->getnewbadaccounts($this->uri->segment(3),$this->uri->segment(4),date("Y-m-d", strtotime($this->uri->segment(5) . "-1 days")));
			$this->data['badaccountwithpayments']=$this->report_model->getlenderscollection_badaccounts($this->uri->segment(3),$this->uri->segment(4),$this->uri->segment(5),1);
			
			
			if ($this->data['param4']=='Paid')
			{
				$this->data['listpaid']=$this->report_model->getlenderscollection_fullypaid($this->uri->segment(3),$this->uri->segment(4),$this->uri->segment(5));
			}
		}
		
		
		
		
		$this->data['branch']=$this->tools_model->getbranchesdetails($this->uri->segment(3));
		$this->data['area']=($this->uri->segment(4)=='ALL' ? 'ALL Areas' : $this->tools_model->getareasdetails($this->uri->segment(4))[0]['areaname']);
		$this->data['date']=date("F j, Y", strtotime($this->uri->segment(5)));
		$this->data['selecteddate']=$this->uri->segment(5);
		$this->data['type']=$this->uri->segment(6);
		
		//$this->load->view('report/lendersattenadance_active_print',$this->data);
		
		if ($this->data['param4']=='Active')
		{
			$output = $this->load->view('report/lendersattenadance_active_print',$this->data,TRUE);
		}
		else if ($this->data['param4']=='BadAccounts')
		{
			$output = $this->load->view('report/lendersattenadance_badaccounts_print',$this->data,TRUE);
		}
		else
		{
			$output = $this->load->view('report/lendersattenadance_print',$this->data,TRUE);
		}
		
		$dompdf = new Dompdf();
		
		$dompdf->loadHtml($output);

		$dompdf->setPaper('legal', 'landscape');

		$dompdf->render();
		
		$font = $dompdf->getFontMetrics()->get_font("helvetica", "regular");
		$dompdf->getCanvas()->page_text(490, 580, "Page {PAGE_NUM}", $font, 12, array(0,0,0));
		$dompdf->getCanvas()->page_text(830, 50, "Date Generated: ".date("F d, Y"), $font, 12, array(0,0,0));
		$dompdf->stream('Lenders Attendance Report.pdf',array('Attachment'=>0));
	}
	
	public function customerprofile()
	{
		if($this->uri->segment(3)=='' || $this->uri->segment(4)=='')
		{
			$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
			redirect('customer/index');
		}

		$this->data['profile']=$this->customer_model->searchcustomerprofile($this->uri->segment(3),$this->uri->segment(4));

		//print_r($this->data['profile']);
		//die();
		//$this->data['barcodegenerator'] = new Picqer\Barcode\BarcodeGeneratorHTML();

		//$this->load->view('customer/printprofile',$this->data);
		
		$output = $this->load->view('customer/printprofile',$this->data,TRUE);
		
		$dompdf = new Dompdf();
		
		$dompdf->loadHtml($output);

		$dompdf->setPaper('legal', 'landscape');

		$dompdf->render();
		
		$font = $dompdf->getFontMetrics()->get_font("helvetica", "regular");
		$dompdf->getCanvas()->page_text(120, 900, "THIS DOCUMENT IS SYSTEM GENERATED AND MAY CONTAINS CONFIDENTIAL INFORMATION.", $font, 8, array(0,0,0));
		$dompdf->getCanvas()->page_text(130, 910, "PLEASE ENFORCE DATA PRIVACY. KEEP, SAVE AND FILE THIS IN A SAFE LOCATION.", $font, 8, array(0,0,0));
		$dompdf->getCanvas()->page_text(270, 890, "{PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0,0,0));

		$dompdf->stream('Customer List.pdf',array('Attachment'=>0));
	}
	
	public function customerprofile1()
	{
		if($this->uri->segment(3)=='' || $this->uri->segment(4)=='')
		{
			$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
			redirect('customer/index');
		}

		$this->data['profile']=$this->customer_model->searchcustomerprofile($this->uri->segment(3),$this->uri->segment(4));

		//print_r($this->data['profile']);
		//die();
		//$this->data['barcodegenerator'] = new Picqer\Barcode\BarcodeGeneratorHTML();

		$this->load->view('customer/printprofile',$this->data);
		
		// $output = $this->load->view('customer/printprofile',$this->data,TRUE);
		
		// $dompdf = new Dompdf();
		
		// $dompdf->loadHtml($output);

		// $dompdf->setPaper('legal', 'landscape');

		// $dompdf->render();
		
		// $font = $dompdf->getFontMetrics()->get_font("helvetica", "regular");
		// $dompdf->getCanvas()->page_text(120, 900, "THIS DOCUMENT IS SYSTEM GENERATED AND MAY CONTAINS CONFIDENTIAL INFORMATION.", $font, 8, array(0,0,0));
		// $dompdf->getCanvas()->page_text(130, 910, "PLEASE ENFORCE DATA PRIVACY. KEEP, SAVE AND FILE THIS IN A SAFE LOCATION.", $font, 8, array(0,0,0));
		// $dompdf->getCanvas()->page_text(270, 890, "{PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0,0,0));

		// $dompdf->stream('Customer List.pdf',array('Attachment'=>0));
	}
	
}