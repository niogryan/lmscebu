<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class transaction_model extends CI_Model
{
	function __construct()
    {
        parent::__construct();
    }
	
	function getexpensestype()
	{
		$this->db->select('*');
		$this->db->from('tbl_expenses_type');
		$this->db->order_by("expensestype");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getbranchexpenses($id)
	{
		$this->db->where('a.branchid', $id);
		$this->db->select("a.*,b.*,c.*,CONCAT(d.firstname,' ',d.lastname) as addedby",false);
		$this->db->from('tbl_branches_expenses a');
		$this->db->join('tbl_expenses_type b','a.expensestypeid=b.expensestypeid');
		$this->db->join('tbl_branches c','a.branchid=c.branchid');
		$this->db->join('tbl_user_accounts d','a.entryuserid=d.userid');
		$this->db->order_by("expensedate desc, expensestype");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getbranchexpensessummary($id)
	{	

		$sql = "SELECT MONTHNAME(expensedate) 'Month',YEAR(expensedate) 'Year',IFNULL(sum(amount),0) 'Amount'
				FROM tbl_branches_expenses  a
				GROUP BY MONTHNAME(expensedate),YEAR(expensedate)
				ORDER BY YEAR(expensedate) DESC, MONTH(expensedate)
				";			
		$result=$this->db->query($sql);	
		return $result->result_array();	
	}
	
	function getbranchremittancessummary($id)
	{	

		$sql = "SELECT MONTHNAME(remittancedate) 'Month',YEAR(remittancedate) 'Year',IFNULL(sum(amount),0) 'Amount'
				FROM tbl_branches_remittances  a
				GROUP BY MONTHNAME(remittancedate),YEAR(remittancedate)
				ORDER BY YEAR(remittancedate) DESC, MONTH(remittancedate)
				";			
		$result=$this->db->query($sql);	
		return $result->result_array();	
	}
	
	function getbranchexpensesdetails($id)
	{
		$this->db->where('a.expensesid', $id);
		$this->db->select('a.*');
		$this->db->from('tbl_branches_expenses a');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getbranchremittances($id)
	{
		$this->db->where('a.branchid', $id);
		$this->db->select("a.*,b.*,CONCAT(d.firstname,' ',d.lastname) as addedby",false);
		$this->db->from('tbl_branches_remittances a');
		$this->db->join('tbl_branches b','a.branchid=b.branchid');
		$this->db->join('tbl_user_accounts d','a.entryuserid=d.userid');
		$this->db->order_by("remittancedate desc");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getbranchremittancesdetails($id)
	{
		$this->db->where('remittanceid', $id);
		$this->db->select('*');
		$this->db->from('tbl_branches_remittances a');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getcashonhand($branch)
	{
		$sql = "SELECT  DISTINCT date,branchid, IFNULL(SUM(amount),0) 'amount'
				FROM (`tbl_branches_cashonhand`) 
				WHERE branchid={$branch}
				GROUP BY date
				ORDER BY date DESC";
		$result=$this->db->query($sql);	
		return $result->result_array();	
	}
	
	
	function getexpensesbybranchdate($branch,$date)
	{
		$this->db->where('expensedate',$date);
		$this->db->where('branchid',$branch);
		$this->db->select("IFNULL(SUM(amount),0) 'expenses'");
		$this->db->from('tbl_branches_expenses');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getremittancebybranchdate($branch,$date)
	{
		$this->db->where('remittancedate',$date);
		$this->db->where('branchid',$branch);
		$this->db->select("IFNULL(SUM(amount),0) 'amount'");
		$this->db->from('tbl_branches_remittances');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getloansservicechargebybranchdate($branch,$date)
	{
		$this->db->where('b.branchid', $branch);
		$this->db->where('releaseddate', $date);
		$this->db->select("IFNULL(SUM(servicecharge),0) 'amount'");
		$this->db->from('tbl_loans a');
		$this->db->join('tbl_branches_areas b','a.branchareaid=b.branchareaid');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getloanspassbookchargebybranchdate($branch,$date)
	{
		$this->db->where('b.branchid', $branch);
		$this->db->where('releaseddate', $date);
		$this->db->select("IFNULL(SUM(passbookcharge),0) 'amount'");
		$this->db->from('tbl_loans a');
		$this->db->join('tbl_branches_areas b','a.branchareaid=b.branchareaid');
		$result = $this->db->get();
		return $result->result_array();
	}
	
	function getcashonhanddetails($date)
	{
		$this->db->where('date',$date);
		$this->db->select("a.*,CONCAT(b.firstname,' ',b.lastname) entryby",false);
		$this->db->from('tbl_branches_cashonhand a');
		$this->db->join('tbl_user_accounts b','a.entryuserid=b.userid');
		$this->db->order_by("date");
		$result = $this->db->get();
		return $result->result_array();
	}
	
	
	
	// function gettranscationamountbydate($date)
	// {
		// $this->db->where('paymentdate',$date);
		// $this->db->select("paymentamount,amountreceived,repaymentmethodid");
		// $this->db->from('tbl_loanpayments');
		// $result = $this->db->get();
		// return $result->result_array();
	// }
	
	
	//-------------------------------------------------------------------------------INSERT&UPDATE-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------INSERT&UPDATE-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------INSERT&UPDATE-------------------------------------------------------------------------------
	
	
	function saveexpenses($id,$branch,$type,$date,$voucher,$payee,$description,$amount,$remarks,$userid)
	{
		$this->db->trans_start();
		$result=null;

		if ($id==0)
		{
			$data = array(
				'branchid' 			=>  $branch,
				'expensestypeid' 	=>  $type,
				'expensedate' 		=> 	$date,
				'voucher' 			=> $voucher,
				'payee' 			=> $payee,
				'description' 		=> $description,
				'amount' 			=> $amount,
				'remarks' 			=> $remarks,
				'entryuserid' 		=>	$userid,
				'entrydate' 		=>  date("Y-m-d H:i:s")
			);

			$this->db->insert('tbl_branches_expenses',$data);
			$error = $this->db->error(); 
			if ($error['code']==0)
			{
				$result=array(
					'error_number' 	=> 0,
					'error_message' => 'success'
				);
				$this->inserttracer('Expenses',$returnid,$this->db->last_query(),'Add',$userid);
			}
			else
			{
				$result=array(
				'error_number' 	=> $error['code'],
				'error_message' => $error['message']
				);
			}
		}
		else
		{
			$data = array(
				'branchid' 			=>  $branch,
				'expensestypeid' 	=>  $type,
				'expensedate' 		=> 	$date,
				'voucher' 			=> $voucher,
				'payee' 			=> $payee,
				'description' 		=> $description,
				'amount' 			=> $amount,
				'remarks' 			=> $remarks,
				'entryuserid' 		=>	$userid,
				'entrydate' 		=>  date("Y-m-d H:i:s")
			);
			
			$this->db->where('expensesid',$id);
			$this->db->update('tbl_branches_expenses',$data);
			$error = $this->db->error(); 
			if ($error['code']==0)
			{
				$result=array(
					'error_number' 	=> 0,
					'error_message' => 'success'
				);
				$this->inserttracer('Expenses',$returnid,$this->db->last_query(),'Update',$userid);
			}
			else
			{
				$result=array(
				'error_number' 	=> $error['code'],
				'error_message' => $error['message']
				);
			}
		}
		
		$this->db->trans_complete();
		return $result;	
	}
	
	function saveremittance($id,$branch,$date,$amount,$remarks,$userid)
	{
		$this->db->trans_start();
		$result=null;

		if ($id==0)
		{
			$data = array(
				'branchid' 			=>  $branch,
				'remittancedate' 	=> 	$date,
				'amount' 			=> $amount,
				'remarks' 			=> $remarks,
				'entryuserid' 		=>	$userid,
				'entrydate' 		=>  date("Y-m-d H:i:s")
			);

			$this->db->insert('tbl_branches_remittances',$data);
			$error = $this->db->error(); 
			if ($error['code']==0)
			{
				$result=array(
					'error_number' 	=> 0,
					'error_message' => 'success'
				);
				$this->inserttracer('Remittance',$returnid,$this->db->last_query(),'Add',$userid);
			}
			else
			{
				$result=array(
				'error_number' 	=> $error['code'],
				'error_message' => $error['message']
				);
			}
		}
		else
		{
			$data = array(
				'branchid' 			=>  $branch,
				'remittancedate' 	=> 	$date,
				'amount' 			=> $amount,
				'remarks' 			=> $remarks,
				'entryuserid' 		=>	$userid,
				'entrydate' 		=>  date("Y-m-d H:i:s")
			);
			
			$this->db->where('remittanceid',$id);
			$this->db->update('tbl_branches_remittances',$data);
			$error = $this->db->error(); 
			if ($error['code']==0)
			{
				$result=array(
					'error_number' 	=> 0,
					'error_message' => 'success'
				);
				$this->inserttracer('Remittance',$returnid,$this->db->last_query(),'Update',$userid);
			}
			else
			{
				$result=array(
				'error_number' 	=> $error['code'],
				'error_message' => $error['message']
				);
			}
		}
		
		$this->db->trans_complete();
		return $result;	
	}
	
	function cashonhand($branch,$date,$amount,$remarks,$userid)
	{
		$result=null;
		
		$data = array(
			'branchid'			=> $branch,		
			'date' 				=> $date,
			'amount' 			=> $amount,
			'remarks' 			=> $remarks,
			'entryuserid' 		=> $userid,
			'entrydate' 		=>  date("Y-m-d H:i:s")
		);

		$this->db->insert('tbl_branches_cashonhand',$data);
		$error = $this->db->error(); 
		if ($error['code']==0)
		{
			$result=array(
				'error_number' 	=> 0,
				'error_message' => 'success'
			);
			$this->inserttracer('Cash on Hand',$returnid,$this->db->last_query(),'Update',$userid);
		}
		else
		{
			$result=array(
			'error_number' 	=> $error['code'],
			'error_message' => $error['message']
			);
		}
			
		$this->db->trans_complete();
		return $result;	
		
	}
	
	
	//-------------------------------------------------------------------------------DELETE-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------DELETE-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------DELETE-------------------------------------------------------------------------------
	
	
	function deleteexpenses($id,$userid)
	{
		$this->db->trans_start();
		
		$this->db->where('expensesid',$id);
		$this->db->delete('tbl_branches_expenses');	
		
		$result=null;
		$error = $this->db->error(); 
		if ($error['code']==0)
		{	
			$result=array(
				'error_number' 	=> 0,
				'error_message' => 'success'
			);
			$this->inserttracer('Expenses',$id,$this->db->last_query(),'Delete',$userid);
		}	
		else
		{
			$result=array(
			'error_number' 	=> $error['code'],
			'error_message' => $error['message']
			);
		}
		$this->db->trans_complete();
		return $result;	
	}
	
	function deleteremittance($id,$userid)
	{
		$this->db->trans_start();
		
		$this->db->where('remittanceid',$id);
		$this->db->delete('tbl_branches_remittances');	
		
		$result=null;
		$error = $this->db->error(); 
		if ($error['code']==0)
		{	
			$result=array(
				'error_number' 	=> 0,
				'error_message' => 'success'
			);
			$this->inserttracer('Remittance',$id,$this->db->last_query(),'Delete',$userid);
		}	
		else
		{
			$result=array(
			'error_number' 	=> $error['code'],
			'error_message' => $error['message']
			);
		}
		$this->db->trans_complete();
		return $result;	
	}
	
	function inserttracer($category,$id,$description,$transtype,$userid)
	{
		$data = array(
		'category' 			=> $category,
		'identifierid'		=> $id,
		'description' 		=> $description,
		'transtype' 		=> $transtype,
		'transdate' 		=> date("Y-m-d H:i:s"),
		'transuserid' 		=> $userid
		);
		$this->db->insert('tbl_tracer',$data);
	}
}