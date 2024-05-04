<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class customer extends CI_Controller 
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
		$this->data['profile']=$this->data['areas']=$this->data['selectedbranch']=$this->data['selectedarea']=null;
		if ($this->input->post('btnView'))
		{
			$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');
			$this->form_validation->set_rules('area', 'Area', 'trim|required|xss_clean');
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('customer/index/');
			}
			
			
			$this->data['profile']=$this->customer_model->searchcustomerprofile($this->input->post('area'));
			$this->data['areas']=$this->tools_model->getcollectorsbranchesareasactivebyuser($this->input->post('branch'),$this->session->userdata('lmsmemberid'));

			$this->data['selectedbranch']= trim($this->input->post('branch'));
			$this->data['selectedarea']= trim($this->input->post('area'));

		}
		else if ($this->uri->segment(3)=='d')
		{
			$this->session->unset_userdata('selectedbranch');
			if($this->mylibraries->encrypt('d'.$this->uri->segment(4))!=$this->uri->segment(5))
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
				redirect('customer/index/');
			}
			
			$result=$this->customer_model->deleteprofile
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
				redirect('customer/index/');			
		}
		// else if (!empty($this->input->post('branch')))
		// {

			// $this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');
	
			// if ($this->form_validation->run() == FALSE)
			// {
				// $this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				// redirect('customer/add/');
			// }
			
			// $this->data['areas']=$this->tools_model->getareasbybranch($this->input->post('branch'));
			// $this->session->set_userdata('selectedbranch',  trim($this->input->post('branch')));
		// }
		// else
		// {
			// $this->data['areas']=$this->tools_model->getareasbybranch($this->session->userdata('selectedbranch'));
		// }
		
			
			
		$this->data['branches']=$this->tools_model->getuserbranches($this->session->userdata('lmsmemberid'));
		
		$this->data['branchesareas']=$this->tools_model->getuserbranches($this->session->userdata('lmsmemberid'));
		
		$this->data['mainmenu']='customer';
		$this->data['submenu']='index';
		$this->load->view('templates/header',$this->data);
		$this->load->view('customer/index');
		$this->load->view('templates/footer');
	}
	
	
	public function profile()
	{

		$this->data['param1']=$this->uri->segment(3);
		$this->data['param2']=$this->uri->segment(4);
		//$this->session->unset_userdata('selectedbranch');
		
		if ($this->input->post('btnUpload'))
		{
			
			if($_FILES['uploaddocs']['error']==0) 
			{
				$filevalidationresult=$this->mylibraries->attachmenvalidation($_FILES['uploaddocs']);
				
				if (!empty($filevalidationresult))
				{
					$errmsg=null;
					foreach($filevalidationresult as $error) 
					{
						$errmsg .= $error;
					}
					
					$this->session->set_userdata('alertred',  $errmsg);
					redirect('customer/profile/'.$this->data['param1'].'/'.$this->data['param2']);
				}
				
				$name    = basename($_FILES['uploaddocs']['name']);
				$filetype   = $_FILES['uploaddocs']['type'];
				
				$result=$this->customer_model->savedocuattachment($this->data['param1'],$name,$filetype ,$this->session->userdata('lmsmemberid'));
						
				if($result['error_number']==0)
				{
					
					$filecontent = base64_encode(file_get_contents($_FILES['uploaddocs']['tmp_name']));
					
					$chunk = chunk_split($filecontent, 4096, "-=blender=-");
					$truffle = explode("-=blender=-",$chunk);
					
					$temp = null;
					$ctr=1;
					foreach($truffle as $row)
					{
						$resultchunck=$this->customer_model->savedocumentchunk($result['returnid'],$ctr,$row);
						$ctr++;
					}
					
					$this->session->set_userdata('alertgreen','success');
					redirect('customer/profile/'.$this->data['param1'].'/'.$this->data['param2']);
				}
			}
			
			$this->session->set_userdata('alertred',  $this->mylibraries->show_message('denied'));
			redirect('customer/profile/'.$this->data['param1'].'/'.$this->data['param2']);
		}
		else if ($this->input->post('btnDelete'))
		{
			$this->data['param1']=$this->uri->segment(3);
			$this->data['param2']=$this->uri->segment(4);
			
			
			$result=$this->customer_model->deleteprofile
									(	$this->data['param1']
										,$this->session->userdata('lmsmemberid')
									);				
			
			if($result['error_number']==0)
			{
				$this->session->set_userdata('alertgreen', 'success');
				redirect('customer/index/');
			}
			else
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message($result['error_message']));
				redirect('customer/profile/'.$this->data['param1'].'/'.$this->data['param2']);
			}		
		}
		else if ($this->data['param1']=='d')
		{
			if($this->mylibraries->encrypt('d'.$this->uri->segment(4).$this->uri->segment(5))!=$this->uri->segment(6))
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
				redirect('customer/profile/'.$this->uri->segment(5).'/'.$this->mylibraries->encrypt('v'.$this->uri->segment(5)));
			}
			
			$result=$this->customer_model->deletedocument
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
			redirect('customer/profile/'.$this->uri->segment(5).'/'.$this->mylibraries->encrypt('v'.$this->uri->segment(5)));
		}
		
		
		$this->data['profile']=$this->customer_model->getcustomerprofiledetails($this->data['param1']);
		$this->data['image']=$tempfile=null;
		$this->data['documents']=$this->customer_model->getcustomerdocuments($this->data['param1']);
		$this->data['loans']=$this->customer_model->getcustomerloan($this->data['param1']);
		$imageresult=$this->customer_model->getcustomerprofileimage($this->data['param1']);	
			
		if($imageresult)	
		{
			foreach($imageresult as $row)
			{
				$tempfile .= $row['content'];
			}
			$this->data['image']=$tempfile ;
		}
		
		//$this->mylibraries->echodie();
		
		$this->data['mainmenu']='customer';
		$this->data['submenu']='index';
		$this->load->view('templates/header',$this->data);
		$this->load->view('customer/profile');
		$this->load->view('templates/footer');
	}
	

	
	public function edit()
	{
		$this->data['param1']=$this->uri->segment(3);
		$this->data['param2']=$this->uri->segment(4);
		
		if ($this->input->post('btnSave'))
		{
			$this->form_validation->set_rules('branch', 'Branch Areas', 'trim|required|xss_clean');
			$this->form_validation->set_rules('firstname', 'First name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('lastname', 'Last name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('birthday', 'Birthday', 'trim|required|callback_checkDateFormat', array('checkDateFormat'  => 'Invalid Date Format'));
			$this->form_validation->set_rules('gender', 'Gender', 'trim|required|xss_clean');
			$this->form_validation->set_rules('maritalstatus', 'Marital Status ', 'trim|required|xss_clean');
			$this->form_validation->set_rules('cellphonenumber', 'Cellphone Number', 'trim|required|xss_clean');
			$this->form_validation->set_rules('telephonenumber', 'Telephone Number', 'trim|required|xss_clean');
			$this->form_validation->set_rules('address', 'Complete Address', 'trim|required|xss_clean');
			
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
				redirect('customer/edit/'.$this->data['param1'].'/'.$this->data['param2']);
			}
			else
			{
				$result=$this->customer_model->saveprofile
										(	$this->data['param1']
											,$this->input->post('branch')
											,$this->input->post('firstname')
											,$this->input->post('middlename')
											,$this->input->post('suffix')
											,$this->input->post('lastname')
											,$this->input->post('birthday')
											,$this->input->post('birthplace')
											,$this->input->post('gender')
											,$this->input->post('address')
											,$this->input->post('cellphonenumber')
											,$this->input->post('telephonenumber')
											,$this->input->post('emailaddress')
											,$this->input->post('maritalstatus')
											,$this->input->post('employmentstatus')
											,$this->input->post('tinnumber')
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
		
				
				redirect('customer/edit/'.$this->data['param1'].'/'.$this->data['param2']);
			}
		}
		else if ($this->input->post('btnUpload'))
		{
			
			if($_FILES['uploadimage']['error']==0) 
			{
				$imagevalidationresult=$this->mylibraries->imagevalidation($_FILES['uploadimage']);
				
				if (!empty($imagevalidationresult))
				{
					$errmsg=null;
					foreach($imagevalidationresult as $error) 
					{
						$errmsg .= $error;
					}
					
					$this->session->set_userdata('alertred',  $errmsg);
					redirect('customer/edit/'.$this->data['param1'].'/'.$this->data['param2']);
				}
				
				$filetype   = $_FILES['uploadimage']['type'];
				$filecontent = base64_encode(file_get_contents($_FILES['uploadimage']['tmp_name']));
				
				$chunk = chunk_split($filecontent, 4096, "-=blender=-");
				$truffle = explode("-=blender=-",$chunk);
				
				$temp = null;
				$ctr=1;
				foreach($truffle as $row)
				{
					$resultchunck=$this->customer_model->saveimagechunk($this->data['param1'],$filetype,$ctr,$row);
					$ctr++;
				}
				
				$this->session->set_userdata('alertgreen','success');
				redirect('customer/edit/'.$this->data['param1'].'/'.$this->data['param2']);
			}
			else
			{
				$this->session->set_userdata('alertred',  $this->mylibraries->show_message('denied'));
				redirect('customer/edit/'.$this->data['param1'].'/'.$this->data['param2']);
			}
			
			
			
		}
		else
		{
			if($this->mylibraries->encrypt('e'.$this->uri->segment(3))!=$this->uri->segment(4))
			{
				$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
				redirect('customer/index/');
			}
		}
		
		$this->data['branchesareas']=$this->tools_model->getbranchesareacityactivebyuser($this->session->userdata('lmsmemberid'));
		$this->data['profile']=$this->customer_model->getcustomerprofiledetails($this->data['param1']);
		$this->data['image']=$tempfile=null;
	
		$imageresult=$this->customer_model->getcustomerprofileimage($this->data['param1']);	
			
		if($imageresult)	
		{
			foreach($imageresult as $row)
			{
				$tempfile .= $row['content'];
			}
			$this->data['image']=$tempfile ;
		}
		
		$this->data['mainmenu']='customer';
		$this->data['submenu']='index';
		$this->load->view('templates/header',$this->data);
		$this->load->view('customer/edit');
		$this->load->view('templates/footer');
	}
	
	public function add()
	{
		try
		{	
			$this->data['areas']=null;
			
			if ($this->input->post('btnSave'))
			{
				$this->form_validation->set_rules('area', 'Area', 'trim|required|xss_clean');
				$this->form_validation->set_rules('firstname', 'First name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('lastname', 'Last name', 'trim|required|xss_clean');
				$this->form_validation->set_rules('birthday', 'Birthday', 'trim|required|callback_checkDateFormat', array('checkDateFormat'  => 'Invalid Date Format'));
				$this->form_validation->set_rules('gender', 'Gender', 'trim|required|xss_clean');
				$this->form_validation->set_rules('maritalstatus', 'Marital Status ', 'trim|required|xss_clean');
				$this->form_validation->set_rules('cellphonenumber', 'Cellphone Number', 'trim|required|xss_clean');
				$this->form_validation->set_rules('telephonenumber', 'Telephone Number', 'trim|required|xss_clean');
				$this->form_validation->set_rules('address', 'Complete Address', 'trim|required|xss_clean');
				
				
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
					redirect('customer/add/');
				}
				else
				{
					$result=$this->customer_model->saveprofile
											(	$this->data['param1']
												,$this->input->post('area')
												,$this->input->post('firstname')
												,$this->input->post('middlename')
												,$this->input->post('suffix')
												,$this->input->post('lastname')
												,$this->input->post('birthday')
												,$this->input->post('birthplace')
												,$this->input->post('gender')
												,$this->input->post('address')
												,$this->input->post('cellphonenumber')
												,$this->input->post('telephonenumber')
												,$this->input->post('emailaddress')
												,$this->input->post('maritalstatus')
												,$this->input->post('employmentstatus')
												,$this->input->post('tinnumber')
												,$this->input->post('remarks')
												,$this->session->userdata('lmsmemberid')
											);				
					
					if($result['error_number']==0)
					{
						if($_FILES['uploadimage']['error']==0) 
						{
							$imagevalidationresult=$this->mylibraries->imagevalidation($_FILES['uploadimage']);
							
							if (!empty($imagevalidationresult))
							{
								$errmsg=null;
								foreach($imagevalidationresult as $error) 
								{
									$errmsg .= $error;
								}
								
								$this->session->set_userdata('alertred',  $errmsg);
								redirect('customer/profile/'.$result['returnid'].'/'.$this->mylibraries->encrypt($result['returnid']));
							}
							
							$filetype   = $_FILES['uploadimage']['type'];
							$filecontent = base64_encode(file_get_contents($_FILES['uploadimage']['tmp_name']));
							
							$chunk = chunk_split($filecontent, 4096, "-=blender=-");
							$truffle = explode("-=blender=-",$chunk);
							
							$temp = null;
							$ctr=1;
							foreach($truffle as $row)
							{
								$resultchunck=$this->customer_model->saveimagechunk($result['returnid'],$filetype,$ctr,$row);
								$ctr++;
							}
						}
						
						
						$this->session->set_userdata('alertgreen', 'success');
						redirect('customer/profile/'.$result['returnid'].'/'.$this->mylibraries->encrypt($result['returnid']));
					}
					else
					{
						$this->session->set_userdata('alertred', $this->mylibraries->show_message($result['error_message']));
						redirect('customer/add/');
					}
					
				}
			}
			else if (!empty($this->input->post('branch')))
			{

				$this->form_validation->set_rules('branch', 'Branch', 'trim|required|xss_clean');
		
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_userdata('alertred',  $this->mylibraries->validation_errors_message($this->form_validation->error_array()));
					redirect('customer/add/');
				}
				
				$this->data['areas']=$this->tools_model->getareasbybranch($this->input->post('branch'));
				$this->session->set_userdata('selectedbranch',  trim($this->input->post('branch')));
			}
			else
			{
				$this->data['areas']=$this->tools_model->getareasbybranch($this->session->userdata('selectedbranch'));
			}
			
			
			
			$this->data['branches']=$this->tools_model->getuserbranches($this->session->userdata('lmsmemberid'));
			//$this->data['branchesareas']=$this->tools_model->getuseraccessbranchesarea($this->session->userdata('lmsmemberid'));
			
			$this->data['mainmenu']='customer';
			$this->data['submenu']='add';
			$this->load->view('templates/header',$this->data);
			$this->load->view('customer/add');
			$this->load->view('templates/footer');
			
		
		}
		catch (Exception $e) 
		{
			$this->session->set_userdata('alertred',  $this->mylibraries->show_message($e->getMessage()));
			redirect('app/index');
		}
	}
	
	function document()
	{
		if($this->mylibraries->encrypt('cd'.$this->uri->segment(3).$this->uri->segment(4))!=$this->uri->segment(5))
		{
			$this->session->set_userdata('alertred', $this->mylibraries->show_message('denied'));
			redirect('customer/profile/'.$this->uri->segment(4).'/'.$this->mylibraries->encrypt('v'.$this->uri->segment(4)));
		}

		$tempfile=null;
		$chunk=$this->customer_model->getcustomerdocumentschuck($this->uri->segment(3));
		$details=$this->customer_model->getcustomerdocumentsdetails($this->uri->segment(3));	
			
		foreach($chunk as $row)
		{
			$tempfile .= $row['content'];
		}
			
		$binary=base64_decode($tempfile);
													
		header('Content-type: '.trim($details[0]['documenttype']).'');
		header('Content-Disposition: inline; filename="'.trim($details[0]['documentname']).'"');
		echo $binary;
	}
	

	
	
	function checkDateFormat($date) 
	{
		return $this->mylibraries->checkDateFormat($date);
	}
	
}
