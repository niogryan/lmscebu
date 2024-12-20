<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends CI_Controller 
{

	public function index()
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
	
	public function transactional()
	{
		try
		{ 
		
			$this->data['output']=null;
			
			$this->load->dbutil();
			$prefs = array(
					'tables'        => array('tbl_areas','tbl_borrowers','tbl_borrowers_documents','tbl_branches','tbl_cashonhand'
											,'tbl_expenses','tbl_laterepaymentseen','tbl_loanpayments','tbl_loans','tbl_menus'
											,'tbl_repaymentmethod','tbl_repaymentsched','tbl_roles','tbl_useraccount_roles','tbl_useraccounts'
											,'tbl_useraccounts_branches','tbl_useraccounts_menus')
			);
						
			
			
			$backup = $this->dbutil->backup($prefs);

			$filename='Transactional-backup_' . date('Y-m-d_H-i') . '.zip';
			
			$this->load->helper('file');
			write_file('./bkp/Transactional/'.$filename, $backup);

			$this->data['output'] .= '/bkp/'.$filename.'<br />';
			$this->data['output'] .= 'Backup done.';
			
			echo $this->data['output'];
			die();
			
		
		}
		catch (Exception $e) 
		{
			echo $e->getMessage();
			die();
		}
	}
}
